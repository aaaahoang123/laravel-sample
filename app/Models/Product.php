<?php

namespace App\Models;

use HoangDo\Common\Helper\DateTimeFormat;
use HoangDo\Common\Model\HasCreatorInfo;
use HoangDo\Storage\FileStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Product.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $details
 * @property string $images
 * @property string $state
 * @property int $warranty
 * @property int|null $price
 * @property int $category_id
 * @property int $created_by_id
 * @property int $updated_by_id
 * @property mixed|null $created_at
 * @property mixed|null $updated_at
 * @property int $status 1: Hoạt động. -1: Không hoạt động.
 * @property-read \App\Models\User $created_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $updated_by
 * @property-read \App\Models\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWarranty($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 */
class Product extends Model
{
    use HasCreatorInfo;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'details',
        'images',
        'state',
        'warranty',
        'price'
    ];

    protected $casts = [
        'created_at'  => "date:" . DateTimeFormat::GLOBAL_TIME_FORMAT,
        'updated_at'  => "date:" . DateTimeFormat::GLOBAL_TIME_FORMAT,
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function toArray()
    {
        $result = parent::toArray();
        $images = explode(',', $this->images);
        $result['images'] = $images;
        $result['image_urls'] = collect($images)->map(fn($image) => FileStorage::uploadedUrl($image));
        return $result;
    }

}
