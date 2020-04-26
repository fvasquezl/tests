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
                ->waitFor('@my-modal',5)
                ->whenAvailable('@my-modal', function($modal){
                    $modal->type('title','My first title')
                        ->type('excerpt','My first excerpt')
                        ->type('published_at',Carbon::yesterday()->format('m/d/Y'))
                        ->press('@submit-create-btn')
                        ->pause(1000);
                })
                ->assertPathIs('/');
        });
        $this->assertDatabaseCount('posts',1);
    }


    /**
     * A Dusk test example.
     * @test
     * @return void
     * @throws \Throwable
     */
    public function show_validation_on_creation_post_form()
    {
        $user=factory(User::class)->create();

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->press('#create-modal')
                ->waitFor('modal',5)
                ->whenAvailable('modal', function($modal){
                    $modal->press('#submit-post')
                        ->pause(1000)
                        ->assertSeeErrors([
                            'title' => 'The title field is required.',
                            'excerpt' =>'The excerpt field is required.',
                            'published_at' =>'The published at field is required.'
                        ]);
                });
        });
        $this->assertDatabaseEmpty('posts');
    }
}
