<?php

namespace Bgies\EdiLaravel\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Bgies\EdiLaravel\Tests\TestCase;
use Bgies\EdiLaravel\Models\EdiTypes;

class EdiTypesTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  function an_edi_type_post_has_a_title()
  {
    $ediType = EdiTypes::factory()->create(['title' => 'Fake Title']);
    $this->assertEquals('Fake Title', $post->title);
  }
}
