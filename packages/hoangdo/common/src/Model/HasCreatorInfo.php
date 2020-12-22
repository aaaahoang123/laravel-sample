<?php


namespace HoangDo\Common\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RuntimeException;

trait HasCreatorInfo
{
    protected string $createdByField = 'created_by_id';
    protected string $updatedByField = 'updated_by_id';

    private function validateClassType()
    {
        if (!is_subclass_of($this, Model::class)) {
            throw new RuntimeException(printf("Class %s is not instance of %s class, can not use %s trait", class_basename($this), Model::class, HasCreatorInfo::class));
        }
    }

    public function created_by(): BelongsTo {
        /** @var Model $this */
        $this->validateClassType();
        return $this->belongsTo(config('auth.providers.users.model'), $this->createdByField);
    }

    public function updated_by(): BelongsTo {
        /** @var Model $this */
        $this->validateClassType();
        return $this->belongsTo(config('auth.providers.users.model'), $this->updatedByField);
    }
}
