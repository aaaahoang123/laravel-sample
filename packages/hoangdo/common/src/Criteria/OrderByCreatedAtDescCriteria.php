<?php


namespace HoangDo\Common\Criteria;

class OrderByCreatedAtDescCriteria extends OrderByCriteria
{
    public function __construct(string $direction = 'desc')
    {
        parent::__construct('created_at', $direction);
    }
}
