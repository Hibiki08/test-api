<?php

use yii\db\Migration;

/**
 * Class m240318_183828_create_table_member
 */
class m240318_183828_create_table_member extends Migration
{
    const TABLE_NAME = '{{%member}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
        ]);

        $this->batchInsert(self::TABLE_NAME, ['id', 'name', 'auth_key'], [
                [1, 'Bob', 'auth_key_1'],
                [2, 'John', 'auth_key_2'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
