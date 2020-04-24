<?php

namespace Tests\Browser;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreatePostTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     * @test
     * @return void
     * @throws \Throwable
     */
    public function a_registered_user_can_create_a_post()
    {
        $user=factory(User::class)->create();

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
            ->visit('/')
                ->press('#create-modal')
                ->waitFor('#createPostModal',5)
                ->whenAvailable('#createPostModal', function($modal){
                    $modal->type('title','My first title')
                        ->type('excerpt','My first excerpt')
                        ->type('published_at',Carbon::yesterday()->format('m/d/Y'))
                        ->press('#submit-post')->screenshot('posts')
                        ->pause(1000);
                })
                ->assertPathIs('/');
        });
        $this->assertDatabaseHas('posts',[
            'title'=>'My first title'
        ]);
    }


}
