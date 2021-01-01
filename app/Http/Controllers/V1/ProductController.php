<?php


namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\Contract\ProductService;
use HoangDo\Common\Helper\Utils;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(
        ProductService $productService
    )
    {
        $this->productService = $productService;
    }

    public function create(ProductRequest $req)
    {
        return $this->productService->create($req);
    }

    public function list(Request $req)
    {
        $page = $this->productService->listAll($req->query(), $req->query('limit') ?? 20);
        return [
            'datas' => $page->items(),
            'meta' => Utils::getMeta($page)
        ];
    }

    public function single($slug)
    {
        return $this->productService->single($slug);
    }

    public function edit($slug, ProductRequest $req)
    {
        return $this->productService->edit($slug, $req);
    }

    public function delete($slug)
    {
        return $this->productService->delete($slug);
    }
}
