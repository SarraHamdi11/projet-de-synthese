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
                        <div class="mb-3 d-flex justify-content-center gap-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="confirm_delete" id="oui" value="oui" required>
                                <label class="form-check-label" for="oui">OUI</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="confirm_delete" id="non" value="non" required>
                                <label class="form-check-label" for="non">NON</label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="reason" class="form-label" style="color:#244F76;">Raison de la suppression de compte</label>
                            <textarea id="reason" name="reason" rows="2" class="form-control rounded-3" style="border:1.5px solid #7C9FC0; background:#f8fafc;"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label" style="color:#244F76;">Mot de passe</label>
                            <input type="password" id="password" name="password" class="form-control rounded-3" required>
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="/" class="btn px-4 py-2" style="background:#7C9FC0; color:#fff; font-weight:600; border-radius: 8px;">Annuler</a>
                            <button type="submit" class="btn px-4 py-2" style="background:#7C9FC0; color:#fff; font-weight:600; border-radius: 8px;">Valider les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 