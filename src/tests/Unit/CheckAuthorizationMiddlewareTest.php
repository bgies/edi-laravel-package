<?php

namespace Bgies\EdiLaravel\tests\Unit;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Http\Middleware\CheckAuthorization;
//use Bgies\EdiLaravel\Tests\TestCase;

class CheckAuthorizationMiddlewareTest extends TestCase
{
    /** @test */
    function it_capitalizes_the_request_title()
    {
        // Given we have a request
        $request = new Request();

        // with  a non-capitalized 'title' parameter
        $request->merge(['title' => 'some title']);

        // when we pass the request to this middleware,
        // it should've capitalized the title
        (new CheckAuthorization())->handle($request, function ($request) {
            $this->assertEquals('Some title', $request->title);
        });
    }
}
