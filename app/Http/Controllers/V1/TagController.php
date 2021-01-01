<?php


namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Services\Contract\TagService;
use HoangDo\Common\Helper\Utils;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private TagService $tagService;

    public function __construct(
        TagService $tagService
    )
    {
        $this->tagService = $tagService;
    }

    public function list(Request $req): array
    {
        $pageData = $this->tagService->listAll($req->query(), 20);

        return [
            'datas' => $pageData->items(),
            'meta' => Utils::getMeta($pageData)
        ];
    }
}
