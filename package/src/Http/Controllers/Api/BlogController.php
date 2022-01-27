<?php

namespace Oluwatosin\Blog\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Oluwatosin\Blog\Services\BlogService;
use Oluwatosin\Blog\Http\Requests\{
    BlogCreateRequest,
    BlogDeleteRequest,
    BlogUpdateRequest
};

class BlogController extends Controller
{
    protected $service;

    /**
     * __construct
     *
     * @param  mixed $service
     * @return void
     */
    public function __construct(BlogService $service)
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
    public function store(BlogCreateRequest $request)
    {
        if ($request->validated()) {
            return  $this->service->create_new($request);
        }
    }


    /**
     * read
     *
     * @param  mixed $title_or_id
     * @return void
     */
    public function read($title_or_id)
    {
        return  $this->service->by_id(ucwords($title_or_id));
    }


    /**
     * update_category
     *
     * @param  mixed $request
     * @return void
     */
    public function update(BlogUpdateRequest $request)
    {
        if ($request->validated()) {
            return  $this->service->update_item($request);
        }
    }


    public function delete(BlogDeleteRequest $request)
    {
        if ($request->validated()) {
            return  $this->service->delete_item($request->id);
        }
    }
}
