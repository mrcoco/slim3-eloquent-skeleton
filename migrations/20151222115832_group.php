<?php

use Phpmig\Migration\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class Group extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        Capsule::schema()->create('groups', function($table)
        {
            $table->increments('id');
            $table->string('group_name');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {

    }
}