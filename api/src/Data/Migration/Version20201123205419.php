<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201123205419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_tasks (id UUID NOT NULL, author_id UUID NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, status VARCHAR(16) NOT NULL, created_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, completed_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, author_email VARCHAR(255) NOT NULL, PRIMARY KEY(id, author_id))');
        $this->addSql('COMMENT ON COLUMN task_tasks.id IS \'(DC2Type:task_task_id)\'');
        $this->addSql('COMMENT ON COLUMN task_tasks.author_id IS \'(DC2Type:task_author_id)\'');
        $this->addSql('COMMENT ON COLUMN task_tasks.status IS \'(DC2Type:task_task_status)\'');
        $this->addSql('COMMENT ON COLUMN task_tasks.created_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN task_tasks.completed_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN task_tasks.author_email IS \'(DC2Type:task_author_email)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE task_tasks');
    }
}
