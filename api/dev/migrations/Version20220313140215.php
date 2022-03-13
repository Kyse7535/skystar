<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220313140215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE jeu_seq CASCADE');
        $this->addSql('DROP SEQUENCE constellation_seq CASCADE');
        $this->addSql('DROP SEQUENCE objet_distant_seq CASCADE');
        $this->addSql('DROP SEQUENCE objet_proche_seq CASCADE');
        $this->addSql('DROP SEQUENCE parcours_seq CASCADE');
        $this->addSql('DROP SEQUENCE grouper_seq CASCADE');
        $this->addSql('DROP SEQUENCE determiner_seq CASCADE');
        $this->addSql('DROP SEQUENCE grouper_id_objet_distant_seq CASCADE');
        $this->addSql('DROP SEQUENCE determiner_id_objet_proche_seq CASCADE');
        $this->addSql('ALTER TABLE constellation ALTER id_constellation DROP DEFAULT');
        $this->addSql('ALTER TABLE jeu ADD point BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE jeu ALTER id_jeu DROP DEFAULT');
        $this->addSql('ALTER TABLE objet_distant ALTER id_objet_distant DROP DEFAULT');
        $this->addSql('ALTER TABLE grouper ALTER id_objet_distant DROP DEFAULT');
        $this->addSql('ALTER TABLE objet_proche ALTER id_objet_proche DROP DEFAULT');
        $this->addSql('ALTER TABLE determiner ALTER id_objet_proche DROP DEFAULT');
        $this->addSql('ALTER TABLE parcours ALTER id_parcours DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE jeu_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE constellation_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE objet_distant_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE objet_proche_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parcours_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE grouper_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE determiner_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE grouper_id_objet_distant_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE determiner_id_objet_proche_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE jeu DROP point');
        $this->addSql('CREATE SEQUENCE jeu_id_jeu_seq');
        $this->addSql('SELECT setval(\'jeu_id_jeu_seq\', (SELECT MAX(id_jeu) FROM jeu))');
        $this->addSql('ALTER TABLE jeu ALTER id_jeu SET DEFAULT nextval(\'jeu_id_jeu_seq\')');
        $this->addSql('CREATE SEQUENCE objet_distant_id_objet_distant_seq');
        $this->addSql('SELECT setval(\'objet_distant_id_objet_distant_seq\', (SELECT MAX(id_objet_distant) FROM objet_distant))');
        $this->addSql('ALTER TABLE objet_distant ALTER id_objet_distant SET DEFAULT nextval(\'objet_distant_id_objet_distant_seq\')');
        $this->addSql('CREATE SEQUENCE parcours_id_parcours_seq');
        $this->addSql('SELECT setval(\'parcours_id_parcours_seq\', (SELECT MAX(id_parcours) FROM parcours))');
        $this->addSql('ALTER TABLE parcours ALTER id_parcours SET DEFAULT nextval(\'parcours_id_parcours_seq\')');
        $this->addSql('CREATE SEQUENCE grouper_id_objet_distant_seq');
        $this->addSql('SELECT setval(\'grouper_id_objet_distant_seq\', (SELECT MAX(id_objet_distant) FROM grouper))');
        $this->addSql('ALTER TABLE grouper ALTER id_objet_distant SET DEFAULT nextval(\'grouper_id_objet_distant_seq\')');
        $this->addSql('CREATE SEQUENCE objet_proche_id_objet_proche_seq');
        $this->addSql('SELECT setval(\'objet_proche_id_objet_proche_seq\', (SELECT MAX(id_objet_proche) FROM objet_proche))');
        $this->addSql('ALTER TABLE objet_proche ALTER id_objet_proche SET DEFAULT nextval(\'objet_proche_id_objet_proche_seq\')');
        $this->addSql('CREATE SEQUENCE determiner_id_objet_proche_seq');
        $this->addSql('SELECT setval(\'determiner_id_objet_proche_seq\', (SELECT MAX(id_objet_proche) FROM determiner))');
        $this->addSql('ALTER TABLE determiner ALTER id_objet_proche SET DEFAULT nextval(\'determiner_id_objet_proche_seq\')');
        $this->addSql('CREATE SEQUENCE constellation_id_constellation_seq');
        $this->addSql('SELECT setval(\'constellation_id_constellation_seq\', (SELECT MAX(id_constellation) FROM constellation))');
        $this->addSql('ALTER TABLE constellation ALTER id_constellation SET DEFAULT nextval(\'constellation_id_constellation_seq\')');
    }
}
