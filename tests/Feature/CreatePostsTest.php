<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_guest_user_cannot_create_a_json_post()
    {
        $excerpt = 'My first excerpt';
        $response = $this->postJson(route('api.posts.store'),['excerpt'=>$excerpt]);
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function a_registered_user_can_create_a_post()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->postJson(route('api.posts.store'),$this->postData());

        $this->assertDatabaseHas('posts',$this->postData());
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'post'=>['user_id','title','excerpt','published_at']
        ]);
    }

    /**
     * @test
     */
    public function post_requires_all_fields()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->postJson(route('api.posts.store'),$this->postData([
            'title' => '',
            'excerpt' => '',
            'published_at' => ''
        ]));
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message','errors'=>['title','excerpt','published_at']
        ]);
    }

    /**
     * @test
     */
    public function post_requires_a_title_and_excerpt_minimum_length_5()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->postJson(route('api.posts.store'),$this->postData([
            'title' => 'asdf',
            'excerpt' => 'asdf',
        ]));
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message','errors'=>['title','excerpt']
        ]);
    }


    public function postData($overrides=[]):array
    {
        return array_merge([
            'title' => 'My Title',
            'excerpt' => 'My Excerpt',
            'published_at' => Carbon::yesterday()->toDateTimeString()
        ],$overrides);
    }
}
