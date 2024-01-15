<?php

namespace Bgies\EdiLaravel\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Tests\TestCase;
use Bgies\EdiLaravel\Tests\User;

class CreateEdiTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authenticated_users_can_create_edi_type()
    {
       $this->withoutExceptionHandling();
       
        // To make sure we don't start with a Post
        $this->assertCount(0, Post::all());

        $author = User::factory()->create();

        $response = $this->actingAs($author)->post(route('editypes.store'), [
            'name' => 'My first fake EdiType name',
            'description'  => 'My first EDIType description',
        ]);

        $this->assertCount(1, EdiType::all());

        tap(EdiType::first(), function ($ediType) use ($response, $author) {
            $this->assertEquals('My first fake EdiType name', $post->name);
            $this->assertEquals('My first EDIType description', $post->description);
            $this->assertTrue($ediType->author->is($author));
            $response->assertRedirect(route('editype.show', $ediType));
        });
    }
    
    function edi_type_requires_a_title_and_a_body()
    {
       $this->withoutExceptionHandling();
       
       $author = User::factory()->create();
       
       $this->actingAs($author)->post(route('editypes.store'), [
          'name' => '',
          'description'  => 'Some valid body',
       ])->assertSessionHasErrors('name');
       
       $this->actingAs($author)->post(route('editypes.store'), [
          'name' => 'Some valid title',
          'description'  => '',
       ])->assertSessionHasErrors('description');
    }
    
    function guests_can_not_create_posts()
    {
       $this->withoutExceptionHandling();
       
       // We're starting from an unauthenticated state
       $this->assertFalse(auth()->check());
       
       $this->editype(route('editypes.store'), [
          'name' => 'A valid name',
          'description'  => 'A valid description',
       ])->assertForbidden();
    }
    
    function all_posts_are_shown_via_the_index_route()
    {
       $this->withoutExceptionHandling();
       
       // Given we have a couple of EDITypes
       EdiType::factory()->create([
          'name' => 'EDI Type number 1'
       ]);
       EdiType::factory()->create([
          'name' => 'EDI Type number 2'
       ]);
       EdiType::factory()->create([
          'name' => 'EDI Type number 3'
       ]);
       
       // We expect them to all show up
       // with their title on the index route
       $this->get(route('posts.index'))
       ->assertSee('Post number 1')
       ->assertSee('Post number 2')
       ->assertSee('Post number 3')
       ->assertDontSee('Post number 4');
    }
}
