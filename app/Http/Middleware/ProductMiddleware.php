<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ProductMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwt = $request->bearerToken();

        if($jwt == 'null' || $jwt == ''){
            return response ()->json([
                'msg'=> 'Akses ditolak token tidak memenuhi'
            ],401);        
        }else{
            $jwtDecoded = JWT::decode($jwt, new Key(env('JWT_SECRET_KEY'), 'HS256'));

            if($jwtDecoded->role =='admin' ||$jwtDecoded->role =='user'){
                return $next($request);
            }
            return response()->json([
                'msg'=> 'Akses ditolak, Token tidak memenuhi'
            ],401);
        }
    }
}
