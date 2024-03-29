<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170608_103518_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->comment('名称'),
            'intro'=>$this->text()->comment('简介'),
            'sort'=>$this->integer()->comment('排序'),
            'status'=>$this->smallInteger(2)->comment('状态'),
            'is_help'=>$this->smallInteger(1)->comment('类型'),
        ]);



    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
