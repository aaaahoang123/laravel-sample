<?php

namespace App\Models;

use HoangDo\Common\Helper\DateTimeFormat;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property mixed|null $created_at
 * @property mixed|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 */
class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    protected $casts = [
        'created_at'  => "date:" . DateTimeFormat::GLOBAL_TIME_FORMAT,
        'updated_at'  => "date:" . DateTimeFormat::GLOBAL_TIME_FORMAT,
    ];

}
