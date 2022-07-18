<?php

namespace App\Services;

use App\Contracts\CounterContract;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Contracts\Session\Session;

class Counter implements CounterContract{

    private $timeout;
    private $cache;
    private $session;
    private $supportsTags;

    public function __construct(Cache $cache, Session $session, int $timeout){
        $this->cache = $cache;
        $this->timeout = $timeout;
        $this->session = $session;
        $this->supportsTags = method_exists($cache,'tags');
    }

    public function increment(string $key, array $tags = null): int{

        $sessionId = $this->session->getId(); //Get current user session
        $counterKey = "{$key}-counter"; //cache key how many users are on the page 
        $usersKey = "{$key}-users"; // cache key store information about users on the page

        $cache = $this->supportsTags && $tags != null 
            ? $this->cache->tags($tags) : $this->cache; // tags is in redLine-have to be fixed

        $users = $cache->get($usersKey,[]);  //Useres  of  specific cache for specific blogPost [sessionId , lastVisitTime]
        $usersUpdate = []; //all users that are not expired [sessionId,lastVisit]
        $diffrence = 0; //how many new users to add to counter key
        $now = now();

        foreach($users as $session => $lastVisit){
            if($now->diffInMinutes($lastVisit) >= $this->timeout){
                $diffrence--;
            }
            else{
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId,$users) || $now->diffInMinutes($users[$sessionId]) >= $this->timeout){
            $diffrence++;
        }

        $usersUpdate[$sessionId] = $now;
        $cache->forever($usersKey,$usersUpdate); //key of spesific blogPost, users that are on this blogPost

        if(!$cache->has($counterKey)){  //if i am the first user in the blogPost
            $cache->forever($counterKey,1);
        }
        else{
            $cache->increment($counterKey,$diffrence);
        }

        $counter = $cache->get($counterKey);  //counter = how many users are in the spesific blogPost
        return $counter;
    }
}