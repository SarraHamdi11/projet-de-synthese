@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4" style="color:#244F76; font-weight:bold; font-size:2rem;">Changer le mot de passe :</h2>
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-lg rounded-4 border-0" style="background: #fff;">
                <div class="card-body p-5">
                    <form method="post" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('put')
                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ __('Saved.') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="mb-3">
                            <input id="current_password" name="current_password" type="password" autocomplete="current-password" required class="form-control rounded-3 text-center" style="border:1.5px solid #7C9FC0; background:#f8fafc;" placeholder="Mot de passe actuel">
                            <div class="form-text text-center">Oublier le mot de passe</div>
                            @error('current_password', 'updatePassword')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input id="password" name="password" type="password" autocomplete="new-password" required class="form-control rounded-3 text-center" style="border:1.5px solid #7C9FC0; background:#f8fafc;" placeholder="Nouveau mot de passe">
                            @error('password', 'updatePassword')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="form-control rounded-3 text-center" style="border:1.5px solid #7C9FC0; background:#f8fafc;" placeholder="Confirmer le nouveau mot de passe">
                            @error('password_confirmation', 'updatePassword')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn" style="background:#7C9FC0; color:#fff; font-weight:600;">Valider les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 