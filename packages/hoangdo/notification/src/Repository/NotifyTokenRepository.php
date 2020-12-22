<?php

namespace HoangDo\Notification\Repository;

use HoangDo\Notification\Model\NotifyToken;
use Illuminate\Support\LazyCollection;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface NotifyTokenRepository.
 *
 * @package namespace App\Repositories\Contract;
 */
interface NotifyTokenRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * @param $user_id
     * @return NotifyToken[]|LazyCollection
     */
    public function findTokensByUserIdAndOrderByLastLog($user_id);

    /**
     * @param array $user_ids
     * @return NotifyToken[]|LazyCollection
     */
    public function findTokensByUserIdsAndOrderByLastLog($user_ids);

    /**
     * @return NotifyToken[]|LazyCollection
     */
    public function findTokensOfActiveUsers();

    /**
     * @param $app_token
     * @param $user_id
     * @return NotifyToken[]
     */
    public function findByTokenAndUserId($app_token, $user_id);

    public function removeByAppToken($app_token);
}
