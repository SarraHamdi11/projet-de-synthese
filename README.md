# FindStay - Application de Colocation

Une plateforme web moderne pour la gestion des logements en colocation, développée avec Laravel 12.

## 🌟 Fonctionnalités

### 🔐 Authentification & Gestion des Utilisateurs
- **Inscription multi-rôles** : Locataire, Colocataire, Propriétaire, Admin
- **Connexion sécurisée** avec validation des identifiants
- **Gestion des profils** avec photos de profil
- **Tableaux de bord personnalisés** selon le rôle

### 🏠 Gestion des Logements
- **Publication d'annonces** par les propriétaires
- **Recherche et filtrage** des logements
- **Détails complets** avec photos et équipements
- **Système de réservations** pour les locataires
- **Gestion des favoris** pour sauvegarder les logements

### 📝 Système d'Avis
- **Avis et évaluations** des logements
- **Commentaires** avec photos de profil
- **Affichage conditionnel** des avis

### 🎨 Interface Utilisateur
- **Design moderne et responsive**
- **Interface intuitive** avec animations fluides
- **Messages d'erreur** clairs et informatifs
- **Navigation fluide** entre les sections

## 🛠️ Stack Technique

### Backend
- **Framework** : Laravel 12
- **Base de données** : SQLite
- **Authentification** : Custom AuthController
- **Relations** : Eloquent ORM

### Frontend
- **Template Engine** : Blade
- **CSS Framework** : Custom CSS avec variables CSS
- **JavaScript** : Vanilla JS + jQuery
- **Icons** : Font Awesome

### Développement
- **Version Control** : Git
- **Package Manager** : Composer
- **Environment** : PHP 8.3.6

## 📋 Prérequis

- PHP 8.3+
- Composer
- SQLite3
- Serveur web (Apache/Nginx)

## 🚀 Installation

### 1. Cloner le Repository
```bash
git clone https://github.com/SarraHamdi11/projet-de-synthese.git
cd projet-de-synthese/hob
```

### 2. Installer les Dépendances
```bash
composer install
```

### 3. Configuration de l'Environnement
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Base de Données
```bash
php artisan migrate
php artisan db:seed
```

### 5. Lien de Stockage
```bash
php artisan storage:link
```

### 6. Nettoyer le Cache
```bash
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear
```

### 7. Démarrer le Serveur
```bash
php artisan serve --port=8003
```

## 👤 Utilisateurs de Test

### Comptes Prédéfinis
- **Admin** : `admin@example.com` / `admin123`
- **Propriétaire** : `proprio@example.com` / `proprio123`
- **Locataire** : `test@example.com` / `password123`

## 📁 Structure du Projet

```
hob/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php          # Gestion authentification
│   │   ├── proprietaire/               # Contrôleurs propriétaires
│   │   ├── locataire/                  # Contrôleurs locataires
│   │   └── Admin/                      # Contrôleurs admin
│   └── Models/
│       ├── Utilisateur.php             # Modèle utilisateur
│       ├── Logement.php                # Modèle logement
│       └── Annonce.php                 # Modèle annonce
├── resources/views/
│   ├── auth/                           # Vues authentification
│   ├── proprietaire/                   # Vues propriétaires
│   ├── locataire/                      # Vues locataires
│   └── layouts/                        # Layouts communs
├── public/
│   └── images/                         # Images statiques
└── storage/
    └── app/public/                     # Fichiers uploadés
```

## 🔧 Configuration

### Variables d'Environnement Clés
```env
APP_NAME=FindStay
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8003

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

SESSION_DRIVER=file
FILESYSTEM_DISK=public
```

## 🐛 Corrections Récemment Appliquées

### ✅ Authentification & Connexion
- **Redirections fonctionnelles** après inscription/connexion
- **Validation des photos de profil** (limite 2MB)
- **Route de déconnexion** corrigée (POST au lieu de GET)
- **Gestion améliorée des erreurs** avec messages clairs

### ✅ Affichage & Interface
- **Texte de bienvenue** amélioré (plus grand, blanc, visible)
- **Affichage des images** des logements et profils
- **Correction des erreurs Blade** (@forelse malformé)
- **Relations modèles** correctement configurées

### ✅ Vues & Contrôleurs
- **Vue proprietaire.logements** retrouvée et corrigée
- **Relations Logement-Annonce** correctement implémentées
- **Gestion des avis** avec vérifications nulles
- **Images par défaut** ajoutées (avatar, placeholder)

## 🎯 Routes Principales

### Authentification
- `GET /login` - Page de connexion
- `POST /login` - Traitement connexion
- `GET /signup` - Page d'inscription
- `POST /signup` - Traitement inscription
- `POST /logout` - Déconnexion

### Tableaux de Bord
- `/admin/dashboard` - Dashboard admin
- `/proprietaire/accueilproprietaire` - Dashboard propriétaire
- `/locataire/accueillocataire` - Dashboard locataire

### Logements
- `/proprietaire/logements` - Liste logements propriétaire
- `/proprietaire/details/{id}` - Détails logement propriétaire
- `/locataire/details/{id}` - Détails logement locataire

## 🔄 Déploiement

### En Production
1. Configurer les variables d'environnement
2. Exécuter `php artisan config:cache`
3. Exécuter `php artisan route:cache`
4. Configurer le serveur web pour pointer vers `/public`
5. Assurer les permissions correctes sur `/storage`

## 🤝 Contributeurs

- **Sarra Hamdi** - Développeuse principale

## 📄 Licence

Ce projet est sous licence MIT.

## 📞 Support

Pour toute question ou problème, veuillez créer une issue sur le repository GitHub.

---

**FindStay** - Votre plateforme de confiance pour la colocation moderne 🏠✨
# Deploy trigger
