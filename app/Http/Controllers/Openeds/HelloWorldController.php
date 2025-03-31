<?php

namespace App\Http\Controllers\Openeds;

use App\Http\Controllers\Controller;
use App\Services\HelloWorldService;
use Illuminate\Http\JsonResponse;

class HelloWorldController extends Controller
{
    public function get() : JsonResponse
    {
        $helloWorld = new HelloWorldService();
        return response()->json($helloWorld->get(), 200);
    }
}
