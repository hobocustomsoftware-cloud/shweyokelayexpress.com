<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // API routes: always return JSON with correct status code
        $exceptions->shouldRenderJsonWhen(function (Request $request, \Throwable $e) {
            return $request->is('api/*');
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if (!$request->is('api/*')) {
                return null;
            }
            \Illuminate\Support\Facades\Log::error('API Exception: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            $code = 500;
            $message = 'Server error';
            if ($e instanceof NotFoundHttpException) {
                $code = 404;
                $message = 'Not found';
            } elseif ($e instanceof HttpException) {
                $code = $e->getStatusCode();
                $message = $e->getMessage() ?: 'Error';
            } elseif ($e instanceof \Illuminate\Auth\AuthenticationException) {
                $code = 401;
                $message = 'Unauthenticated.';
            } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
                return null; // Laravel handles 422
            } elseif ($e instanceof \Illuminate\Database\QueryException) {
                $message = config('app.debug') ? $e->getMessage() : 'Database error. Check logs.';
            } elseif (config('app.debug')) {
                $message = $e->getMessage() ?: 'Server error';
            }
            return response()->json(['success' => false, 'message' => $message], $code);
        });
    })->create();
