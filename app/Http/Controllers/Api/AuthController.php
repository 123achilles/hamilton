<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
//
//        $token = $user->createToken('TutsForWeb')->accessToken;

        $http = new Client();

        $response = $http->post('http://localhost/hamilton/public/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'LIZMeIzqm30YyGoMguEKFwaNOj8KDAuHaaMAjziw',
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);

//        return response()->json(['token' => $token], 200);
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
//        return response()->json($e, 422);
        $http = new Client();
        if (auth()->attempt($credentials)) {
            $response = $http->post(config('app.url').'/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
//                    'client_id' => '2',
                    'client_id' => config('auth.passport.password.id'),
                    'client_secret' => config('auth.passport.password.secret'),
//                    'client_secret' => 'LIZMeIzqm30YyGoMguEKFwaNOj8KDAuHaaMAjziw',
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => '',
                ],
            ]);
            return json_decode((string) $response->getBody(), true);
        } else {
            return response()->json(['error' => 'unauthorized'], 401);
        }
    }
}
