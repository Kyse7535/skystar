## Démarrer le projet complet

- docker-compose up -d

### Pour accéder a la base via adminer

- localhost:8080
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

- localhost:8000

### Pour démarrer le projet angular

Accéder au projet Angular :

- localhost:4200

Si vous avez besoin d'installer un package (comme material-ui par exemple)

- ouvrir une commande bash dans le container app et dans le dossier /app : ng add _nom-du-package_
- redémarrer le container Docker
