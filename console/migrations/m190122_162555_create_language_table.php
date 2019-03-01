<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%language}}`.
 */
class m190122_162555_create_language_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'url' => $this->string()->notNull()->unique(),
        ]);

        $this->createIndex(
            'idx-news-language_id',
            'news',
            'language_id'
        );

        $this->addForeignKey(
            'fk-news-language_id',
            'news',
            'language_id',
            'language',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-category-language_id',
            'category',
            'language_id',
            'language',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%language}}');
    }
}
