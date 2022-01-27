<?php

namespace Oluwatosin\Blog\Services;

use Illuminate\Validation\Rule;
use Oluwatosin\Blog\Models\Category;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Oluwatosin\Blog\Contracts\BaseContract;

class CategoryService implements BaseContract
{
    protected static $category;

    public function __construct(Category $category)
    {
        self::$category = $category;
    }

    public function fetchall()
    {
        $paginated = Category::paginate(10);
        return response()->json($paginated);
    }

    public function create_new($data)
    {
        try {
            $category = Category::create([
                'name' => ucwords($data->name)
            ]);
            if ($category) {
                return $category;
            }
        } catch (\Exception $e) {
            return response()->json(["message" => "Unable to create category"]);
        }
    }

    public function by_id($name_or_id)
    {
        $category_with_blogs = Category::with('blog', 'comment')
            ->where('id', $name_or_id)
            ->orWhere('name', $name_or_id)
            ->first();

        if ($category_with_blogs) {
            return $category_with_blogs;
        } else {
            return response()->json(["message" => "No content for this category"]);
        }
    }

    public function update_item($data)
    {
        try {
            $updated = Category::where('id', $data->id)->first();
            $updated->name = ucwords($data->name);
            $updated->save();

            if ($updated) {
                return $updated;
            }
        } catch (\Exception $e) {
            return response()->json(["message" => "Sorry could not update this category"]);
        }
    }


    public function delete_item($id)
    {
        try {
            $deleted = Category::where('id', $id)->delete();
            if ($deleted) {
                return response()->json(["message" => "Category deleted"]);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => "Sorry could not delete this category"]);
        }
    }
}
