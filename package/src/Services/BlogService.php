<?php

namespace Oluwatosin\Blog\Services;

use Oluwatosin\Blog\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Oluwatosin\Blog\Contracts\BaseContract;
use Mews\Purifier\Facades\Purifier;


class BlogService implements BaseContract
{
    protected $blog;
    private $user;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }


    private function authenticated()
    {
        return $this->user = Auth::user();
    }

    private function purifier($string): string
    {
        return Purifier::clean($string);
    }

    private function auth_response($status, $success, $message)
    {
        return response()->json([
            'success' => $success,
            'message' => $message
        ], $status);
    }

    private function filename()
    {
        return bin2hex(random_bytes(32)) . ".jpg";
    }

    public function fetchall()
    {
        $paginated = $this->blog::with('category:id,name', 'user:id,name')->paginate(10);
        return response()->json($paginated);
    }

    public function create_new($data)
    {
        try {
            if (is_null($this->authenticated())) {
                return $this->auth_response(401, false, "Sorry unauthorized");
            }

            if ($data->hasFile('image')) {
                $filename = $this->filename();
                $image = $data->file('image')->storeAs('blog_image', $filename, 'public');
                $this->blog::imageIntervention($image);
            }


            $blog = $this->blog::create([
                'title' => $this->purifier(ucwords($data->title)),
                'category_id' => $data->category_id,
                'user_id' => $this->user->id,
                'image' => $filename ?? '',
                'content' => $this->purifier($data->content)
            ]);
            if ($blog) {
                return $blog;
            }
        } catch (\Exception $e) {
            return $this->auth_response(424, false, "Unable to create blog");
        }
    }

    public function by_id($name_or_id)
    {
        $single_blog = $this->blog::with('category:id,name', 'user:id,name,email', 'comment')
            ->where('id', $name_or_id)
            ->orWhere('title', $name_or_id)
            ->first();
        if ($single_blog) {
            return $single_blog;
        } else {
            return $this->auth_response(200, true, "No content for this blog");
        }
    }

    public function update_item($data)
    {
        try {
            if (is_null($this->authenticated())) {
                return $this->auth_response(401, false, "Sorry unauthorized");
            }

            $updated = $this->blog::where('id', $data->id)
                ->where('user_id', $this->user->id)
                ->first();
            if ($updated) {
                $updated->title = $this->purifier(ucwords($data->title));
                $updated->content = $this->purifier($data->content);
                $updated->category_id = $data->category_id;
                $updated->save();
                return $updated;
            } else {
                return $this->auth_response(401, false, "Sorry you cannot update this blog");
            }
        } catch (\Exception $e) {
            return $this->auth_response(424, false, "Sorry could not update this blog");
        }
    }

    public function delete_item($id)
    {
        try {
            if (is_null($this->authenticated())) {
                return $this->auth_response(401, false, "Sorry unauthorized");
            }

            $deleted = $this->blog::where('id', $id)
                ->where('user_id', $this->user->id)
                ->delete();
            if ($deleted) {
                return $this->auth_response(200, true, "Blog deleted");
            } else {
                return $this->auth_response(401, false, "Sorry you cannot delete this blog");
            }
        } catch (\Exception $e) {
            return $this->auth_response(424, false, "Sorry could not delete this blog");
        }
    }
}
