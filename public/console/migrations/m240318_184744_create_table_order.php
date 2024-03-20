<?php

use yii\db\Migration;

/**
 * Class m240318_184744_create_table_order
 */
class m240318_184744_create_table_order extends Migration
{
    const TABLE_NAME = '{{%order}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->unsigned(),
            'product_id' => $this->integer()->unsigned()->notNull(),
            'member_id' => $this->integer()->unsigned(),
            'quantity' => $this->integer()->unsigned()->notNull(),
            'price' => $this->decimal(20, 2)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)
                ->comment('0 - pending, 1 - paid, 2 - cancelled'),
        ]);

        $this->addForeignKey(
            'fk_order_product_id',
            self::TABLE_NAME,
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_order_member_id',
            self::TABLE_NAME,
            'member_id',
            '{{%member}}',
            'id',
            'CASCADE'
        );

        $this->batchInsert(self::TABLE_NAME, ['product_id', 'member_id', 'quantity', 'price', 'status_id'], [
                [1, 1, 1, 100, 1],
                [2, 1, 2, 400, 0],
                [3, 2, 10, 300, 2],
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
