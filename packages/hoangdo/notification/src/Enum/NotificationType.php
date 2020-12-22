<?php


namespace HoangDo\Notification\Enum;


use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

class NotificationType extends Enum implements LocalizedEnum
{
    const BASIC = 1;
    const LINK = 2;
    const SESSION = 3;
}
