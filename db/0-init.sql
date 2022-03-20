-- Adminer 4.8.1 PostgreSQL 14.2 dump

DROP TABLE IF EXISTS "constellation";
CREATE TABLE "public"."constellation" (
    "id_constellation" integer NOT NULL,
    "latin_name" character(50),
    "observation_saison" character(100),
    "etoile_principale" character(40),
    "ra" numeric(10,5),
    "deca" numeric(10,5),
    "taille" numeric(15,5),
    "created" timestamp(0),
    "updated" timestamp(0),
    CONSTRAINT "constellation_pkey" PRIMARY KEY ("id_constellation")
) WITH (oids = false);

COMMENT ON COLUMN "public"."constellation"."created" IS '(DC2Type:datetime_immutable)';

COMMENT ON COLUMN "public"."constellation"."updated" IS '(DC2Type:datetime_immutable)';


DROP TABLE IF EXISTS "determiner";
CREATE TABLE "public"."determiner" (
    "id_objet_proche" integer NOT NULL,
    "id_constellation" integer NOT NULL,
    CONSTRAINT "determiner_pkey" PRIMARY KEY ("id_objet_proche", "id_constellation")
) WITH (oids = false);

CREATE INDEX "idx_59483ad816c461c1" ON "public"."determiner" USING btree ("id_objet_proche");

CREATE INDEX "idx_59483ad8e7d26b3" ON "public"."determiner" USING btree ("id_constellation");


DROP TABLE IF EXISTS "grouper";
CREATE TABLE "public"."grouper" (
    "id_objet_distant" integer NOT NULL,
    "id_constellation" integer NOT NULL,
    CONSTRAINT "grouper_pkey" PRIMARY KEY ("id_objet_distant", "id_constellation")
) WITH (oids = false);

CREATE INDEX "idx_2064564f1764d18b" ON "public"."grouper" USING btree ("id_objet_distant");

CREATE INDEX "idx_2064564fe7d26b3" ON "public"."grouper" USING btree ("id_constellation");


DROP TABLE IF EXISTS "jeu";
CREATE TABLE "public"."jeu" (
    "id_jeu" integer NOT NULL,
    "id_constellation" integer,
    "id_objet_distant" integer,
    "pseudo" character(20),
    "trouver" smallint,
    "duree" timestamp,
    "date_creation" timestamp,
    "created" timestamp,
    "updated" timestamp,
    "point" bigint,
    CONSTRAINT "jeu_pkey" PRIMARY KEY ("id_jeu")
) WITH (oids = false);

CREATE INDEX "i_fk_jeu_constellation" ON "public"."jeu" USING btree ("id_constellation");

CREATE INDEX "i_fk_jeu_objet_distant" ON "public"."jeu" USING btree ("id_objet_distant");


DROP TABLE IF EXISTS "objet_distant";
CREATE TABLE "public"."objet_distant" (
    "id_objet_distant" integer NOT NULL,
    "ra" numeric(10,5),
    "deca" numeric(10,5),
    "magnitude" numeric(10,3),
    "ra_radians" numeric(10,5),
    "dec_radians" numeric(10,5),
    "type" character(50),
    "created" timestamp,
    "updated" timestamp,
    CONSTRAINT "objet_distant_pkey" PRIMARY KEY ("id_objet_distant")
) WITH (oids = false);


DROP TABLE IF EXISTS "objet_proche";
CREATE TABLE "public"."objet_proche" (
    "id_objet_proche" integer NOT NULL,
    "nom" character(32),
    "magnitude" numeric(10,5),
    "ra" numeric(10,5),
    "deca" numeric(10,5),
    "type" character(32),
    "date_approbation" character(32),
    CONSTRAINT "objet_proche_pkey" PRIMARY KEY ("id_objet_proche")
) WITH (oids = false);


DROP TABLE IF EXISTS "parcours";
CREATE TABLE "public"."parcours" (
    "id_parcours" integer NOT NULL,
    "id_jeu" integer,
    "ra" numeric(10,5),
    "deca" numeric(10,5),
    "magnitude" numeric(10,5),
    "created" timestamp,
    "updated" timestamp,
    CONSTRAINT "parcours_pkey" PRIMARY KEY ("id_parcours")
) WITH (oids = false);

CREATE INDEX "i_fk_parcours_jeu" ON "public"."parcours" USING btree ("id_jeu");


ALTER TABLE ONLY "public"."determiner" ADD CONSTRAINT "fk_determiner_constellation" FOREIGN KEY (id_constellation) REFERENCES constellation(id_constellation) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."determiner" ADD CONSTRAINT "fk_determiner_objet_proche" FOREIGN KEY (id_objet_proche) REFERENCES objet_proche(id_objet_proche) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."grouper" ADD CONSTRAINT "fk_grouper_constellation" FOREIGN KEY (id_constellation) REFERENCES constellation(id_constellation) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."grouper" ADD CONSTRAINT "fk_grouper_objet_distant" FOREIGN KEY (id_objet_distant) REFERENCES objet_distant(id_objet_distant) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."jeu" ADD CONSTRAINT "fk_jeu_constellation" FOREIGN KEY (id_constellation) REFERENCES constellation(id_constellation) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."jeu" ADD CONSTRAINT "fk_jeu_objet_distant" FOREIGN KEY (id_objet_distant) REFERENCES objet_distant(id_objet_distant) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."parcours" ADD CONSTRAINT "fk_parcours_jeu" FOREIGN KEY (id_jeu) REFERENCES jeu(id_jeu) NOT DEFERRABLE;