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
            return redirect(route('token')); // Redirect to a different route after login
        }
        return view('auth.login');
    }

    // public function login(Request $request)
    // {
    //     $client = new Client(['base_uri' => 'http://backend.dev.com']); // Replace with your API base URL

    //     try {
    //         $response = $client->post('/api/login', [
    //             'form_params' => [
    //                 'email' => 'user1@test.com',
    //                 'password' => '12344321',
    //             ],
    //         ]);

    //         $data = json_decode($response->getBody(), true);

    //         if (isset($data['token'])) {
    //             $tokenParts = explode('|', $data['token']);

    //             // Check if token has at least two parts and the second part is not empty
    //             if (count($tokenParts) >= 2 && !empty($tokenParts[1])) {
    //                 $x = $request->session()->put('api_token', $tokenParts[1]);
    //                 return response()->json([$x]); // Redirect to homepage after successful login
    //             }
    //         }

    //         return redirect()->back()->withInput()->withErrors(['error' => 'Invalid token format or missing token.']);
    //     } catch (\Exception $e) {
    //         // Handle Guzzle HTTP request exception
    //         return redirect()->back()->withInput()->withErrors(['error' => 'Error occurred during login.']);
    //     }
    // }


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
        if ($response->getStatusCode() == 200) {
            return redirect(route('token'));
        } else {
            return false;
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
                'Authorization' => 'Bearer ' .$token,
            ],
        ]);
        
        $request->session()->forget('token'); // Redirect to a route for frontend cleanup
        return redirect(route('login'));
        // dd(json_decode($response->getBody()->getContents(), true));
    }
}
