<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogInRequest;
use App\Http\Requests\Auth\SignUpRequest;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = DB::table("oauth_clients")
            ->where("id", config()->get("services.passport.client_id"))
            ->first();
    }

    /**
     * @param SignUpRequest $request
     * @return \Illuminate\Http\JsonResponse|\Psr\Http\Message\StreamInterface
     */
    public function signUp(SignUpRequest $request)
    {
        $http = new \GuzzleHttp\Client();
        try {
            DB::transaction(function () use ($request) {
                DB::table("users")->insert([
                    "name" => $request->name,
                    "email" => $request->email,
                    "password" => bcrypt($request->password),
                ]);
            });
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => $this->client->secret,
                    'username' => $request->email,
                    'password' => $request->password,
                ]
            ]);

            return $response->getBody();

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return response()->json('Algo ocurrió en el servidor 😞', $e->getCode());
        }
    }

    /**
     * @param LogInRequest $request
     * @return \Illuminate\Http\JsonResponse|\Psr\Http\Message\StreamInterface
     */
    public function logIn(LogInRequest $request)
    {

        $http = new \GuzzleHttp\Client();
        try {

            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => $this->client->secret,
                    'username' => $request->email,
                    'password' => $request->password,
                ]
            ]);

            return $response->getBody();

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Email o contraseña inválidos', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Credenciales incorrectas, intenta de nuevo', $e->getCode());
            }

            return response()->json('Algo ocurrió en el servidor 😞', $e->getCode());
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logOut()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Bye', 200);
    }


}
