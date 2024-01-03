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
        $identifier = $request->input('identifier');
        $password = $request->input('password');

        $client = new \GuzzleHttp\Client(['base_uri' => 'http://backend.dev.com/']);

        try {
            $response = $client->post('api/login', [
                'form_params' => [
                    'username' => $identifier, // Send the identifier as 'username'
                    'email' => $identifier, // Send the identifier as 'email'
                    'password' => $password,
                ],
            ]);
            session(['token' => json_decode($response->getBody()->getContents(), true)]);
            if (session()->has('token')) {
                return redirect('dashboard');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'email / password not match !');
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle authentication error or other exceptions
            return redirect()
                ->back()
                ->with('error', 'Email/username or password is incorrect.');
        }
    }

    public function showToken()
    {
        dd(session('token'));
    }

    public function logout(Request $request)
    {
        $client = new Client();
        $token = session('token')['token'];
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

    public function IndexgetMe()
    {
        $headers = [
            'Authorization' => 'Bearer ' . session('token')['token'],
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

    public function updateProfile(Request $request)
    {
        $headers = [
            'Authorization' => 'Bearer ' . session('token')['token'],
        ];

        $client = new \GuzzleHttp\Client(['base_uri' => 'http://backend.dev.com/']);

        try {
            //code...
            $response = $client->request('PUT', 'api/profile/2', [
                'headers' => $headers,
                'json' => [
                    'username' => $request->username,
                    'email' => $request->email,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                ],
            ]);
            if ($response->getStatusCode() === 200) {
                return redirect()
                    ->back()
                    ->with('success', 'Profile Updated Successfully');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Something went wrong while updating the profile.');
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $data = json_decode($responseBodyAsString, true);
            // dd($data['errors']['email'][0]);

            $errorMessage = '';

            if (isset($data['errors']['email'][0])) {
                $errorMessage = $data['errors']['email'][0];
            } elseif (isset($data['errors']['username'][0])) {
                $errorMessage = $data['errors']['username'][0];
            } else {
                // Handle a general error message here if needed
                $errorMessage = 'Validation error occurred.';
            }
        
            return redirect()
                ->back()
                ->with('error', $errorMessage);
        }

        // if (isset($contentArray['errors'])) {
        //     // Handle validation errors here
        //     $errors = $contentArray['errors'];
        //     // Implement logic to display or handle these errors
        //     // For example, you could log them or show them to the user
        //     dd($errors);
        // } else {
        //     // No errors, proceed with the rest of your logic
        //     $data = $contentArray;
        //     dd($data);
        // }

        // 'username' => $request->username,
        //         'email' => $request->email,
        //         'firstname' => $request->firstname,
        //         'lastname' => $request->lastname,
        // if ($response->getStatusCode() === 200) {
        //     return redirect()
        //         ->back()
        //         ->with('success', 'Profile Updated Successfully');
        // } else {
        //     return redirect()
        //         ->back()
        //         ->with('error', 'Something went wrong while updating the profile.');
        // }
    }
}
