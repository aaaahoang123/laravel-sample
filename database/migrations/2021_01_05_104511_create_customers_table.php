<?php

use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Helper\Utils;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCustomersTable.
 */
class CreateCustomersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number', 50)->unique();
            $table->string('email', 191)
                ->index()
                ->nullable();
            $table->tinyInteger('status')
                ->default(CommonStatus::ACTIVE)
                ->comment(Utils::generateDbComment(CommonStatus::getInstances()));
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
		Schema::drop('customers');
	}
}
