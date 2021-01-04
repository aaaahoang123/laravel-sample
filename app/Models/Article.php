<?php

namespace App\Models;

use HoangDo\Common\Helper\DateTimeFormat;
use HoangDo\Common\Model\HasCreatorInfo;
use HoangDo\Storage\FileStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Article.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $content
 * @property string|null $thumbnail
 * @property int $category_id
 * @property int $created_by_id
 * @property int $updated_by_id
 * @property int $views
 * @property mixed|null $created_at
 * @property mixed|null $updated_at
 * @property int $status 1: Hoạt động. -1: Không hoạt động.
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\User $created_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereViews($value)
 * @mixin \Eloquent
 */
class Article extends Model
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
        'content',
        'thumbnail',
        'views',
        'status'
    ];

    protected $casts = [
        'created_at'  => "date:" . DateTimeFormat::GLOBAL_TIME_FORMAT,
        'updated_at'  => "date:" . DateTimeFormat::GLOBAL_TIME_FORMAT,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tags');
    }

    public function toArray()
    {
        $result = parent::toArray();

        $result['thumbnail_url'] = FileStorage::uploadedUrl($this->thumbnail);

        return $result;
    }
}
