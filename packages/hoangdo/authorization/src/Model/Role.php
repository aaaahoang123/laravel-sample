<?php


namespace HoangDo\Authorization\Model;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package HoangDo\Authorization\Model
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Role extends Model
{
    protected $fillable = ['id'];
    public $incrementing = false;
}
