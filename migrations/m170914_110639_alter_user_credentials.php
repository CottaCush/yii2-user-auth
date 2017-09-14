<?php

use cottacush\userauth\libs\Constants;
use yii\db\Migration;

class m170914_110639_alter_user_credentials extends Migration
{
    public function up()
    {
        $this->alterColumn(
            Constants::TABLE_USER_CREDENTIALS,
            'status',
            $this->string(100)->notNull()->defaultValue('inactive')
        );

        $this->createIndex(
            'k_' . Constants::TABLE_USER_CREDENTIALS . '_status',
            Constants::TABLE_USER_CREDENTIALS,
            'status'
        );
    }

    public function down()
    {
        $this->alterColumn(
            Constants::TABLE_USER_CREDENTIALS,
            'status',
            $this->boolean()->defaultValue(0)
        );

        $this->dropIndex(
            'k_' . Constants::TABLE_USER_CREDENTIALS . '_status',
            Constants::TABLE_USER_CREDENTIALS
        );
    }
}
