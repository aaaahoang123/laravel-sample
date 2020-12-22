<?php


namespace HoangDo\Notification\Enum;


use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

class NotificationStatus extends Enum implements LocalizedEnum
{
    const READ = 1;
    const UNREAD = -1;
}
