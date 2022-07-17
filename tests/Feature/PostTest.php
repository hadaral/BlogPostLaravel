<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_NoBlogPostWhenNothingInDataBase()
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No posts found!');
    }

    public function test_See1BlogPostWhenThereIsWithNoComments(){
        $post = $this->createDummyBlogPost();

        $response = $this->get('/posts');

        $response->assertSeeText('New title');
        $response->assertSeeText("No comments yet!");

        $this->assertDatabaseHas('blog_posts',['title'=>'New title']);
    }

    public function test_see1BlogPostWithComments(){
        $user = $this->user();
        $post = $this->createDummyBlogPost();
        Comment::factory(4)->create([
            'commentable_id' => $post->id,
            'commentable_type' => BlogPost::class,
            'user_id' => $user->id
        ]);

        $response = $this->get('/posts');
        $response->assertSeeText('4 comments');

    }

    public function test_StoreValid(){
        
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        $this->actingAs($this->user())
        ->post('/posts',$params)
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'The BlogPost was created!');
    }

    public function test_StoreFail(){
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->actingAs($this->user())
        ->post('/posts',$params)
        ->assertStatus(302)
        ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.');

       // dd($messages->getMessages());
    }

    public function test_UpdateValid(){

        // $user = $this->user();
        // $post = $this->createDummyBlogPost($user->id);

        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts',$post->getAttributes());

        $params = [
            'title' => 'A new named title',
            'content' => 'content was changed'
        ];

        // $this->actingAs($user)
        $this->actingAs($this->user())
        ->put("/posts/{$post->id}",$params)
        ->assertStatus(302)
        ->assertSessionHas('status');
        $this->assertEquals(session('status'),'Blog Post was updated!!!');
        $this->assertDatabaseMissing('blog_posts',$post->getAttributes());
        $this->assertDatabaseHas('blog_posts',['title' => 'A new named title']);
    }

    public function test_Delete(){
        $post = $this->createDummyBlogPost();
        $this->assertDatabaseHas('blog_posts',$post->getAttributes());

        $this->actingAs($this->user())
        ->delete("/posts/{$post->id}")
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog post was deleted!');
        // $this->assertDatabaseMissing('blog_posts',$post->getAttributes());
        $this->assertSoftDeleted('blog_posts',$post->getAttributes());
    }

    private function createDummyBlogPost($userId = null): BlogPost{
        // $post = new BlogPost();
        // $post->title = 'New title';
        // $post->content = 'New content';
        // $post->save();

        return BlogPost::factory()->newTitle()->create(
            [
                'user_id' => $userId ?? $this->user()->id,
            ]
        );

        // return $post;
    }
}
