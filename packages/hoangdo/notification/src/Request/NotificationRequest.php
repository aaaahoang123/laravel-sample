<?php


namespace HoangDo\Notification\Request;


use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class NotificationRequest
 * @package HoangDo\Notification\Request
 *
 * @property-read array|string[] $user_ids
 * @property-read int|null $policy_id
 * @property-read string $title
 * @property-read string $description
 * @property-read string $content
 */
class NotificationRequest extends ValidatedRequest
{
    public function rules(): array {
        /** @var Model $user */
        $user = app(config('notification.user'));
        return [
            'user_ids' => ['array'],
            'user_ids.*' => ['required', 'string', 'exists:' . $user->getTable() . ',id'],
//            'policy_id' => ['nullable','numeric'],
            'title' => ['required', 'string', 'min: 1'],
            'description' => ['required', 'string', 'min:1'],
            'content' => ['required', 'string', 'min:1']
        ];
    }
}
