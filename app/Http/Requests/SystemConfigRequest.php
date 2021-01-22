<?php


namespace App\Http\Requests;


use App\Enums\Type\SystemConfigDataType;
use HoangDo\Common\Request\AuthorizedRequest;
use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Validation\Rule;

/**
 * Class SystemConfigRequest
 * @package App\Http\Requests
 *
 * @property-read $value
 * @property-read int $data_type
 */
class SystemConfigRequest extends ValidatedRequest
{
    use AuthorizedRequest;

    public function rules(): array
    {
        $rules = [
            'data_type' => ['required', 'numeric', Rule::in(SystemConfigDataType::getValues())]
        ];

        switch ($this->input('data_type')) {
            case SystemConfigDataType::JSON:
                $rules['value'] = ['required', 'array', 'min:1'];
                break;
            case SystemConfigDataType::NUMBER:
                $rules['value'] = ['required', 'numeric'];
                break;
            default:
                $rules['value'] = ['required', 'string'];
                break;
        }
        return $rules;
    }
}
