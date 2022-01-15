FROM postgres:alpine3.15

COPY ./0-init.sql /docker-entrypoint-initdb.d/
# UN par UN pour l'ordre des données a insérer
COPY ./1-constellation.sql /docker-entrypoint-initdb.d/
COPY ./2-objet_distant.sql /docker-entrypoint-initdb.d/
COPY ./3-objet_proche.sql /docker-entrypoint-initdb.d/
COPY ./4-determiner.sql /docker-entrypoint-initdb.d/
COPY ./5-grouper.sql /docker-entrypoint-initdb.d/