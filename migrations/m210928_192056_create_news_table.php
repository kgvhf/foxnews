<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m210928_192056_create_news_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'body' => 'LONGTEXT',
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'released' => $this->tinyInteger(2)->notNull(),
            'image' => $this->string(2000),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%news}}');
    }

}
