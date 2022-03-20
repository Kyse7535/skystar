## Démarrer le projet complet

- Rajouter le fichier .env ci-suit (modifiable en fonction de vos besoins) :

```
# ports
APP_PORT_LOCAL=4200
API_PORT_LOCAL=8000
DB_PORT_LOCAL=5432
ADMINER_PORT_LOCAL=8080
```

- docker-compose up -d

### Pour accéder a la base via adminer

- localhost:{ADMINER_PORT_LOCAL}
- système : postgresql
- serveur : db
- user : user
- password : pswd
- base de donnée : skystar

### Dans le cas ou vous avez besoin de générer le script DB

_le docker de la base de donnée doit être lancée_

_vous devez avoir pip d'installer sur votre machine, je n'es pas encore de Docker pour cette partie_

- cd db/scripts
- source venv/bin/activate activate
- ./generate-insert.py

### Pour démarrer le projet symfony

Accéder au projet Symfony :

- localhost:{API_PORT_LOCAL}

### Pour démarrer le projet angular

Accéder au projet Angular :

- Modifier l'URL de l'api dans src/environnements/environnement.ts avec le port {API_PORT_LOCAL}
- localhost:{APP_PORT_LOCAL}

Si vous avez besoin d'installer un package (comme material-ui par exemple)

- ouvrir une commande bash dans le container app et dans le dossier /app : ng add _nom-du-package_
- redémarrer le container Docker

### Issues

Si vous rencontrez un problème après un git pull :

- Supprimer le container
- Supprimer l'image
- docker system prune
- docker volume prune
- docker-compose up -d

Parfois, un problème de cache avec composer sur Symfony, dans ce cas :

- Accéder en bash sur le container API
- symfony composer install
