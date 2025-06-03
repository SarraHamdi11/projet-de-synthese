<?php

namespace App\Http\Controllers\locataire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Logement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnonceLocataireController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // التأكد من أن المستخدم متصل
    }

    // ✅ Affichage الإعلانات ديال المستأجر
    public function index()
    {
        try {
            $userId = Auth::user()->id;
            if (Auth::user()->role_uti !== 'locataire') {
                return redirect()->back()->with('error', 'Accès réservé aux locataires.');
            }

            $annonces = Annonce::with('logement')
                ->where('proprietaire_id', $userId)
                ->latest()
                ->paginate(6);

            return view('locataire.annonceslocataire', compact('annonces'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la récupération des annonces: ' . $e->getMessage());
        }
    }

    // ✅ Enregistrement إعلان جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre_anno' => 'required|string|max:255',
            'description_anno' => 'required|string',
            'type_log' => 'required|in:studio,appartement,maison',
            'prix_log' => 'required|numeric|min:0',
            'ville' => 'required|string|max:255',
            'nombre_colocataire_log' => 'required|integer|min:1',
            'localisation_log' => 'required|string|max:255',
            'photos.*' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        try {
            if (Auth::user()->role_uti !== 'locataire') {
                return response()->json([
                    'message' => 'Accès réservé aux locataires.',
                    'success' => false,
                ], 403);
            }

            $userId = Auth::user()->id;
            if (!$userId) {
                throw new \Exception('ID de l\'utilisateur non trouvé.');
            }

            // إنشاء logement جديد
            $logement = new Logement();
            $logement->prix_log = $request->prix_log;
            $logement->localisation_log = $request->localisation_log;
            $logement->date_creation_log = now();
            $logement->type_log = $request->type_log;
            $logement->nombre_colocataire_log = $request->nombre_colocataire_log;
            $logement->ville = $request->ville;
            $logement->proprietaire_id = $userId;
            // Handle photos
            $photoPaths = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $imageName = time() . '_' . uniqid() . '.' . $photo->extension();
                    $photo->move(public_path('images'), $imageName);
                    $photoPaths[] = 'images/' . $imageName;
                }
            }
            $logement->photos = json_encode($photoPaths);
            $logement->save();

            // إنشاء annonce جديد
            $annonce = new Annonce();
            $annonce->titre_anno = $request->titre_anno;
            $annonce->description_anno = $request->description_anno;
            $annonce->date_publication_anno = now();
            $annonce->logement_id = $logement->id;
            $annonce->proprietaire_id = $userId;
            $annonce->statut_anno = 'active';
            $annonce->save();

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Annonce créée avec succès.',
                    'success' => true,
                    'annonce' => $annonce->load('logement'),
                ], 201);
            }

            return redirect()->back()->with('success', 'Annonce créée avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Erreur de validation.',
                    'success' => false,
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Erreur lors de la création: ' . $e->getMessage(),
                    'success' => false,
                ], 500);
            }
            return redirect()->back()->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    // ✅ Suppression إعلان
    public function destroy($id)
    {
        try {
            if (Auth::user()->role_uti !== 'locataire') {
                return response()->json([
                    'message' => 'Accès réservé aux locataires.',
                    'success' => false,
                ], 403);
            }

            $annonce = Annonce::findOrFail($id);
            $userId = Auth::user()->id;

            if ($annonce->proprietaire_id !== $userId) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Vous n'avez pas le droit de supprimer cette annonce."
                    ], 403);
                }
                return redirect()->back()->with('error', "Vous n'avez pas le droit de supprimer cette annonce.");
            }

            if ($annonce->logement && $annonce->logement->photos) {
                $photos = json_decode($annonce->logement->photos, true);
                if (!empty($photos)) {
                    foreach ($photos as $photo) {
                        Storage::disk('public')->delete($photo);
                    }
                }
            }

            if ($annonce->logement) {
                $annonce->logement->delete();
            }

            $annonce->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Annonce supprimée avec succès.'
                ], 200);
            }

            return redirect()->back()->with('success', 'Annonce supprimée.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression: ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    // ✅ تعديل إعلان
    public function edit($id)
    {
        try {
            if (Auth::user()->role_uti !== 'locataire') {
                return redirect()->back()->with('error', 'Accès réservé aux locataires.');
            }

            $annonce = Annonce::with('logement')->findOrFail($id);
            $userId = Auth::user()->id;

            if ($annonce->proprietaire_id !== $userId) {
                return redirect()->back()->with('error', 'Accès non autorisé à cette annonce.');
            }

            return view('locataire.modifierannoncelocataire', compact('annonce'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la récupération de l\'annonce: ' . $e->getMessage());
        }
    }

    // ✅ تحديث إعلان
    public function update(Request $request, $id)
    {
        $request->validate([
            'titre_anno' => 'required|string|max:255',
            'description_anno' => 'required|string',
            'type_log' => 'required|in:studio,appartement,maison',
            'prix_log' => 'required|numeric|min:0',
            'ville' => 'required|string|max:255',
            'nombre_colocataire_log' => 'required|integer|min:1',
            'localisation_log' => 'required|string|max:255',
        ]);

        try {
            if (Auth::user()->role_uti !== 'locataire') {
                return redirect()->back()->with('error', 'Accès réservé aux locataires.');
            }

            $annonce = Annonce::findOrFail($id);
            $userId = Auth::user()->id;

            if ($annonce->proprietaire_id !== $userId) {
                return redirect()->back()->with('error', 'Accès non autorisé à cette annonce.');
            }

            $logement = $annonce->logement;
            $logement->prix_log = $request->prix_log;
            $logement->localisation_log = $request->localisation_log;
            $logement->type_log = $request->type_log;
            $logement->nombre_colocataire_log = $request->nombre_colocataire_log;
            $logement->ville = $request->ville;
            $logement->save();

            $annonce->titre_anno = $request->titre_anno;
            $annonce->description_anno = $request->description_anno;
            $annonce->save();

            return redirect()->route('locataire.annonceslocataire.index')->with('success', 'Annonce mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }
}