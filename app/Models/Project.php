<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id','name'
    ];

    /**
     * Get the post that owns the comment.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the comments for the blog post.
     */
    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
