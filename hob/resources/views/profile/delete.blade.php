@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4" style="color:#244F76; font-weight:bold; font-size:2rem;">Supprimer mon compte :</h2>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-lg rounded-4 border-0" style="background: #fff;">
                <div class="card-body p-5">
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                        <div class="mb-3 text-center" style="font-size:1.1rem; color:#244F76;">
                            Êtes-vous sûr(e) de vouloir supprimer définitivement votre compte ?<br>
                            <span style="font-size:0.95rem; color:#888;">Cette action est irréversible.</span>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label" style="color:#244F76;">Entrez votre mot de passe pour confirmer</label>
                            <input type="password" name="password" id="password" class="form-control rounded-3" style="border:1.5px solid #7C9FC0; background:#f8fafc;" required>
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="reason" class="form-label" style="color:#244F76;">Raison de la suppression de compte (optionnel)</label>
                            <textarea id="reason" name="reason" rows="2" class="form-control rounded-3" style="border:1.5px solid #7C9FC0; background:#f8fafc;"></textarea>
                        </div>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('profile.edit') }}" class="btn px-4 py-2" style="background:#7C9FC0; color:#fff; font-weight:600; border-radius: 8px;">Annuler</a>
                            <button type="submit" class="btn px-4 py-2" style="background:#dc3545; color:#fff; font-weight:600; border-radius: 8px;">Supprimer mon compte</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 