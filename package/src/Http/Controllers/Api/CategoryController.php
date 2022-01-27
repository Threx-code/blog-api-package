<?php

namespace Oluwatosin\Blog\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Oluwatosin\Blog\Services\CategoryService;
use Oluwatosin\Blog\Http\Requests\{
    CategoryRequest,
    CategoryDeleteRequest,
    CategoryUpdateRequest
};

class CategoryController extends Controller
{
    protected $service;

    /**
     * __construct
     *
     * @param  mixed $service
     * @return void
     */
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return  $this->service->fetchall();
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(CategoryRequest $request)
    {
        if ($request->validated()) {
            return  $this->service->create_new($request);
        }
    }


    /**
     * read
     *
     * @param  mixed $name_or_id
     * @return void
     */
    public function read($name_or_id)
    {
        return  $this->service->by_id(ucwords($name_or_id));
    }


    /**
     * update_category
     *
     * @param  mixed $request
     * @return void
     */
    public function update(CategoryUpdateRequest $request)
    {
        if ($request->validated()) {
            return  $this->service->update_item($request);
        }
    }


    public function delete(CategoryDeleteRequest $request)
    {
        if ($request->validated()) {
            return  $this->service->delete_item($request->id);
        }
    }
}
