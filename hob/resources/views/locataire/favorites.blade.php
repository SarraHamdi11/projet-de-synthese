@section('scripts')
    <script>
        function toggleFavorite(listingId) {
            const icon = document.querySelector(`[data-id="${listingId}"]`);
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!token) {
                console.error("Jeton CSRF non trouvé.");
                return;
            }

            fetch(`{{ route('favorite.toggle', ['id' => '']) }}${listingId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Erreur réseau: ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    icon.setAttribute('data-favorited', data.is_favorited ? 'true' : 'false');
                    icon.style.color = data.is_favorited ? '#e74c3c' : '#ccc';
                    if (!data.is_favorited) {
                        icon.closest('.listing-card').remove();
                    }
                } else {
                    console.error('Échec de la mise à jour des favoris:', data);
                }
            })
            .catch(function(error) {
                console.error('Erreur lors de la requête:', error);
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            const favoriteIcons = document.querySelectorAll('.favorite-icon');
            if (favoriteIcons.length === 0) {
                console.log("Aucune icône de favori trouvée.");
                return;
            }

            favoriteIcons.forEach(function(icon) {
                // Appliquer la couleur initiale
                if (icon.getAttribute('data-favorited') === 'true') {
                    icon.style.color = '#e74c3c';
                } else {
                    icon.style.color = '#ccc';
                }

                icon.addEventListener('click', function () {
                    const listingId = this.getAttribute('data-id');
                    toggleFavorite(listingId);
                });
            });
        });
    </script>
@endsection