<?php

use HoangDo\Notification\Enum\NotificationStatus;
use HoangDo\Notification\Enum\NotificationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id', 191)->index();
            $table->string('title');
            $table->string('description');
            $table->text('content');
            $table->tinyInteger('type')->default(NotificationType::BASIC);
            $table->tinyInteger('status')
                ->default(NotificationStatus::UNREAD)
                ->comment(NotificationStatus::UNREAD . ': Chưa đọc, ' . NotificationStatus::READ . ': Đã đọc');
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
        Schema::dropIfExists('notifications');
    }
}
