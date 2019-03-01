<?php

use yii\db\Migration;

/**
 * Handles dropping image from table `{{%news}}`.
 */
class m190128_204507_drop_image_column_from_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%news}}', 'image');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%news}}', 'image', $this->string());
    }
}
