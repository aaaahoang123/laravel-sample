<?php
/**
 * @Author Hoang Do
 * @Created 1/4/21 10:47 AM
 * @By PhpStorm on Ubuntu
 */

namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Services\Contract\ArticleService;
use HoangDo\Common\Helper\Utils;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private ArticleService $articleService;

    public function __construct(
        ArticleService $articleService
    )
    {
        $this->articleService = $articleService;
    }

    public function create(ArticleRequest $req)
    {
        return $this->articleService->create($req);
    }

    public function list(Request $req): array
    {
        $pageData = $this->articleService->listAll($req->query(), $req->get('limit') ?? 20);

        return [
            'datas' => $pageData->items(),
            'meta' => Utils::getMeta($pageData)
        ];
    }

    public function single($slug)
    {
        return $this->articleService->single($slug);
    }

    public function edit($slug, ArticleRequest $req)
    {
        return $this->articleService->edit($slug, $req);
    }

    public function delete($slug)
    {
        return $this->articleService->delete($slug);
    }
}
