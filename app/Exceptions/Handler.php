<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{

    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }


    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException){
            return $this->convertExceptionToResponse($exception, $request);
        }
        return parent::render($request, $exception);
    }


    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        // if ($e->response) {
        //     return $e->response;
        // }

        // return $request->expectsJson()
        //             ? $this->invalidJson($request, $e)
        //             : $this->invalid($request, $e);

        $errors = $e->validator->errors()->getMessages();
        // return response()->json($error,422);
        return $this->errorResponse($errors,422);
    }
}
