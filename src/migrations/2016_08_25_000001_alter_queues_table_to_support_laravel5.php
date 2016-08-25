<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterQueuesTableToSupportLaravel5 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('queues', function(Blueprint $table)
		{
		    //  rename retries into attempts
            $table->renameColumn('retries', 'attempts');//Laravel 5.2

            $table->tinyInteger('reserved')->unsigned();//Laravel 5.2
            $table->unsignedInteger('reserved_at')->nullable();//Laravel 5.2
            $table->unsignedInteger('available_at');//Laravel 5.2

            $table->index(array('queue', 'reserved', 'reserved_at'));//Laravel 5.2
            $table->index(array('queue', 'reserved_at'));//Laravel 5.3
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('queues', function(Blueprint $table)
		{
			$table->dropIndex('queues_queue_reserved_reserved_at_index');//Laravel 5.2
			$table->dropIndex('queues_queue_reserved_at_index');//Laravel 5.3
		});
	}

}
