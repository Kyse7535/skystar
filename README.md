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

- ouvrir une commande bash dans le container api et dans le dossier /app : symfony console d:m:m
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

Petit problème lié à Doctrine :

Doctrine génère bien les SEQUENCES, règles absolument nécessaire sous PostgreSQL, néanmoins la base de donnée ne l'es possède / sauvegarde pas, même après une migration.

Dans le doute, pensez a ajouter ces lignes :

```
CREATE SEQUENCE constellation_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE jeu_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE objet_distant_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE objet_proche_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE parcours_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE grouper_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE determiner_seq INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE constellation_id_constellation_seq;
SELECT setval('constellation_id_constellation_seq', (SELECT MAX(id_constellation) FROM constellation));
ALTER TABLE constellation ALTER id_constellation SET DEFAULT nextval('constellation_id_constellation_seq');

CREATE SEQUENCE jeu_id_jeu_seq;
SELECT setval('jeu_id_jeu_seq', (SELECT MAX(id_jeu) FROM jeu));
ALTER TABLE jeu ALTER id_jeu SET DEFAULT nextval('jeu_id_jeu_seq');

CREATE SEQUENCE objet_distant_id_objet_distant_seq;
SELECT setval('objet_distant_id_objet_distant_seq', (SELECT MAX(id_objet_distant) FROM objet_distant));
ALTER TABLE objet_distant ALTER id_objet_distant SET DEFAULT nextval('objet_distant_id_objet_distant_seq');

CREATE SEQUENCE parcours_id_parcours_seq;
SELECT setval('parcours_id_parcours_seq', (SELECT MAX(id_parcours) FROM parcours));
ALTER TABLE parcours ALTER id_parcours SET DEFAULT nextval('parcours_id_parcours_seq');

CREATE SEQUENCE grouper_id_objet_distant_seq;
SELECT setval('grouper_id_objet_distant_seq', (SELECT MAX(id_objet_distant) FROM grouper));
ALTER TABLE grouper ALTER id_objet_distant SET DEFAULT nextval('grouper_id_objet_distant_seq');

CREATE SEQUENCE objet_proche_id_objet_proche_seq;
SELECT setval('objet_proche_id_objet_proche_seq', (SELECT MAX(id_objet_proche) FROM objet_proche));
ALTER TABLE objet_proche ALTER id_objet_proche SET DEFAULT nextval('objet_proche_id_objet_proche_seq');

CREATE SEQUENCE determiner_id_objet_proche_seq;
SELECT setval('determiner_id_objet_proche_seq', (SELECT MAX(id_objet_proche) FROM determiner));
ALTER TABLE determiner ALTER id_objet_proche SET DEFAULT nextval('determiner_id_objet_proche_seq');
```
