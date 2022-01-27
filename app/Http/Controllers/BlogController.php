<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BlogController extends Controller
{

    public function index()
    {
        $storage = Redis::Connection();
        $popular = $storage->zRevRange('articleViews', 0, -1);
        foreach ($popular as $value) {
            $id = str_replace('article:', '', $value);
            echo $id . "<br>";
        }
    }



    public function showArticles($id)
    {
        $this->id = $id;
        $storage = Redis::Connection();
        if ($storage->zScore('articleViews', 'article:' . $id)) {
            $storage->pipeline(function ($pipe) {
                $pipe->zIncrBy('articleViews', 1, 'article: ' . $this->id);
                $pipe->incr('article:' . $this->id . ':views');
            });
        } else {
            $views = $storage->incr('article:' . $this->id . ':views');
            $storage->zIncrBy('articleViews', $views, 'article: ' . $this->id);
        }

        $views = $storage->get('article:' . $this->id . ':views');
        return "This articles with id:  " . $this->id . " has " . $views;
    }



    public function doAddBlog()
    {
        $userInput = [
            'title' => Request::input('title'),
            'author' => Request::input('author'),
            'author' => Request::input('author'),
            'tags' => Request::input('tags'),
            'content' => Request::input('inputContent')
        ];

        $validation = $this->BlogRegistrar->validator($userInput);
        if ($validation) {
            $result = $this->BlogRegistrar->create($userInput);

            if ($result) {
                if ($userInput['tags'] != '') {
                    $filteredTags = explode(', ', trim($userInput['tags']));

                    foreach ($filteredTags as $tag) {
                        // add a sorted set maintain article order
                        // this could also be a regular set, with DB sort used instead
                        Redis::zadd('article:tag:' . $tag, $result['id'], $result['id']);

                        // create set of tags for a specific article so we can retrieve them later
                        Redis::sadd('article:' . $result['id'] . ':tags', $tag);
                        // add tag to master list of tags
                        Redis::sadd('article:tags', $tag);
                    }
                }

                return 'post successfully created';
            }

            return 'sorry validation did not pass';
        }
    }
}
