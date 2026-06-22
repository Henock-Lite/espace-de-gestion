#  Espace de Gestion

Ce guide vous explique comment récupérer, installer et lancer le projet localement.

##  Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- PHP (version recommandée : **8.2+**)
- Composer
- Node.js & NPM
- MySQL ou MariaDB
- Mailpit (pour les tests d'e-mails en local)

---

##  Récupération et Installation

Exécutez les commandes suivantes pas à pas dans votre terminal.

### 1. Cloner le projet

```bash
git clone https://github.com/Henock-Lite/espace-de-gestion.git
cd espace-de-gestion
```

### 2. Installer les dépendances PHP (Laravel)

```bash
composer install
```

### 3. Installer les dépendances Frontend (Tailwind CSS v4, DaisyUI, Alpine.js)

```bash
npm install
```

### 4. Configurer l'environnement

Copiez le fichier d'exemple pour créer votre fichier `.env` :

```bash
cp .env.example .env
```

Sous Windows :

```cmd
copy .env.example .env
```

Ouvrez ensuite le fichier `.env` et configurez vos accès à la base de données ainsi que Mailpit :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=votre_base_de_donnees
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe

MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Initialiser l'application

Générez la clé de sécurité :

```bash
php artisan key:generate
```

Exécutez les migrations :

```bash
php artisan migrate
```

le projet contient des seeders :

```bash
php artisan db:seed
```

Ou directement :

```bash
php artisan migrate --seed
```

### 6. Créer le lien de stockage

```bash
php artisan storage:link
```

---

##  Lancement de Mailpit (Local)

Lancez votre instance Mailpit :

### Avec Docker

```bash
docker run -d --name mailpit -p 1025:1025 -p 8025:8025 axllent/mailpit
```

Interface web :

```text
http://localhost:8025
```

Tous les e-mails envoyés par l'application seront visibles dans cette interface.

---

##  Lancement de l'Application

Ouvrez deux terminaux distincts.

### Terminal 1 — Backend Laravel

```bash
php artisan serve
```

Application accessible sur :

```text
http://127.0.0.1:8000
```

### Terminal 2 — Frontend Vite

```bash
npm run dev
```

---

##  Technologies utilisées

### Backend

- Laravel (dernière version stable)
- PHP
- MySQL

### Frontend

- Tailwind CSS v4
- DaisyUI
- Alpine.js
- Vite

### Outils

- Composer
- NPM
- Mailpit

---

##  Commandes utiles

### Vider les caches Laravel

```bash
php artisan optimize:clear
```

### Vérifier les routes

```bash
php artisan route:list
```

### Vérifier les migrations

```bash
php artisan migrate:status
```

### Recréer complètement la base de données

 Cette commande supprime toutes les données existantes.

```bash
php artisan migrate:fresh --seed
```

### Compiler les assets pour la production

```bash
npm run build
```

---

## Développement

Pour lancer simultanément Laravel, Vite et les autres services de développement :

```bash
composer run dev
```

---

##  Licence

Projet réalisé dans le cadre d'un apprentissage et d'exercices de développement avec Laravel.
