-- Ajout des séquences PostgreSQL

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