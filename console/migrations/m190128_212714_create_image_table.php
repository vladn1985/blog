<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%news}}`
 */
class m190128_212714_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNULL()->unique(),
            'news_id' => $this->integer()->notNULL(),
        ]);

        // creates index for column `news_id`
        $this->createIndex(
            '{{%idx-image-news_id}}',
            '{{%image}}',
            'news_id'
        );

        // add foreign key for table `{{%news}}`
        $this->addForeignKey(
            '{{%fk-image-news_id}}',
            '{{%image}}',
            'news_id',
            '{{%news}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%news}}`
        $this->dropForeignKey(
            '{{%fk-image-news_id}}',
            '{{%image}}'
        );

        // drops index for column `news_id`
        $this->dropIndex(
            '{{%idx-image-news_id}}',
            '{{%image}}'
        );

        $this->dropTable('{{%image}}');
    }
}
