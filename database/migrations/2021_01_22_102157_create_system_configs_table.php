<?php

use App\Enums\Type\SystemConfigDataType;
use HoangDo\Common\Helper\Utils;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSystemConfigsTable.
 */
class CreateSystemConfigsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('system_configs', function(Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->text('value');
            $table->tinyInteger('data_type')
                ->default(SystemConfigDataType::TEXT)
                ->comment(Utils::generateDbComment(SystemConfigDataType::getInstances()));

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
		Schema::drop('system_configs');
	}
}
