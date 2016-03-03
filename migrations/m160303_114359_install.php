<?php

use yii\db\Migration;

/**
 * Class m160303_114359_install
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 */
class m160303_114359_install extends Migration
{
    const TABLE_USER_TYPES = 'user_types';
    const TABLE_USER_CREDENTIALS = 'user_credentials';
    const TABLE_USER_PASSWORD_CHANGES = 'user_password_changes';
    const TABLE_USER_PASSWORD_RESET = 'user_password_resets';
    const TABLE_USER_LOGIN_HISTORY = 'user_login_history';

    public function up()
    {
        $this->createTable(self::TABLE_USER_TYPES, [
            'id' => $this->primaryKey(11),
            'name' => $this->string(100)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()
        ]);

        $this->createTable(self::TABLE_USER_CREDENTIALS, [
            'id' => $this->primaryKey(11),
            'email' => $this->string(100)->notNull()->unique(),
            'password' => $this->string(100)->notNull(),
            'user_type_id' => $this->integer(11)->defaultValue(null),
            'status' => $this->boolean()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull()
        ]);

        $this->createIndex('k_'.self::TABLE_USER_CREDENTIALS.'_email', self::TABLE_USER_CREDENTIALS, 'email', true);

        $this->addForeignKey('fk_user_credentials_user_types_user_type_id_id', self::TABLE_USER_CREDENTIALS, 'user_type_id', self::TABLE_USER_TYPES, 'id', 'CASCADE', 'CASCADE');

        $this->createTable(self::TABLE_USER_PASSWORD_CHANGES, [
            'id' => $this->primaryKey(11),
            'user_id' => $this->integer(11)->notNull(),
            'password_hash' => $this->string(100)->notNull(),
            'date_changed' => $this->dateTime()->notNull()
        ]);

        $this->addForeignKey('fk_user_password_changes_user_credentials_user_id_id', self::TABLE_USER_PASSWORD_CHANGES, 'user_id', self::TABLE_USER_CREDENTIALS, 'id', 'CASCADE', 'CASCADE');

        $this->createTable(self::TABLE_USER_PASSWORD_RESET, [
            'id' => $this->primaryKey(11),
            'user_id' => $this->integer(11)->notNull(),
            'token' => $this->string(100)->notNull()->unique(),
            'date_requested' => $this->dateTime()->notNull(),
            'date_of_expiry' => $this->integer(11),
            'expires' => $this->boolean()->defaultValue(1)->notNull()
        ]);

        $this->createIndex('k_'.self::TABLE_USER_PASSWORD_RESET.'_token', self::TABLE_USER_PASSWORD_RESET, 'token', true);

        $this->addForeignKey('fk_user_password_resets_user_credentials_user_id_id', self::TABLE_USER_PASSWORD_RESET, 'user_id', self::TABLE_USER_CREDENTIALS, 'id', 'CASCADE', 'CASCADE');

        $this->createTable(self::TABLE_USER_LOGIN_HISTORY, [
            'id' => $this->primaryKey(11),
            'user_id' => $this->integer(11)->notNull(),
            'login_status' => $this->string(100)->notNull(),
            'ip_address' => $this->string(100),
            'user_agent' => $this->text(),
            'date_logged' => $this->dateTime()->notNull()
        ]);

        $this->addForeignKey('fk_user_login_history_user_credentials_user_id_id', self::TABLE_USER_LOGIN_HISTORY, 'user_id', self::TABLE_USER_CREDENTIALS, 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable(self::TABLE_USER_LOGIN_HISTORY);
        $this->dropTable(self::TABLE_USER_PASSWORD_RESET);
        $this->dropTable(self::TABLE_USER_PASSWORD_CHANGES);
        $this->dropTable(self::TABLE_USER_CREDENTIALS);
        $this->dropTable(self::TABLE_USER_TYPES);
    }
}
