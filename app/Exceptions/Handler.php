<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
//    public function render($request, Exception $exception)
//    {
//        return parent::render($request, $exception);
//    }

    public function render($request, Exception $exception)
    {

//
//        if($request->wantsJson()){
//            $exception = $this->prepareException($exception);
//            $code = method_exists($exception,'getStatusCode') ? $exception->getStatusCode() : $exception->getCode();
//            $code = empty($code) ? 500 : $code;
//            return response([
//                'message' => $exception->getMessage()
//            ],$code);
//        }

        if($request->wantsJson()){
            /**  @var ValidationException $exception */
            $exception = $this->prepareException($exception);
            if($exception instanceof ValidationException){
                return response([
                    'errors' =>  $exception->errors()
                ],422);
            }

            if($exception instanceof AuthenticationException){
                return response([
                    'errors' =>  'دسترسی شما به api امکانپذیر نیست',
                ],401);
            }
            $code = method_exists($exception,'getStatusCode') ? $exception->getStatusCode() : 500;
            dd($exception);
            return response([
                'massage'=> $code == 500 ? 'خطایی در سرور رخ داده است' : $exception->getMessage()
            ],$code);
        }
        return parent::render($request, $exception);
    }

}
