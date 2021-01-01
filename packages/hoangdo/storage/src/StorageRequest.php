<?php


namespace HoangDo\Storage;

use BenSampo\Enum\Enum;
use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

/**
 * Class StorageRequest
 * @package App\Http\Requests
 *
 * @property-read UploadedFile $image
 * @property-read string|null $folder
 */
class StorageRequest extends ValidatedRequest
{
    public function rules(): array
    {
        $rules = [
            'file' => ['required', 'mimes:' . config('storage.mimes')]
        ];
        $folder_enum = config('storage.folder_enum');
        if ($folder_enum && is_subclass_of($folder_enum, Enum::class)) {
            $values = call_user_func([$folder_enum, 'getValues']);
            $rules['folder'] = ['nullable', 'string', Rule::in($values)];
        }
        return $rules;
    }
}
