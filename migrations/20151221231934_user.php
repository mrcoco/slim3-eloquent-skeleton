<?php

use Phpmig\Migration\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Model\User as Users;
class User extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        Capsule::schema()->create('users', function($table)
        {
            $table->increments('id');
            $table->string('username');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->integer('group_id');
            $table->integer('status');
            $table->timestamps();
        });

        $array = array(
            array(
                'username'  => 'admin',
                'email'     => 'admin@slim.dev',
                'password'  => '$2y$10$ElXh/aFKLN1Vf4t2G0DTnupWcEpS2/2OP8fIsQXjHp7KXE3bjcUke',
                'group_id'  => '1',
                'status'    => '1'
            ),
            array(
                'username'  => 'moderator',
                'email'     => 'moderator@slim.dev',
                'password'  => '$2y$10$ElXh/aFKLN1Vf4t2G0DTnupWcEpS2/2OP8fIsQXjHp7KXE3bjcUke',
                'group_id'  => '1',
                'status'    => '1'
            ),
            array(
                'username'  => 'user',
                'email'     => 'user@slim.dev',
                'password'  => '$2y$10$ElXh/aFKLN1Vf4t2G0DTnupWcEpS2/2OP8fIsQXjHp7KXE3bjcUke',
                'group_id'  => '1',
                'status'    => '1'
            )
            );
        Users::insert($array);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        Capsule::schema()->drop('users');
    }
}