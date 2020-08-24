<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\WebService;
use Illuminate\Http\Response;

class VerificaToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      // return response()->json(WebService::verificaToken($request->BearerToken()));
      if (WebService::verificaToken($request->BearerToken()) == Response::HTTP_OK) {
          return $next($request);
      } else {
          return response()->json(['mensagem' => 'Não autorizado!'], Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
      }

    }
}
