<?php

namespace App\Traits;

use App\Models\Tag;

trait Taggable {
    
    protected static function bootTaggable(){
        static::updating(function ($model){
            $model->tags()->sync(static::findTagsInContent($model->content)); //replace all relationship that this model actually has with a new set of relationships
        });

        static::created(function ($model){ //because there is no id of the model becase it fired before the model is stored inside the DB
            $model->tags()->sync(static::findTagsInContent($model->content)); //replace all relationship that this model actually has with a new set of relationships
        });
    }

    public function tags(){
        return $this->morphToMany(Tag::class,'taggable')->withTimestamps();
    }

    public static function findTagsInContent($content){
        preg_match_all('/@([^@]+)@/m',$content,$tags);
    
        return Tag::whereIn('name',$tags[1]  ?? [])->get();
    }

}