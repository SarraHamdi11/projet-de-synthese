<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Annonce;
use App\Models\Reservation;
use App\Models\Avis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Exports\UsersExport;
use App\Exports\AnnoncesExport ; 
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role_uti !== 'admin') {
                return redirect()->route('visitor')->with('error', 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    public function dashboard(Request $request)
    {
        $year = $request->input('year', '');
        $month = $request->input('month', '');

        $monthMap = [
            'Janvier' => 1, 'Février' => 2, 'Mars' => 3, 'Avril' => 4, 'Mai' => 5, 'Juin' => 6,
            'Juillet' => 7, 'Août' => 8, 'Septembre' => 9, 'Octobre' => 10, 'Novembre' => 11, 'Décembre' => 12
        ];
        $monthNumber = $month ? ($monthMap[$month] ?? null) : null;

        $totalUsers = Utilisateur::count();
        $totalUsersLastWeek = Utilisateur::where('date_inscription_uti', '>=', now()->subWeek())->count();
        $usersPercentageChange = $totalUsers > 0 ? round(($totalUsersLastWeek / $totalUsers) * 100, 1) : 0;

        $totalListings = Annonce::count();
        $totalListingsLastWeek = Annonce::where('created_at', '>=', now()->subWeek())->count();
        $listingsPercentageChange = $totalListings > 0 ? round(($totalListingsLastWeek / $totalListings) * 100, 1) : 0;

        $totalReservations = Reservation::count();
        $totalReservationsLastWeek = Reservation::where('created_at', '>=', now()->subWeek())->count();
        $reservationsPercentageChange = $totalReservations > 0 ? round(($totalReservationsLastWeek / $totalReservations) * 100, 1) : 0;

        $totalAcceptedReservations = Reservation::where('statut_res', 'acceptee')->count();
        $totalAcceptedLastWeek = Reservation::where('statut_res', 'acceptee')
            ->where('created_at', '>=', now()->subWeek())
            ->count();
        $acceptedPercentageChange = $totalAcceptedReservations > 0 ? round(($totalAcceptedLastWeek / $totalAcceptedReservations) * 100, 1) : 0;

        $totalRefusedReservations = Reservation::where('statut_res', 'annulee')->count();
        $totalRefusedLastWeek = Reservation::where('statut_res', 'annulee')
            ->where('created_at', '>=', now()->subWeek())
            ->count();
        $refusedPercentageChange = $totalRefusedReservations > 0 ? round(($totalRefusedLastWeek / $totalRefusedReservations) * 100, 1) : 0;

        Log::info('Dashboard Stats: ' . json_encode([
            'totalUsers' => $totalUsers,
            'totalListings' => $totalListings,
            'totalReservations' => $totalReservations,
            'totalAcceptedReservations' => $totalAcceptedReservations,
            'totalRefusedReservations' => $totalRefusedReservations
        ]));

        $newUsersByMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $query = Utilisateur::whereMonth('date_inscription_uti', $i);
            if ($year) {
                $query->whereYear('date_inscription_uti', $year);
            }
            $newUsersByMonth[] = $query->count();
        }

        $newListingsByMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $query = Annonce::whereMonth('created_at', $i);
            if ($year) {
                $query->whereYear('created_at', $year);
            }
            $newListingsByMonth[] = $query->count();
        }

        $topCitiesData = Utilisateur::select('ville')
            ->groupBy('ville')
            ->orderByRaw('COUNT(*) DESC')
            ->take(4)
            ->get();
        $topCities = $topCitiesData->pluck('ville')->toArray();
        $topCitiesCounts = [];
        foreach ($topCitiesData as $city) {
            $topCitiesCounts[] = Utilisateur::where('ville', $city->ville)->count();
        }

        $recentUsers = Utilisateur::orderBy('date_inscription_uti', 'desc')
            ->take(8)
            ->get(['nom_uti', 'prenom']);

        $recentListings = Annonce::orderBy('created_at', 'desc')
            ->take(8)
            ->get(['titre_anno', 'description_anno']);

        Log::info('Dashboard Data: ' . json_encode([
            'topCities' => $topCities,
            'topCitiesCounts' => $topCitiesCounts,
            'recentUsers' => $recentUsers,
            'recentListings' => $recentListings
        ]));

        $request->session()->put('admin_dashboard_year', $year);
        $request->session()->put('admin_dashboard_month', $month);
        Cookie::queue('last_admin_page', 'dashboard', 43200);

        return view('admin.dashboard', compact(
            'totalUsers', 'usersPercentageChange',
            'totalListings', 'listingsPercentageChange',
            'totalReservations', 'reservationsPercentageChange',
            'totalAcceptedReservations', 'acceptedPercentageChange',
            'totalRefusedReservations', 'refusedPercentageChange',
            'newUsersByMonth', 'newListingsByMonth',
            'topCities', 'topCitiesCounts',
            'recentUsers', 'recentListings',
            'year', 'month'
        ));
    }

    public function users(Request $request)
    {
        $search = $request->input('search', '');
        $role = $request->input('role', '');
        $year = $request->input('year', '');
        $month = $request->input('month', '');

        $monthMap = [
            'Janvier' => 1, 'Février' => 2, 'Mars' => 3, 'Avril' => 4, 'Mai' => 5, 'Juin' => 6,
            'Juillet' => 7, 'Août' => 8, 'Septembre' => 9, 'Octobre' => 10, 'Novembre' => 11, 'Décembre' => 12
        ];
        $monthNumber = $month ? ($monthMap[$month] ?? null) : null;

        $query = Utilisateur::query()
            ->withCount(['annonces' => function ($query) {
                $query->whereColumn('proprietaire_id', 'utilisateurs.id');
            }])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nom_uti', 'like', "%{$search}%")
                      ->orWhere('prenom', 'like', "%{$search}%")
                      ->orWhere('email_uti', 'like', "%{$search}%");
                });
            })
            ->when($role, function ($query, $role) {
                return $query->where('role_uti', $role);
            })
            ->when($year, function ($query, $year) {
                return $query->whereYear('date_inscription_uti', $year);
            })
            ->when($monthNumber, function ($query, $monthNumber) {
                return $query->whereMonth('date_inscription_uti', $monthNumber);
            })
            ->orderBy('date_inscription_uti', 'desc');

        $users = $query->paginate(10);

        // Add debugging logs
        foreach ($users as $user) {
            Log::info('Processing user: ' . json_encode($user));
            if ($user && $user->role_uti === 'proprietaire') {
                Log::info('Annonces for user: ' . $user->annonces()->count());
                $annonces = $user->annonces()->with('avis')->get();
                Log::info('Avis count: ' . ($annonces->isNotEmpty() ? $annonces->flatMap->avis->count() : 0));
                $averageNote = $annonces->isNotEmpty() ? $annonces->flatMap->avis->avg('note') : 0;
                $user->average_note = $averageNote;
            } else {
                $user->average_note = null;
            }
        }

        Log::info('Users: ' . json_encode($users));

        $request->session()->put('admin_users_search', $search);
        Cookie::queue('last_admin_page', 'users', 43200);

        return view('admin.users', compact('users', 'search', 'role', 'year', 'month'));
    }

    public function exportUsers()
    {
        $users = Utilisateur::query()
            ->withCount(['annonces' => function ($query) {
                $query->whereColumn('proprietaire_id', 'utilisateurs.id');
            }])
            ->with(['annonces.avis']) // Eager load avis
            ->orderBy('date_inscription_uti', 'desc')
            ->get();

        // Add debugging logs
        foreach ($users as $user) {
            Log::info('Processing user for export: ' . json_encode($user));
            if ($user && isset($user->role_uti) && $user->role_uti === 'proprietaire') {
                Log::info('Annonces for user (export): ' . ($user->annonces ? $user->annonces->count() : 0));
                $averageNote = $user->annonces && $user->annonces->isNotEmpty() ? $user->annonces->flatMap->avis->avg('note') : 0;
                Log::info('Avis count (export): ' . ($user->annonces && $user->annonces->isNotEmpty() ? $user->annonces->flatMap->avis->count() : 0));
                $user->average_note = $averageNote;
            } else {
                $user->average_note = null;
            }
        }

        return Excel::download(new UsersExport($users), 'users.xlsx');
    }

    public function deleteUser(Request $request, $id)
    {
        $user = Utilisateur::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();
        $request->session()->flash('success', 'Utilisateur supprimé avec succès.');

        return redirect()->route('admin.users');
    }

public function listings(Request $request)
{
    $search = $request->input('search', '');
    $type = $request->input('type', '');
    $status = $request->input('status', '');
    $ville = $request->input('ville', '');
    $date = $request->input('date', '');
    $sort = $request->input('sort_by_note', 'desc'); // Default to descending

    // Base query with relationships
    $listingsQuery = Annonce::with(['logement', 'proprietaire', 'avis'])
        ->select('annonces.*')
        ->leftJoin('avis', 'annonces.id', '=', 'avis.annonce_id')
        ->groupBy('annonces.id')
        ->when($search, function ($query, $search) {
            return $query->where('titre_anno', 'like', "%{$search}%")
                ->orWhereHas('proprietaire', function ($q) use ($search) {
                    $q->where('nom_uti', 'like', "%{$search}%")
                      ->orWhere('prenom', 'like', "%{$search}%");
                });
        })
        ->when($type, function ($query, $type) {
            return $query->whereHas('logement', function ($q) use ($type) {
                $q->where('type_log', $type);
            });
        })
        ->when($status, function ($query, $status) {
            return $query->where('statut_anno', $status);
        })
        ->when($ville, function ($query, $ville) {
            return $query->whereHas('logement', function ($q) use ($ville) {
                $q->where('ville', $ville);
            });
        })
        ->when($date, function ($query, $date) {
            return $query->whereDate('date_publication_anno', $date);
        });

    // Apply sorting by average_note using a subquery
    if ($request->has('sort_by_note')) {
        $listingsQuery->orderByRaw(
            '(SELECT AVG(note) FROM avis WHERE avis.annonce_id = annonces.id) ' . ($sort === 'desc' ? 'DESC' : 'ASC')
        );
    } else {
        $listingsQuery->orderBy('date_publication_anno', 'desc');
    }

    $listings = $listingsQuery->paginate(10);

    // Calculate average_note and nombre_locataire for each listing (post-query for display)
    foreach ($listings as $listing) {
        $avis = $listing->avis;
        $listing->average_note = $avis->isNotEmpty() ? $avis->avg('note') : 0;
        $listing->nombre_locataire = $listing->logement ? $listing->logement->nombre_colocataire_log : 0;
    }

    Log::info('Listings after sorting: ' . json_encode($listings->items()));
    Log::info('Sort parameter: ' . $sort);

    $request->session()->put('admin_listings_search', $search);
    Cookie::queue('last_admin_page', 'listings', 43200);

    return view('admin.listings', compact('listings', 'search', 'type', 'status', 'ville', 'date', 'sort'));
} // Add export method for listings
    public function exportListings()
    {
        $listings = Annonce::with(['logement', 'proprietaire', 'avis'])->get();
        foreach ($listings as $listing) {
            $listing->average_note = $listing->avis->isNotEmpty() ? $listing->avis->avg('note') : 0;
            $listing->nombre_locataire = $listing->logement->nombre_colocataire_log ?? 0;
        }
        return Excel::download(new AnnoncesExport($listings), 'listings.xlsx');
    }

    // Keep your existing deleteListing method
    public function deleteListing(Request $request, $id)
    {
        $listing = Annonce::findOrFail($id);
        $listing->delete();
        $request->session()->flash('success', 'Annonce supprimée avec succès.');
        return redirect()->route('admin.listings');
    }

    public function showListingDetail($id)
    {
        $listing = Annonce::with(['logement', 'proprietaire', 'avis'])->findOrFail($id);
        $listing->average_note = $listing->avis->isNotEmpty() ? $listing->avis->avg('note') : 0;
        return view('admin.listing-detail', compact('listing'));
    }
 }