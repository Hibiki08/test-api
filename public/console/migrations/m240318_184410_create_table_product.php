<?php

use yii\db\Migration;

/**
 * Class m240318_184410_create_table_product
 */
class m240318_184410_create_table_product extends Migration
{
    const TABLE_NAME = '{{%product}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(255)->notNull()->unique()->comment('URL'),
            'price' => $this->decimal(20, 2)->notNull(),
        ]);

        $this->batchInsert(self::TABLE_NAME, ['id', 'name', 'slug', 'price'], [
                [1, 'Product 1', 'product_1', 100],
                [2, 'Product 2', 'product_2', 200],
                [3, 'Product 3', 'product_3', 300],
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
