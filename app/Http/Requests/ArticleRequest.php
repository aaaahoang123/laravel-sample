<?php
/**
 * @author Hoang Do
 * @date  1/1/2021 11:32 PM
 * @used PhpStorm
 */

namespace App\Http\Requests;


use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Validation\Rule;

/**
 * Class ArticleRequest
 * @package App\Http\Requests
 *
 * @property-read string $name
 * @property-read string $description
 * @property-read string $content
 * @property-read string $thumbnail
 * @property-read int $category_id
 * @property-read int|null $status
 * @property-read array|string[]|null $tags
 */
class ArticleRequest extends ValidatedRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'description' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'thumbnail' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'numeric', Rule::in(CommonStatus::getValues())],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['required', 'string', 'max:191'],
            'category_id' => ['required', 'numeric', 'exists:categories,id']
        ];
    }
}
