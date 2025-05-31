<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            {{ __('Changer le mot de passe') }}
        </h2>
    </x-slot>

    @section('content')
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg rounded-lg">
                        <div class="card-body p-4">
                            <h2 class="h5 text-center mb-4">{{ __('Changer le mot de passe') }}</h2>
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
                                    <label for="current_password" class="form-label sr-only">{{ __('Mot de passe actuel') }}</label>
                                    <input id="current_password" name="current_password" type="password" autocomplete="current-password" required class="form-control" placeholder="{{ __('Mot de passe actuel') }}">
                                    @error('current_password', 'updatePassword')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label sr-only">{{ __('Nouveau mot de passe') }}</label>
                                    <input id="password" name="password" type="password" autocomplete="new-password" required class="form-control" placeholder="{{ __('Nouveau mot de passe') }}">
                                    @error('password', 'updatePassword')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label sr-only">{{ __('Confirmer le nouveau mot de passe') }}</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="form-control" placeholder="{{ __('Confirmer le nouveau mot de passe') }}">
                                    @error('password_confirmation', 'updatePassword')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">{{ __('Valider les modifications') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout> 