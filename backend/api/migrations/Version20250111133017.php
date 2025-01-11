<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250111133017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carts DROP FOREIGN KEY carts_ibfk_1');
        $this->addSql('ALTER TABLE carts DROP FOREIGN KEY carts_ibfk_2');
        $this->addSql('DROP INDEX user_id ON carts');
        $this->addSql('DROP INDEX product_id ON carts');
        $this->addSql('ALTER TABLE carts ADD user_id_id INT DEFAULT NULL, ADD product_id_id INT DEFAULT NULL, DROP user_id, DROP product_id, CHANGE quantity quantity INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE carts ADD CONSTRAINT FK_4E004AAC9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE carts ADD CONSTRAINT FK_4E004AACDE18E50B FOREIGN KEY (product_id_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_4E004AAC9D86650F ON carts (user_id_id)');
        $this->addSql('CREATE INDEX IDX_4E004AACDE18E50B ON carts (product_id_id)');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY favorites_ibfk_1');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY favorites_ibfk_2');
        $this->addSql('ALTER TABLE favorites ADD updupdated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP deleted_at, CHANGE user_id user_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F54584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE favorites RENAME INDEX user_id TO IDX_E46960F5A76ED395');
        $this->addSql('ALTER TABLE favorites RENAME INDEX product_id TO IDX_E46960F54584665A');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY order_items_ibfk_1');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY order_items_ibfk_2');
        $this->addSql('DROP INDEX order_id ON order_items');
        $this->addSql('DROP INDEX product_id ON order_items');
        $this->addSql('ALTER TABLE order_items ADD order_id_id INT DEFAULT NULL, ADD product_id_id INT DEFAULT NULL, DROP order_id, DROP product_id, CHANGE quantity quantity INT NOT NULL, CHANGE price price NUMERIC(10, 0) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB0FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB0DE18E50B FOREIGN KEY (product_id_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_62809DB0FCDAEAAA ON order_items (order_id_id)');
        $this->addSql('CREATE INDEX IDX_62809DB0DE18E50B ON order_items (product_id_id)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY orders_ibfk_1');
        $this->addSql('DROP INDEX user_id ON orders');
        $this->addSql('ALTER TABLE orders ADD user_id_id INT DEFAULT NULL, DROP user_id, CHANGE status status INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE9D86650F ON orders (user_id_id)');
        $this->addSql('ALTER TABLE products CHANGE name name VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE price price NUMERIC(10, 0) NOT NULL, CHANGE quantity quantity INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP INDEX username ON users');
        $this->addSql('DROP INDEX email ON users');
        $this->addSql('ALTER TABLE users CHANGE username username VARCHAR(80) NOT NULL, CHANGE first_name first_name VARCHAR(60) NOT NULL, CHANGE last_name last_name VARCHAR(60) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE deleted_at deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users CHANGE username username VARCHAR(50) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL, CHANGE first_name first_name VARCHAR(50) NOT NULL, CHANGE last_name last_name VARCHAR(50) NOT NULL, CHANGE email email VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX username ON users (username)');
        $this->addSql('CREATE UNIQUE INDEX email ON users (email)');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5A76ED395');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F54584665A');
        $this->addSql('ALTER TABLE favorites ADD deleted_at DATETIME DEFAULT NULL, DROP updupdated_at, CHANGE user_id user_id INT NOT NULL, CHANGE product_id product_id INT NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT favorites_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT favorites_ibfk_2 FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorites RENAME INDEX idx_e46960f5a76ed395 TO user_id');
        $this->addSql('ALTER TABLE favorites RENAME INDEX idx_e46960f54584665a TO product_id');
        $this->addSql('ALTER TABLE products CHANGE name name TEXT NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE price price NUMERIC(10, 2) NOT NULL, CHANGE quantity quantity INT DEFAULT 0 NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE carts DROP FOREIGN KEY FK_4E004AAC9D86650F');
        $this->addSql('ALTER TABLE carts DROP FOREIGN KEY FK_4E004AACDE18E50B');
        $this->addSql('DROP INDEX IDX_4E004AAC9D86650F ON carts');
        $this->addSql('DROP INDEX IDX_4E004AACDE18E50B ON carts');
        $this->addSql('ALTER TABLE carts ADD user_id INT NOT NULL, ADD product_id INT NOT NULL, DROP user_id_id, DROP product_id_id, CHANGE quantity quantity INT DEFAULT 1 NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE carts ADD CONSTRAINT carts_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carts ADD CONSTRAINT carts_ibfk_2 FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX user_id ON carts (user_id)');
        $this->addSql('CREATE INDEX product_id ON carts (product_id)');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_62809DB0FCDAEAAA');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_62809DB0DE18E50B');
        $this->addSql('DROP INDEX IDX_62809DB0FCDAEAAA ON order_items');
        $this->addSql('DROP INDEX IDX_62809DB0DE18E50B ON order_items');
        $this->addSql('ALTER TABLE order_items ADD order_id INT NOT NULL, ADD product_id INT NOT NULL, DROP order_id_id, DROP product_id_id, CHANGE quantity quantity INT DEFAULT 1 NOT NULL, CHANGE price price NUMERIC(10, 2) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT order_items_ibfk_1 FOREIGN KEY (order_id) REFERENCES orders (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT order_items_ibfk_2 FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX order_id ON order_items (order_id)');
        $this->addSql('CREATE INDEX product_id ON order_items (product_id)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE9D86650F');
        $this->addSql('DROP INDEX IDX_E52FFDEE9D86650F ON orders');
        $this->addSql('ALTER TABLE orders ADD user_id INT NOT NULL, DROP user_id_id, CHANGE status status INT DEFAULT 0 NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT orders_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX user_id ON orders (user_id)');
    }
}
