<?php

use HoangDo\Notification\Enum\OsOption;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateNotifyTokensTable.
 */
class CreateNotifyTokensTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notify_tokens', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->index();
            $table->string('app_token', 191)->index();
            $table->tinyInteger('os')->default(OSOption::DEFAULT_OS);
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notify_tokens');
	}
}
