<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function index()
    {
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
                    // dd($data);
                    return view('client.index',['data'=>$data]);
    }
    

    public function AddClient()
    {
        return view('client.add-client');
    }
}
