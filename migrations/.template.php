<?= "<?php";?>


use Phpmig\Migration\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class <?= $className ?> extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        Capsule::schema()->create('<?= strtolower($className) ?>', function($table)
        {
            $table->timestamps();
        });

    }

    /**
     * Undo the migration
     */
    public function down()
    {
        Capsule::schema()->drop('<?= strtolower($className) ?>');
    }
}