<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class Counter{

    public function increment(string $key, array $tags = null): int{
        $sessionId = session()->getId(); //Get current user session
        $counterKey = "{$key}-counter"; //cache key how many users are on the page 
        $usersKey = "{$key}-users"; // cache key store information about users on the page

        $users = Cache::tags(['blog-post'])->get($usersKey,[]);  //Useres  of  specific cache for specific blogPost [sessionId , lastVisitTime]
        $usersUpdate = []; //all users that are not expired [sessionId,lastVisit]
        $diffrence = 0; //how many new users to add to counter key
        $now = now();

        foreach($users as $session => $lastVisit){
            if($now->diffInMinutes($lastVisit) >= 1){
                $diffrence--;
            }
            else{
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId,$users) || $now->diffInMinutes($users[$sessionId]) >= 1){
            $diffrence++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::tags(['blog-post'])->forever($usersKey,$usersUpdate); //key of spesific blogPost, users that are on this blogPost

        if(!Cache::tags(['blog-post'])->has($counterKey)){  //if i am the first user in the blogPost
            Cache::tags(['blog-post'])->forever($counterKey,1);
        }
        else{
            Cache::tags(['blog-post'])->increment($counterKey,$diffrence);
        }

        $counter = Cache::tags(['blog-post'])->get($counterKey);  //counter = how many users are in the spesific blogPost
        return $counter;
    }
}