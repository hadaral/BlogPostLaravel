<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BlogPost extends Model
{

    use SoftDeletes;
    use Taggable;

    protected $fillable = ['title','content','user_id'];

    public function comments(){
        return $this->morphMany(Comment::class,'commentable')->latest();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }

    public function scopeLatest(Builder $query){
        return $query->orderBy(static::CREATED_AT,'desc');
    }

    public function scopeMostCommented(Builder $query){
        return $query->withCount('comments')->orderBy('comments_count','desc');
    }

    public function scopeLatestWithRelations(Builder $query){
        return $query->latest()
            ->withCount('comments')
            ->with('user','tags');
    }

    public static function boot(){

        static::addGlobalScope(new DeletedAdminScope);

        parent::boot();
        // static::addGlobalScope(new LatestScope);
    }

    use HasFactory;
}
