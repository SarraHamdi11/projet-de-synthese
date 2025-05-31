<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            {{ __('Modifier mes informations') }}
        </h2>
    </x-slot>

    @section('content')
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-lg rounded-lg">
                        <div class="card-body p-4">
                            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="row align-items-center mb-4">
                                    <div class="col-md-4 text-center mb-3 mb-md-0">
                                        <div class="d-flex flex-column align-items-center">
                                            <img id="profile_picture_preview" src="{{ $user->photodeprofil_uti ? asset('storage/' . $user->photodeprofil_uti) : asset('images/default-avatar.png') }}" alt="Profile Picture" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                            <input id="photodeprofil_uti" name="photodeprofil_uti" type="file" class="d-none" onchange="previewImage(event)">
                                            <label for="photodeprofil_uti" class="btn btn-primary">{{ __('Importer photo de profile') }}</label>
                                            @error('photodeprofil_uti')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="nom_uti" class="form-label">{{ __('Nom') }}</label>
                                                <input id="nom_uti" name="nom_uti" type="text" class="form-control" value="{{ old('nom_uti', $user->nom_uti) }}" required autofocus autocomplete="nom_uti">
                                                @error('nom_uti')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="prenom" class="form-label">{{ __('Prénom') }}</label>
                                                <input id="prenom" name="prenom" type="text" class="form-control" value="{{ old('prenom', $user->prenom) }}" required autocomplete="prenom">
                                                @error('prenom')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="ville" class="form-label">{{ __('Ville') }}</label>
                                                <input id="ville" name="ville" type="text" class="form-control" value="{{ old('ville', $user->ville) }}" required autocomplete="ville">
                                                @error('ville')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="date_naissance" class="form-label">{{ __('Date de naissance') }}</label>
                                                <input id="date_naissance" name="date_naissance" type="date" class="form-control" value="{{ old('date_naissance', optional($user->date_naissance)->format('Y-m-d')) }}" required autocomplete="date_naissance">
                                                @error('date_naissance')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="email_uti" class="form-label">{{ __('Adresse e-mail') }}</label>
                                                <input id="email_uti" name="email_uti" type="email" class="form-control" value="{{ old('email_uti', $user->email_uti) }}" required autocomplete="email_uti">
                                                @error('email_uti')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="tel_uti" class="form-label">{{ __('Numero de telephone') }}</label>
                                                <input id="tel_uti" name="tel_uti" type="text" class="form-control" value="{{ old('tel_uti', $user->tel_uti) }}" required autocomplete="tel_uti">
                                                @error('tel_uti')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary me-2">{{ __('Valider les modifications') }}</button>

                                    @if (session('status') === 'profile-updated')
                                        <p class="text-success mb-0">
                                            {{ __('Saved.') }}
                                        </p>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    const output = document.getElementById('profile_picture_preview');
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
    @endsection
</x-app-layout>
