<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240902135325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4FB08EDF6');
        $this->addSql('CREATE TABLE session_trainee (session_id INT NOT NULL, trainee_id INT NOT NULL, INDEX IDX_541E0FBD613FECDF (session_id), INDEX IDX_541E0FBD36C682D0 (trainee_id), PRIMARY KEY(session_id, trainee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session_trainee ADD CONSTRAINT FK_541E0FBD613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_trainee ADD CONSTRAINT FK_541E0FBD36C682D0 FOREIGN KEY (trainee_id) REFERENCES trainee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE belonging DROP FOREIGN KEY FK_567ECCA636C682D0');
        $this->addSql('ALTER TABLE belonging DROP FOREIGN KEY FK_567ECCA6613FECDF');
        $this->addSql('DROP TABLE belonging');
        $this->addSql('DROP TABLE trainer');
        $this->addSql('DROP INDEX IDX_D044D5D4FB08EDF6 ON session');
        $this->addSql('ALTER TABLE session DROP trainer_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE belonging (id INT AUTO_INCREMENT NOT NULL, trainee_id INT NOT NULL, session_id INT NOT NULL, INDEX IDX_567ECCA636C682D0 (trainee_id), INDEX IDX_567ECCA6613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE trainer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, first_name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE belonging ADD CONSTRAINT FK_567ECCA636C682D0 FOREIGN KEY (trainee_id) REFERENCES trainee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE belonging ADD CONSTRAINT FK_567ECCA6613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE session_trainee DROP FOREIGN KEY FK_541E0FBD613FECDF');
        $this->addSql('ALTER TABLE session_trainee DROP FOREIGN KEY FK_541E0FBD36C682D0');
        $this->addSql('DROP TABLE session_trainee');
        $this->addSql('ALTER TABLE session ADD trainer_id INT NOT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4FB08EDF6 FOREIGN KEY (trainer_id) REFERENCES trainer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D044D5D4FB08EDF6 ON session (trainer_id)');
    }
}
