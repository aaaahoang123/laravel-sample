<?php

namespace App\Models;

use HoangDo\Common\Helper\DateTimeFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ContactMessage.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property string $subject
 * @property int $customer_id
 * @property string|null $email
 * @property string $message
 * @property boolean $read
 * @property boolean $notified
 * @property int $status 1: Đang chờ. 2: Đã xử lý. -1: Đã xóa.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'message',
        'email',
    ];

    protected $casts = [
        'read' => 'boolean',
        'notified' => 'boolean',
        'created_at'  => "date:" . DateTimeFormat::GLOBAL_TIME_FORMAT,
        'updated_at'  => "date:" . DateTimeFormat::GLOBAL_TIME_FORMAT,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

}
