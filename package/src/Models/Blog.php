<?php

namespace Oluwatosin\Blog\Models;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Blog extends Model
{
    use HasFactory;

    protected $table = "blogs";
    protected $fillable = [];
    protected $guarded = [];

    public static function imageIntervention($image)
    {
        Image::make(storage_path('app/public/') . $image)
            ->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->orientate()
            ->sharpen(5)
            ->encode('jpg', 75)
            ->save(storage_path('app/public/' . $image))
            ->destroy();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function table_name()
    {
        return $this->table;
    }
}
