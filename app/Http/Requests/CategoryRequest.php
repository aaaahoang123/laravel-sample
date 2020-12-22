<?php


namespace App\Http\Requests;

use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Request\AuthorizedRequest;
use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Validation\Rule;

/**
 * Class CategoryRequest
 * @package App\Http\Requests
 *
 * @property-read string $name
 * @property-read int|null $parent_id
 * @property-read string|null $icon
 * @property-read int|null $status
 * @property-read int|null $size_id
 * @property-read int|null $sort_number
 */
class CategoryRequest extends ValidatedRequest
{
    use AuthorizedRequest;
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'parent_id' => ['nullable', 'numeric', 'exists:categories,id'],
            'icon' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'numeric', Rule::in(CommonStatus::getValues())],
            'sort_number' => ['nullable', 'numeric', 'min:0']
        ];
    }
}
