<?php
/**
 * @Author Hoang Do
 * @Created 1/5/21 10:53 AM
 * @By PhpStorm on Ubuntu
 */

namespace App\Enums\Status;


use HoangDo\Common\Enum\LocalEnum;

class ContactMessageStatus extends LocalEnum
{
    const WAITING = 1;
    const RESOLVED = 2;
    const DELETED = -1;
}
