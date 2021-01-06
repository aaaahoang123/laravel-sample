<?php
/**
 * @Author Hoang Do
 * @Created 1/5/21 11:07 AM
 * @By PhpStorm on Ubuntu
 */

namespace App\Http\Requests;


use HoangDo\Common\Request\ValidatedRequest;

/**
 * Class ContactMessageRequest
 * @package App\Http\Requests
 *
 * @property-read string $subject
 * @property-read string $message
 */
class ContactMessageRequest extends CustomerRequest
{
    protected function extraRules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:65000'],
            'phone_number' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:50'],
        ];
    }
}
