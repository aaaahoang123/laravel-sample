<?php

namespace HoangDo\Notification\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * @package HoangDo\Notification\Model
 *
 * @property int $id
 * @property string $user_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property int $type
 * @property int $status -1: Chưa đọc, 1: Đã đọc
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HoangDo\Notification\Model\Notification whereUserId($value)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'content', 'type', 'status'];

    public function user()
    {
        return $this->belongsTo(config('notification.user'));
    }
}
