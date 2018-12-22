# Symfony Standard Edition

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