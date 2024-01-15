<?php

namespace App\Http\Controllers\api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    public function index()
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://backend.dev.com/']);
        $response = $client->request('GET', 'api/post');
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true); // Merubah data menjadi bentuk array
        $data = $contentArray['data'];

        if (session()->has('token')) {
            # code...
            return view('post.index', ['data' => $data]);
        }
        return redirect('login');
    }

    public function store(Request $request)
    {
        $headers = [
            'Authorization' => 'Bearer ' . session('token')['token'],
        ];

        try {
            //code...
            $client = new \GuzzleHttp\Client(['base_uri' => 'http://backend.dev.com/']);
            $response = $client->request('POST', 'api/posts', [
                'headers' => $headers,
                'json' => [
                    'title' => $request->title,
                    'news_content' => $request->news_content,
                ],
            ]);
            if ($response->getStatusCode() == 200) {
                return redirect()
                    ->back()
                    ->with('error', 'Something is wrong :(');
            } else {
                return redirect()
                    ->back()
                    ->with('success', 'Post created successfully !');
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            //throw $th;
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $data = json_decode($responseBodyAsString, true);
            return redirect()
                ->back()
                ->with('error', $data['message']);
        }

        // $content = $response->getBody()->getContents();
        // $contentArray = json_decode($content, true); // Merubah data menjadi bentuk array
        // $data = $contentArray['data'];
        // // dd($data);
        // return view('post.create-post', ['data' => $data]);
    }

    public function indexCreate()
    {
        if (session()->has('token')) {
            # code...
            return view('post.create-post');
        }
        return redirect('login');
    }

    public function destroy(Request $request)
    {
        $headers = [
            'Authorization' => 'Bearer ' . session('token')['token'],
        ];

        try {
            $ids = explode(',', $request->input('ids'));

            // dd($ids);
            foreach ($ids as $id) {
                # code...
                $client = new \GuzzleHttp\Client(['base_uri' => 'http://backend.dev.com/']);
                $response = $client->request('DELETE', "api/posts/$id", [
                    'headers' => $headers,
                ]);
                $content = $response->getBody()->getContents();
                $contentArray = json_decode($content, true);
                $data = $contentArray;
            }
            if ($response->getStatusCode() == 200) {
                return redirect()
                    ->back()
                    ->with('success', $data['message']);
            } else {
                return false;
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $data = json_decode($responseBodyAsString, true);
            return redirect()
                ->back()
                ->with('error', $data['message']);
        }
    }

    public function IndexEdit()
    {
        $headers = [
            'Authorization' => 'Bearer ' . session('token')['token'],
        ];
    }
}
