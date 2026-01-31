@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Paramètres</h4>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-edit me-2"></i> Modifier le profil
                        </a>
                        <a href="{{ route('profile.password.form') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-key me-2"></i> Changer le mot de passe
                        </a>
                        <a href="{{ route('profile.delete.form') }}" class="list-group-item list-group-item-action text-danger">
                            <i class="fas fa-trash-alt me-2"></i> Supprimer le compte
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 