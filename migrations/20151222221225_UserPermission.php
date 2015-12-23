<?php
use Phpmig\Migration\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Model\UserPermission as Permission;

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
        $array = array(
            array(
                'group_id'  => '1',
                'page'      => 'user',
                'action'    => 'index',
            ),
            array(
                'group_id'  => '1',
                'page'      => 'user',
                'action'    => 'edit',
            ),
            array(
                'group_id'  => '1',
                'page'      => 'user',
                'action'    => 'delete',
            ),
            array(
                'group_id'  => '1',
                'page'      => 'group',
                'action'    => 'index',
            ),
            array(
                'group_id'  => '1',
                'page'      => 'group',
                'action'    => 'edit',
            ),
            array(
                'group_id'  => '1',
                'page'      => 'group',
                'action'    => 'delete',
            ),
            array(
                'group_id'  => '1',
                'page'      => 'permission',
                'action'    => 'index',
            ),
            array(
                'group_id'  => '1',
                'page'      => 'permission',
                'action'    => 'edit',
            ),
            array(
                'group_id'  => '1',
                'page'      => 'permission',
                'action'    => 'delete',
            ));
        Permission::insert($array);

    }

    /**
     * Undo the migration
     */
    public function down()
    {
        Capsule::schema()->drop('users_permission');
    }
}