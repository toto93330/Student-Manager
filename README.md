**Contexte :**

Student-Manager est un système de gestion d'éléves pour mon mentorat chez openclassrooms.

# SCREENSHOT  / CAPTURE D'ÉCRAN

![enter image description here](https://i.ibb.co/NxVZg9F/Sans-titre-2.jpg)

## INSTALL / INSTALLATION

Clonez ou téléchargez le repository GitHub dans le dossier voulu :
```sh
git clone https://github.com/toto93330/Student-Manager
```
Configurez vos variables d'environnement tel que la connexion à la base de données ou votre serveur SMTP ou adresse mail dans le fichier .env.local qui devra être crée à la racine du projet en réalisant une copie du fichier .env.

Téléchargez et installez les dépendances back-end du projet avec Composer :
```sh
composer install
```
Téléchargez et installez les dépendances front-end du projet avec Npm :
```sh
npm install
```
Créer un build d'assets (grâce à Webpack Encore) avec Npm :
```sh
npm run build
```
Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :
```sh
php bin/console doctrine:database:create
```
Créez les différentes tables de la base de données en appliquant les migrations :
```sh
php bin/console doctrine:migrations:migrate
```
(Optionnel) Installer les fixtures pour avoir une démo de données fictives :
```sh
php bin/console doctrine:fixtures:load
```
(Optionnel) Si vous utilisez les fixtures voici l'identifiant administrateur :

```sh
contact@anthonyalves.fr
```
```sh
root
```

Félications le projet est installé correctement, vous pouvez désormais commencer à l'utiliser à votre guise !
