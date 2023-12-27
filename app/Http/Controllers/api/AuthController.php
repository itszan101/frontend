<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('token')) {
            return redirect(route('dashboard')); // Redirect to a different route after login
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $pass = $request->password;

        $client = new \GuzzleHttp\Client(['base_uri' => 'http://backend.dev.com/']);
        $response = $client->request('POST', 'api/login', [
            'form_params' => [
                'email' => $email,
                'password' => $pass,
            ],
        ]);
        // dd(json_decode($response->getBody()->getContents(), true));
        session(['token' => json_decode($response->getBody()->getContents(), true)]);
        if (session()->has('token')) {
            return redirect('dashboard');
        } else {
            return redirect()->back()->with('error', 'email / password not match !');
        }
    }

    public function showToken()
    {
        dd(session('token'));
    }

    public function logout(Request $request)
    {
        $client = new Client();
        $token = session('token')[0];
        $response = $client->get('http://backend.dev.com/api/logout', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        $request->session()->forget('token'); // Redirect to a route for frontend cleanup
        return redirect(route('login'));
        // dd(json_decode($response->getBody()->getContents(), true));
    }

    public function getMe()
    {
        $headers = [
            'Authorization' => 'Bearer ' . session('token')[0],
        ];

        $client = new \GuzzleHttp\Client(['base_uri' => 'http://backend.dev.com/']);
        $response = $client->request('GET', 'api/getme', [
            'headers' => $headers,
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true); // Merubah data menjadi bentuk array
        $data = $contentArray;
        return view('auth.profile', ['data' => $data]);
    }
}
