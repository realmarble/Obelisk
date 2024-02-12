<?php
namespace Modules\HR\Assembly;
final class Employee
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(): string
    {
        // this up() migration is auto-generated, please modify it to your needs
        return 'CREATE TABLE employees (id INT AUTO_INCREMENT NOT NULL, identityid VARCHAR(36) NOT NULL, first_name VARCHAR(255) NOT NULL, second_name VARCHAR(255) NOT NULL, address LONGTEXT NOT NULL, position LONGTEXT NOT NULL, employed TINYINT(1) NOT NULL, hired DATE NOT NULL, fired DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`';
    }

    public function down(): string
    {
        // this down() migration is auto-generated, please modify it to your needs
        return 'DROP TABLE employee';
    }
}
