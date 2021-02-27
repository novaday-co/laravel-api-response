<?php

namespace FarazinCo\Tests;

use FarazinCo\LaravelApiResponse\Api;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\JsonResponse;

class ResponseTest extends TestCase
{


    /** @runInSeparateProcess */
    public function test_it_returns_custom_response()
    {
        $response = Api::customResponse(200,'It\'s OK :)',['key'=>'value'])->response();
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /** @runInSeparateProcess */
    public function test_it_returns_extra_parameters()
    {
        $response = Api::success("Hello",['key1'=>'value1'])->with(['key2'=>'value2'])->response();
        $expectedResponse = [
            'data'   => [
                'key1' => 'value1'
            ],
            'message' => "Hello",
            'key2' => 'value2',
        ];
        $this->assertEquals($expectedResponse, json_decode($response->getContent(),true));
    }

}