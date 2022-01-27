<?php

namespace Oluwatosin\Blog\Services;

use Mews\Purifier\Facades\Purifier;
use Oluwatosin\Blog\Models\Comment;

class CommentService
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    private function auth_response($status, $success, $message)
    {
        return response()->json([
            'success' => $success,
            'message' => $message
        ], $status);
    }

    private function purifier($string): string
    {
        return Purifier::clean($string);
    }

    public function create_new($data)
    {
        try {
            $comment = $this->comment::create([
                'username' => $this->purifier(ucwords($data->username)),
                'blog_id' => $data->blog_id,
                'comment' => $this->purifier($data->comment)
            ]);
            if ($comment) {

                return $comment;
            }
        } catch (\Exception $e) {
            return $this->auth_response(424, false, "Unable to create comment");
        }
    }
}
