# Symfony Standard Edition

## Parcticipants

De Sousa Damien

Barcelo Cyril
	
## Compte d'accès

Nom d'utilisateur : barceloc

mot de passe : barcelo
	
## Travail

Toutes les fonctionnalités demandées ont été réalisées.

En plus du travail demandé nous avons réalisé les fonctionnalités suivantes :
* Nous avons ajouté la possibilité d'associer une image au compte utilisateur dans l'onglet profil. (Nous n'avons pas utilisé de service externe, les photos sont stockées sur Heroku)
* Si l'utilisateur a une photo de profil, cette dernière est affichée sur ses posts, sinon son nom est affiché.
* Nous avons utilisé Materialize comme framework CSS, que nous avons appris à utiliser pour l'occasion.
* Nous avons mis en place un système de recherche de post par titre ou date de publication.
* Quand un utilisateur est connecté, on affiche la liste de tous ses posts en plus de la liste des dix dernières publications.
* Nous avons ajouté un système de pagination pour l'affichage des dix dernières publications sur la page d'accueil (uniquement quand l'utilisateur est connecté).
* Le site détecte la langue utilisé par le navigateur et peut traduire le site dans deux langues différentes : le Français et l'Anglais.
* Utilisation de FormBuilder pour la création et l'édition d'un post. Nous l'avons aussi utilisé pour étendre le formulaire de mise à jour du profil pour ajouter une image.
* Nous avons créé un service qui permet de générer des url-alias unique.
* Pour pouvoir associer un utilisateur à un post nous avons utilisé une relation bidirectionnelle entre un Post et un User.

# Annexes

## URL du site hébergé sur heroku

[https://damien-desousa-blog.herokuapp.com](https://damien-desousa-blog.herokuapp.com)

## Lignes de commandes utiles

### Installer le client heroku

Rendez-vous à l'adresse suivante: [ici](https://devcenter.heroku.com/articles/heroku-cli#download-and-install)

### Définir un nouveau dépot distant

`heroku git:remote -a projectName`

### Génération d'une clée SSH

Dans un terminal Git bash: `ssh-keygen`

### Push le projet sur heroku:

`git add .`

`git commit -m "message"`

`git push heroku master`

### Mettre à jour la base de données distante

La première ligne crée le schéma SQL.

`heroku run php bin/console doctrine:schema:create`

La deuxième ligne met à jour le schéma relationnel.

`heroku run php bin/console doctrine:schema:update --force`