<?php


namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\Contract\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(CategoryRequest $req): Category {
        return $this->categoryService->create($req);
    }

    public function list() {
        $query = null;
        if (!auth()->check()) {
            $query = [
                'is_system' => false
            ];
        }
        return $this->categoryService->listAll($query);
    }

    public function single($url) {
        return $this->categoryService->single($url);
    }

    public function edit($url, CategoryRequest $req) {
        return $this->categoryService->edit($url, $req);
    }

    public function delete($url) {
        return $this->categoryService->delete($url);
    }
}
