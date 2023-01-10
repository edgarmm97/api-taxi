<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    public function handle(Request $request, Closure $next){

        $authHeader = $this->getAuthorizationHeader();

        if (preg_match('/Bearer\s((.*)\.(.*)\.(.*))/', $authHeader, $matches)) {
            $token = trim($matches[1]);
        }

        
        try {
        
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        
        } catch (\Throwable $th) {
            
            return response()->json(['error' => 'Token no valido'], 401);
        
        }

        return $next($request);
    }
}
