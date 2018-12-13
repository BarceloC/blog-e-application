# Symfony Standard Edition
--------------------------

## Lignes de commandes utiles
-----------------------------
### Définir un nouveau dépot distant

`heroku git:remote -a projectName`

### Push sur heroku:
`git add .`

`git commit -m "message"`

`git push heroku master`

### Mettre à jour la base de données distante

*La première ligne crée le schéma SQL.*

heroku run php bin/console doctrine:schema:create

*La deuxième ligne met à jour le schéma relationnel.*

heroku run php app/console doctrine:schema:update --force