<?php

namespace HoangDo\Notification\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NotifyToken.
 *
 * @package namespace HoangDo\Notification\Model;
 *
 * @property int $id
 * @property string $user_id
 * @property string $app_token
 * @property int $os
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyToken whereAppToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyToken whereLastLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyToken whereOs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyToken whereUserId($value)
 * @mixin \Eloquent
 */
class NotifyToken extends Model
{
    protected $fillable = ['user_id', 'token', 'os'];

    public function user() {
        return $this->belongsTo(config('notification.user'));
    }
}
