<?php
/**
 * @Author Hoang Do
 * @Created 1/5/21 11:05 AM
 * @By PhpStorm on Ubuntu
 */

namespace App\Services\Contract;


use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ContactMessageService
{
    public function create(ContactMessageRequest $req): ContactMessage;
    public function list($query, $limit): LengthAwarePaginator;
    public function read($id): ContactMessage;
    public function resolve($id): ContactMessage;
    public function delete($id): ContactMessage;
}
