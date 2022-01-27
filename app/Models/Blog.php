<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Model;
use App\Contract\BlogContract as BlogContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model implements BlogContract
{
    use HasFactory;

    public function __construct()
    {
        $this->storage = Redis::Connection();
    }

    public function fetchAll()
    {
        // add the key, time, and function
        $result = Cache::remember('blog_cache', 1, function () {
            $this->get();
        });

        return $result;
    }

    public function fetch($id)
    {
        $this->id = $id;

        $this->storage->pipeline(function ($pipe) {
            $pipe->zIncrBy('articlesViews', 1, 'article:' . $this->id);
            $pipe->incr('article:', $this->id, ':views');
        });

        return $this->where('id', $id)->first();
    }


    public function getBlogViews($id)
    {
        return $this->storage->get('article:', $id . ':views');
    }

    public function getViews()
    {
    }
}
