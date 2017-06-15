<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170615_055154_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username'=>$this->string()->comment('用户名'),
            'auth_key'=>$this->string()->comment(''),
            'password_hash'=>$this->string(100)->comment('密码'),
            'gender'=>$this->smallInteger()->comment('性别'),
            'photo'=>$this->string(50)->comment('头像'),
            'register_time'=>$this->integer()->comment('注册时间'),
            'login_time'=>$this->integer()->comment('登录时间'),
            'login_ip'=>$this->string()->comment('登录IP'),
            'status'=>$this->string()->comment('状态'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
