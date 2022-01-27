<?php

namespace Oluwatosin\Blog\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Oluwatosin\Blog\Services\CommentService;
use Oluwatosin\Blog\Http\Requests\CommentCreateRequest;

class CommentController extends Controller
{
    protected $service;

    /**
     * __construct
     *
     * @param  mixed $service
     * @return void
     */
    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(CommentCreateRequest $request)
    {
        if ($request->validated()) {
            return  $this->service->create_new($request);
        }
    }
}
