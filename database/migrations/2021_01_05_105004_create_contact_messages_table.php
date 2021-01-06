<?php

use App\Enums\Status\ContactMessageStatus;
use HoangDo\Common\Helper\Utils;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateContactMessagesTable.
 */
class CreateContactMessagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_messages', function(Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->foreignId('customer_id')->constrained();
            $table->string('email', 191)->index()->nullable();
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->boolean('notified')->default(false);
            $table->tinyInteger('status')
                ->default(ContactMessageStatus::WAITING)
                ->comment(Utils::generateDbComment(ContactMessageStatus::getInstances()));

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
		Schema::drop('contact_messages');
	}
}
