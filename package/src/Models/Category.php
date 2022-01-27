<?php

namespace Oluwatosin\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";
    protected $fillable = [];
    protected $guarded = [];

    public function blog()
    {
        return $this->hasMany(Blog::class);
    }

    public function comment()
    {
        // the table that does not have any relation with main table
        // the table that has relationship with the main table
        // the main_id in the table that has relationship
        // the table_id of the table that has relationship with the main table
        // optional local key on main table
        // local key on table that has relationship with the main table
        return $this->hasManyThrough(Comment::class, Blog::class, 'category_id', 'blog_id', 'id', 'id');
    }

    public function table_name()
    {
        return $this->table;
    }
}
