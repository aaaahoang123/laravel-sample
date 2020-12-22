<?php


namespace HoangDo\Authorization\Enum;


use HoangDo\Common\Enum\LocalEnum;

class BaseRole extends LocalEnum
{
    const CAN_MANAGE_POLICIES = 'ROLE_CAN_MANAGE_POLICIES';
    const CAN_MANAGE_NOTIFICATIONS = 'ROLE_CAN_MANAGE_NOTIFICATIONS';
}
