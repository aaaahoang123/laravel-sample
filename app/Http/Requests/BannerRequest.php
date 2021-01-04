<?php
/**
 * @Author Hoang Do
 * @Created 1/4/21 5:11 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Http\Requests;


use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Request\AuthorizedRequest;
use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Validation\Rule;

class BannerRequest extends ValidatedRequest
{
    use AuthorizedRequest;

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'navigate_to' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:255'],
            'sort_number' => ['nullable', 'numeric'],
            'status' => ['nullable', 'numeric', Rule::in(CommonStatus::getValues())]
        ];
    }
}
