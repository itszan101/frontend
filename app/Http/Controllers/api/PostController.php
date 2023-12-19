<?php

namespace App\Http\Controllers\api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    public function index() {
        
    $response   = Http::withToken('021de9ccc07a3a01cc4dc555989418c9a36361ae2abb10d79ba2980a6fec80ec')
                    ->withHeaders([
                        'Accept' => 'application/json',
                        'Conten-Type' => 'application/json',
                    ])->withOptions([
                        'verify' => false,
                    ])->get('http://backend.dev.com/api/post/');

                    $content = $response->getBody()->getContents();
                    $contentArray = json_decode($content, true);  // Merubah data menjadi bentuk array
                    $data = $contentArray['data'];
                    dd($data);
                    // return view('post.index',['data'=>$data]);
    }

    public function addNew(Request $request) {

        // $response   = Http::withToken('fd890cae20118118a0ac542db80dcbbfaeeca5fa5dcb2c38c23df1b50589439c')
        //             ->withHeaders([
        //                 'Accept' => 'application/json',
        //                 'Conten-Type' => 'application/json',
        //             ])->withOptions([
        //                 'verify' => false,
        //             ])->get('http://backend.dev.com/api/posts');
        
        //             dd($response);

        $response = (new Client)->get('http://backend.dev.com/api/logout', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.session()->get('token.access_token'),
            ]
        ]);
 
        return json_decode((string) $response->getBody(), true);
    }
}