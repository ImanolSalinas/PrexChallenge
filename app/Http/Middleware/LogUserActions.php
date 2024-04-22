<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Log; // Importa tu modelo Log

class LogUserActions
{
    /**
     * Manejar la solicitud entrante.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
    
        $route = $request->route();
        $service = $route->getName() ?? 'unnamed_route'; 

        $statusCode = $response->getStatusCode();
        $responseBody = $response->getContent();

        if ($this->isHtmlResponse($responseBody)) {
            // Maneja el cuerpo de la respuesta HTML de manera adecuada
            $responseBody = json_encode(['html' => 'Redirection or HTML response']);
        } else {
            // Asegúrate de que el cuerpo de la respuesta sea un JSON válido
            $responseBody = json_encode(['content' => $responseBody]);
        }

        $log = new Log();
        $log->user_id = auth()->check() ? auth()->id() : null;
        $log->service = $service;
        $log->request_body = json_encode($request->all());
        $log->http_code = $statusCode;
        $log->response_body = $responseBody; // Ahora siempre es un JSON válido
        $log->ip_origin = $request->ip();

        $log->save();
       
    
        return $response;
    }
    
    // Función auxiliar para verificar si la respuesta es HTML
    protected function isHtmlResponse($content)
    {
        return str_starts_with(trim($content), '<!DOCTYPE html>') || str_starts_with(trim($content), '<html');
    }

    
}