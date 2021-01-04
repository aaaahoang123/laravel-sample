<?php

namespace App\Models;

use HoangDo\Common\Model\HasCreatorInfo;
use HoangDo\Storage\FileStorage;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Banner
 *
 * @property int $id
 * @property string $title
 * @property string $navigate_to
 * @property string $image
 * @property int $sort_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by_id
 * @property int $updated_by_id
 * @property int $status 1: Hoạt động. -1: Không hoạt động.
 * @property-read \App\Models\User $created_by
 * @property-read \App\Models\User $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereNavigateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereSortNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereUpdatedById($value)
 * @mixin \Eloquent
 */
class Banner extends Model
{
    use HasCreatorInfo;

    protected $fillable = ['id', 'title', 'navigate_to', 'image', 'status', 'sort_number'];

    public function toArray()
    {
        $result = parent::toArray();
        $result['image_url'] = FileStorage::uploadedUrl($this->image);
        return $result;
    }
}
