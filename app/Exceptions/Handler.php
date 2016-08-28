<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


/*tmk*/
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {


        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($e instanceof NotFoundHttpException) {
        
            //$e = new NotFoundHttpException($e->getStatusCode()." ".$e->getMessage(), $e);
            $e = new NotFoundHttpException("404 Not found.", $e);
        }

        if ($e instanceof MethodNotAllowedHttpException) {

            //$e = new NotFoundHttpException($e->getStatusCode()." ".$e->getMessage(), $e);
            $e = new NotFoundHttpException("405 Method not defined.", $e);

        }

        if ($e instanceof ModelNotFoundException) {

            $e = new NotFoundHttpException("Resource not found.", $e);

        }

        if ($e instanceof TokenMismatchException) {

            return redirect('login')->with('message', 'You page session expired. Please try again');
            //return response()->view('errors.custom', [], 500);

        }

        

        return parent::render($request, $e);
    }




}
