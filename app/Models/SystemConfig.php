<?php

namespace App\Models;

use App\Enums\Type\SystemConfigDataType;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SystemConfig.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property string $value
 * @property int $data_type 1: Text. 2: Number. 3: Json.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SystemConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemConfig whereDataType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemConfig whereValue($value)
 * @mixin \Eloquent
 */
class SystemConfig extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'data_type'
    ];
    public $incrementing = false;

    public function toArray()
    {
        $result = parent::toArray();
        if ($this->data_type == SystemConfigDataType::JSON) {
            $result['value'] = json_decode($this->value);
        }
        if ($this->data_type == SystemConfigDataType::NUMBER && is_numeric($this->value)) {
            $result['value'] = $this->value + 0;
        }

        return $result;
    }

}
