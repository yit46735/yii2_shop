<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170620_112152_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'username'=>$this->string()->comment('姓名'),
            'address'=>$this->string(255)->comment('地址'),
            'tel'=>$this->char(11)->comment('手机号码'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
