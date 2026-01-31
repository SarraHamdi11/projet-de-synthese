<?php

namespace App\Http\Controllers\Proprietaire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\Logement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewAnnonceNotification;
class AnnonceProprietaireController extends Controller
{
    public function index()
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                Log::warning('Utilisateur non authentifié tentant d\'accéder aux annonces');
                return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à vos annonces');
            }

            $annonces = Annonce::with('logement')
                ->where('proprietaire_id', $userId)
                ->where('statut_anno', 'disponible')
                ->orderBy('date_publication_anno', 'desc')
                ->paginate(6);

            Log::info('Annonces récupérées pour l\'utilisateur: ' . $userId . ', Nombre: ' . $annonces->count());
            return view('proprietaire.annoncesproprietaire', compact('annonces'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des annonces: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la récupération de vos annonces.');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Début store method pour enregistrer une annonce.', ['request' => $request->all()]);

            if (!Auth::check()) {
                Log::warning('Tentative d\'enregistrement d\'annonce sans authentification');
                return response()->json(['success' => false, 'message' => 'Vous devez être connecté pour créer une annonce'], 401);
            }

            $validated = $request->validate([
                'titre_anno' => 'required|string|max:255',
                'prix_log' => 'required|numeric|min:0',
                'localisation_log' => 'required|string|max:255',
                'type_log' => 'required|in:studio,appartement,maison',
                'ville' => 'required|string|max:255',
                'nombre_colocataire_log' => 'required|integer|min:1',
                'etage' => 'nullable|integer|min:0',
                'equipements' => 'nullable|array',
                'photos.*' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ], [
                'titre_anno.required' => 'Le titre de l\'annonce est obligatoire.',
                'prix_log.required' => 'Le prix est obligatoire.',
                'prix_log.numeric' => 'Le prix doit être un nombre.',
                'prix_log.min' => 'Le prix doit être positif.',
                'localisation_log.required' => 'La localisation est obligatoire.',
                'type_log.required' => 'Le type de logement est obligatoire.',
                'ville.required' => 'La ville est obligatoire.',
                'nombre_colocataire_log.required' => 'Le nombre de colocataires est obligatoire.',
                'nombre_colocataire_log.integer' => 'Le nombre de colocataires doit être un nombre entier.',
                'nombre_colocataire_log.min' => 'Le nombre de colocataires doit être au moins 1.',
                'etage.integer' => 'L\'étage doit être un nombre entier.',
                'etage.min' => 'L\'étage doit être positif ou nul.',
                'photos.*.required' => 'Veuillez uploader au moins une photo.',
                'photos.*.mimes' => 'Les fichiers doivent être des images (jpg, jpeg, png, gif, svg).',
                'photos.*.max' => 'La taille de chaque image ne doit pas dépasser 2Mo.',
            ]);

            DB::beginTransaction();

            // Créer Logement
            $logement = new Logement();
            $logement->prix_log = $request->prix_log;
            $logement->localisation_log = $request->localisation_log;
            $logement->date_creation_log = now();
            $logement->type_log = $request->type_log;
            $logement->ville = $request->ville;
            $logement->nombre_colocataire_log = $request->nombre_colocataire_log;
            $logement->etage = $request->etage;
            $logement->equipements = json_encode($request->equipements ?? []);
            $logement->proprietaire_id = Auth::id();

            // Gérer les photos
            $photoPaths = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $imageName = time() . '_' . uniqid() . '.' . $photo->extension();
                    $photo->move(public_path('images'), $imageName);
                    $photoPaths[] = 'images/' . $imageName;
                }
                $logement->photos = json_encode($photoPaths);
            }

            $logement->save();
            Log::info('Logement créé avec succès, ID: ' . $logement->id);

            // Créer Annonce
            $annonce = new Annonce();
            $annonce->titre_anno = $request->titre_anno;
            $annonce->description_anno = 'Description par défaut';
            $annonce->statut_anno = 'disponible';
            $annonce->date_publication_anno = now();
            $annonce->logement_id = $logement->id; // صلحت هنا، كان خطأ فالكود الأصلي
            $annonce->proprietaire_id = Auth::id();
            $annonce->save();
            Log::info('Annonce créée avec succès, ID: ' . $annonce->id);

            DB::commit();

            // Trigger NewAnnonceNotification after successful creation
            Auth::user()->notify(new \App\Notifications\NewAnnonceNotification($annonce->titre_anno));

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Annonce créée avec succès.',
                    'annonce' => $annonce->load('logement'),
                ], 201);
            }
            return redirect()->back()->with('success', 'Annonce créée avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Échec de validation: ', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Problème de validation, vérifiez les données.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'enregistrement: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'enregistrement: ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if (!Auth::check()) {
                Log::warning('Tentative de mise à jour d\'annonce sans authentification');
                return response()->json(['success' => false, 'message' => 'Vous devez être connecté pour modifier une annonce'], 401);
            }

            $validated = $request->validate([
                'titre_anno' => 'required|string|max:255',
                'prix_log' => 'required|numeric|min:0',
                'localisation_log' => 'required|string|max:255',
                'equipements' => 'nullable|array',
                'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048', // nullable لأنه اختياري فالتعديل
            ]);

            $annonce = Annonce::with('logement')->findOrFail($id);

            if ($annonce->proprietaire_id !== Auth::id()) {
                Log::warning('Tentative de mise à jour non autorisée. User ID: ' . Auth::id() . ', Annonce ID: ' . $id);
                return response()->json(['success' => false, 'message' => 'Vous n\'êtes pas autorisé à modifier cette annonce'], 403);
            }

            DB::beginTransaction();

            // Mettre à jour Logement
            $logement = $annonce->logement;
            $logement->prix_log = $request->prix_log;
            $logement->localisation_log = $request->localisation_log;
            $logement->type_log = $logement->type_log ?? 'appartement';
            $logement->ville = $logement->ville ?? 'Ville non spécifiée';
            $logement->nombre_colocataire_log = $logement->nombre_colocataire_log ?? 1;
            $logement->equipements = json_encode($request->equipements ?? []);
            $logement->proprietaire_id = Auth::id();

            // Gérer les photos existantes et les nouvelles
            $existingPhotos = json_decode($logement->photos ?? '[]', true);
            $updatedPhotos = $existingPhotos;

            // Gérer les photos à supprimer
            if ($request->has('deleted_photos') && is_array($request->input('deleted_photos'))) {
                $deletedPhotos = $request->input('deleted_photos');
                foreach ($deletedPhotos as $deletedPhotoPath) {
                    $key = array_search($deletedPhotoPath, $updatedPhotos);
                    if ($key !== false) {
                        // Remove from array
                        unset($updatedPhotos[$key]);
                        // Delete physical file
                        if (file_exists(public_path($deletedPhotoPath))) {
                            unlink(public_path($deletedPhotoPath));
                        }
                    }
                }
                // Re-index array after unsetting
                $updatedPhotos = array_values($updatedPhotos);
            }

            // Gérer les nouvelles photos
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $imageName = time() . '_' . uniqid() . '.' . $photo->extension();
                    // Store in public/images directory
                    $photo->move(public_path('images'), $imageName);
                    $newPhotoPath = 'images/' . $imageName; // Store path relative to public
                    $updatedPhotos[] = $newPhotoPath;
                }
            }

            // Mettre à jour la colonne photos du logement
            $logement->photos = json_encode($updatedPhotos);

            $logement->save();
            Log::info('Logement mis à jour avec succès, ID: ' . $logement->id);

            // Mettre à jour Annonce
            $annonce->titre_anno = $request->titre_anno;
            $annonce->description_anno = $annonce->description_anno ?? 'Description par défaut';
            $annonce->statut_anno = 'disponible';
            $annonce->save();
            Log::info('Annonce mise à jour avec succès, ID: ' . $annonce->id);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Annonce mise à jour avec succès.',
                    'annonce' => $annonce->load('logement'),
                ], 200);
            }
            return redirect()->route('proprietaire.annoncesproprietaire.index')->with('success', 'Annonce mise à jour avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Annonce non trouvée ID: ' . $id);
            return response()->json(['success' => false, 'message' => 'Annonce non trouvée'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Échec de validation: ', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Problème de validation, vérifiez les données.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            if (!Auth::check()) {
                Log::warning('Tentative de suppression d\'annonce sans authentification');
                return response()->json(['success' => false, 'message' => 'Vous devez être connecté pour supprimer une annonce'], 401);
            }

            $annonce = Annonce::with('logement')->findOrFail($id);

            if ($annonce->proprietaire_id !== Auth::id()) {
                Log::warning('Tentative de suppression non autorisée. User ID: ' . Auth::id() . ', Annonce ID: ' . $id);
                return response()->json(['success' => false, 'message' => 'Vous n\'êtes pas autorisé à supprimer cette annonce'], 403);
            }

            DB::beginTransaction();

            // Supprimer les photos
            if ($annonce->logement && $annonce->logement->photos) {
                foreach (json_decode($annonce->logement->photos, true) as $photo) {
                    if (file_exists(public_path($photo))) {
                        unlink(public_path($photo));
                    }
                }
                Log::info('Photos supprimées pour le logement ID: ' . $annonce->logement->id);
            }

            // Supprimer l'annonce
            $annonce->delete();
            Log::info('Annonce supprimée avec succès, ID: ' . $id);

            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Annonce supprimée avec succès.'], 200);
            }
            return redirect()->back()->with('success', 'Annonce supprimée avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Annonce non trouvée ID: ' . $id);
            return response()->json(['success' => false, 'message' => 'Annonce non trouvée'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la suppression: ' . $e->getMessage());
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            if (!Auth::check()) {
                Log::warning('Tentative d\'édition d\'annonce sans authentification');
                return redirect()->route('login')->with('error', 'Veuillez vous connecter pour modifier une annonce');
            }

            $annonce = Annonce::with('logement')->findOrFail($id);

            if ($annonce->proprietaire_id !== Auth::id()) {
                Log::warning('Tentative d\'édition non autorisée. User ID: ' . Auth::id() . ', Annonce ID: ' . $id);
                return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier cette annonce.');
            }

            return view('proprietaire.modifierannonceproprietaire', compact('annonce'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Annonce non trouvée ID: ' . $id);
            return redirect()->back()->with('error', 'Annonce non trouvée.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération de l\'annonce: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la récupération de l\'annonce.');
        }
    }
}