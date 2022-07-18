<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Support\Facades\Log;

class CacheSubscriber
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handleCacheHit(CacheHit $event)
    {
        Log::info("{$event->key} cache hit");
    }

    public function handleCacheMissed(CacheMissed $event)
    {
        Log::info("{$event->key} cache miss");
    }

    public function subscribe($event){
        $event->listen(
            CacheHit::class,
            'App\Listeners\CacheSubscriber@handleCacheHit'
        );

        $event->listen(
            CacheMissed::class,
            'App\Listeners\CacheSubscriber@handleCacheMissed'
        );
    }
}
