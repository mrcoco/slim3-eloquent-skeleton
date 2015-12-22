<?php

use Phpmig\Migration\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class UserPermission extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        Capsule::schema()->create('users_permission', function($table)
        {
            $table->increments('id');
            $table->integer('group_id');
            $table->string('page');
            $table->string('action');
            $table->timestamps();
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        Capsule::schema()->drop('users_permission');
    }
}