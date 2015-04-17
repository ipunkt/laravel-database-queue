<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterQueuesTableAddIndex extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('queues', function(Blueprint $table)
		{
			$table->index(array('queue', 'status', 'timestamp'));
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
			$table->dropIndex('queues_queue_status_timestamp_index');
		});
	}

}
