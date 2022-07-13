<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    
    public function test_HomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');

        $response->assertSeeText('Welcom To Laravel!');
    }

    public function test_ContactPageIsWorkingCorrectly()
    {
        $response = $this->get('/contact');
        $response->assertSeeText('This is a Contact Page');
        
    }
}
