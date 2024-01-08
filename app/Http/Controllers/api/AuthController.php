<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showRegisForm()
    {
        if (!session()->has('token')) {
            return view('auth.register');
        }
        return redirect(route('dashboard')); // Redirect to a different route after login
    }

    public function register(Request $request)
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://backend.dev.com/']);

        try {
            //code...
            $response = $client->post('api/register', [
                'form_params' => [
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => $request->password,
                    'password_confirmation' => $request->password_confirmation,
                ],
            ]);
            $responseData = json_decode($response->getBody(), true);
            //  dd($responseData);
            if ($response->getStatusCode() === 200 && isset($responseData['message'])) {
                // dd($response['message']);
                return redirect(route('login'))
                    ->with('success', $responseData['message']);
            } else {
                $errorMessage = 'Something went wrong while registering.';
                if (isset($responseData['message'])) {
                    $errorMessage = $responseData['message'];
                } elseif (isset($responseData['errors']) && isset($responseData['errors']['email'])) {
                    $errorMessage = $responseData['errors']['email'][0];
                }

                return redirect()
                    ->back()
                    ->with('error', $errorMessage);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to register user.');
        }
    }
    

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

    public function profile()
    {
        $token = session('token');
        $tokenValue = isset($token['token']) ? $token['token'] : null;

        if (!$tokenValue) {
            // Redirect to the login page or handle the situation accordingly
            return redirect()->route('login');
        }

        $headers = [
            'Authorization' => 'Bearer ' . $tokenValue,
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
    }
    public function changePassword(Request $request)
    {
        $headers = [
            'Authorization' => 'Bearer ' . session('token')['token'],
        ];

        $client = new \GuzzleHttp\Client(['base_uri' => 'http://backend.dev.com/']);

        try {
            //code...
            $response = $client->request('PUT', 'api/c-pass/2', [
                'headers' => $headers,
                'json' => [
                    'password' => $request->password,
                    'password_confirmation' => $request->password_confirmation,
                ],
            ]);
            if ($response->getStatusCode() === 200) {
                return redirect()
                    ->back()
                    ->with('success2', 'Password Changed Successfully');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Something went wrong while updating the profile.');
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $data = json_decode($responseBodyAsString, true);
            // dd($data['errors']);

            $errorMessage = '';

            if (isset($data['errors']['password'][0])) {
                $errorMessage = $data['errors']['password'][0];
            } else {
                // Handle a general error message here if needed
                $errorMessage = 'Validation error occurred.';
            }

            return redirect()
                ->back()
                ->with('error2', $errorMessage);
        }
    }
}
