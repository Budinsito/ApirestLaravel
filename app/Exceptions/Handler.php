<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;


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
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
       

        if($exception instanceof ModelNotFoundException){
            $modelo= strtolower(class_basename($exception->getModel())) ;
            return $this->errorResponse("No existe ninguna instancia de {$modelo} con el id especificado",404);
        }

    // Hace la regla de validacion 
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
            }

             // Hace la regla de validacion 
        if ($exception instanceof AuthorizationException) {
              return $this->errorResponse("No posee los permisos para ejecutar la accion",403);
            }

        if ($exception instanceof NotFoundHttpException) {
              return $this->errorResponse("No se encontro la Url especificada",404);
            }

        if ($exception instanceof MethodNotAllowedHttpException) {
              return $this->errorResponse("El metodo especificado en la peticion no es valido",405);
            }

        if ($exception instanceof HttpException) {
              return $this->errorResponse($exception->getMessage() ,$exception->getStatusCode());
            }

        if ($exception instanceof QueryException) {
            // dd($exception );
            $codigo= $exception->errorInfo[1];
                if( $codigo ==1451){
                     return $this->errorResponse('No se puede eliminar por que el recurso esta relacionado con algun otro' ,409);
                }
            }

// Valida errores internos de error 500
if (config('app.debug')){
        return parent::render($request, $exception);
    }
        return $this->errorResponse('Falla en el servidor',500);
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
