<?php

namespace App\Http\Requests;

use HoangDo\Common\Request\ValidatedRequest;

/**
 * Class ProductRequest
 * @package App\Http\Requests
 *
 * @property string $name
 * @property string $description
 * @property string $details
 * @property array|string[] $images
 * @property string $state
 * @property int $warranty
 * @property int $price
 * @property array|string[]|null $tags
 */
class ProductRequest extends ValidatedRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'description' => ['required', 'string', 'max:65000'],
            'details' => ['required', 'string'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:255'],
            'warranty' => ['required', 'numeric', 'min:0'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['required', 'string', 'max:191']
        ];
    }
}
