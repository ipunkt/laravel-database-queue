<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('queues', function(Blueprint $table)
        {
	        $table->index(array('query', 'status', 'timestamp'));
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
			$table->dropIndex('queues_query_status_timestamp_index');
		});
	}

}
