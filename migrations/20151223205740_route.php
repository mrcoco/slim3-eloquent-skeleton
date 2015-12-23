<?php

use Phpmig\Migration\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Model\Route as Routes;
class Route extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        Capsule::schema()->create('routes', function($table)
        {
            $table->increments('id');
            $table->string('route');
            $table->string('page');
            $table->string('action');
            $table->timestamps();
        });
        $array = array(
            array(
                'route'  => 'admin',
                'page'      => 'user',
                'action'    => 'index',
            ),
            array(
                'route'  => 'user',
                'page'      => 'user',
                'action'    => 'index',
            ),
            array(
                'route'  => '1',
                'page'      => 'user',
                'action'    => 'edit',
            ),
            array(
                'route'  => '1',
                'page'      => 'user',
                'action'    => 'delete',
            ),
            array(
                'route'  => 'group',
                'page'      => 'group',
                'action'    => 'index',
            ),
            array(
                'route'  => '1',
                'page'      => 'group',
                'action'    => 'edit',
            ),
            array(
                'route'  => '1',
                'page'      => 'group',
                'action'    => 'delete',
            ),
            array(
                'route'  => 'permission',
                'page'      => 'permission',
                'action'    => 'index',
            ),
            array(
                'route'  => '1',
                'page'      => 'permission',
                'action'    => 'edit',
            ),
            array(
                'route'  => '1',
                'page'      => 'permission',
                'action'    => 'delete',
            ));
        Routes::insert($array);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        Capsule::schema()->drop('routes');
    }
}