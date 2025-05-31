<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            {{ __('Supprimer mon compte') }}
        </h2>
    </x-slot>

    @section('content')
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg rounded-lg border-danger">
                        <div class="card-body p-4">
                            <h2 class="h5 text-center mb-4">{{ __('Supprimer le compte') }}</h2>

                            <div class="alert alert-warning" role="alert">
                                {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger les données ou informations que vous souhaitez conserver.') }}
                            </div>

                            @if (session('status') === 'account-deleted')
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ __('Saved.') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="post" action="{{ route('profile.destroy') }}">
                                @csrf
                                @method('delete')

                                <div class="mb-3">
                                    <label for="password" class="form-label sr-only">{{ __('Mot de passe') }}</label>
                                    <input id="password" name="password" type="password" required class="form-control" placeholder="{{ __('Mot de passe') }}">
                                    @error('password', 'deleteAccount')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-danger">{{ __('Supprimer le compte') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout> 