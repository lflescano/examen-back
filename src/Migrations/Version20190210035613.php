<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190210035613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE usuario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(50) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE alquiler (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, usuario_id INTEGER NOT NULL, departamento_id INTEGER NOT NULL, fecha_inicio DATE NOT NULL, cantidad_dias INTEGER NOT NULL, finalizado BOOLEAN DEFAULT NULL, tipo VARCHAR(5) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_655BED39DB38439E ON alquiler (usuario_id)');
        $this->addSql('CREATE INDEX IDX_655BED395A91C08D ON alquiler (departamento_id)');
        $this->addSql('CREATE INDEX tipo_idx ON alquiler (tipo)');
        $this->addSql('CREATE TABLE departamento (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ubicacion VARCHAR(255) NOT NULL, ambientes INTEGER NOT NULL, metros_cuadrados DOUBLE PRECISION NOT NULL, valor_noche DOUBLE PRECISION NOT NULL, valor_mes DOUBLE PRECISION NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE alquiler');
        $this->addSql('DROP TABLE departamento');
    }
}
