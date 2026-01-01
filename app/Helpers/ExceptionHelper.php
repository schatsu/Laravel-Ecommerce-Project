<?php

namespace App\Helpers;

use App\Exceptions\ProcessException;
use App\Traits\Responder;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\ViewException;
use RealRashid\SweetAlert\Facades\Alert;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionHelper
{
    use Responder;

    /**
     * @throws Exception
     */
    public function throwException(Throwable $throwable, Request $request): Response|JsonResponse|RedirectResponse|null
    {
        if ($request->expectsJson()) {
            if ($throwable instanceof RuntimeException) {
                if ($throwable->getMessage() === 'Personal access client not found. Please create one.') {
                    return $this->error(__('Something went wrong') . " : " . "0xC0121001");
                }
            }
            if ($throwable instanceof AuthenticationException) {
                return $this->error(__('Your session has ended.'));
            }
            if ($throwable instanceof QueryException) {

                return $this->error(App::environment(['local', 'development']) ? $throwable->getMessage() : __('Something went wrong'));
            }
            if ($throwable instanceof ModelNotFoundException) {
                return $this->error(__('exceptions.model_not_found'), ResponseAlias::HTTP_NOT_FOUND);
            }
            if ($throwable instanceof ValidationException) {
                $messages = "";
                foreach ($throwable->errors() as $key => $values) {
                    foreach ($values as $value) {
                        $messages .= Str::ucfirst($value) . PHP_EOL;
                    }
                }
                return $this->error($messages, ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
            }

            return $this->error($throwable->getMessage() ?? __('Something went wrong'));
        } else {
            if ($throwable instanceof QueryException) {
                alert()->html(__('Error'), App::environment(['local', 'production']) ? $throwable->getMessage() : __('Something went wrong'), 'error');
                return back()->withInput();
            }
            if ($throwable instanceof ViewException) {
                alert()->html(__('Error'), $throwable->getMessage(), 'error');
                return back()->withInput();
            }
            if ($throwable instanceof ModelNotFoundException) {
                return response()->view('errors.404', [
                    'message' => __('Page Not Found')
                ], 404);
            }
            if ($throwable instanceof ValidationException) {
                $messages = "";
                foreach ($throwable->errors() as $key => $values) {
                    foreach ($values as $value) {
                        $messages .= Str::ucfirst($value) . "<br>";
                    }
                }
                alert()->html(__('messages.validation_error'), $messages, 'error');
            }
            if ($throwable instanceof RuntimeException) {
                if ($throwable->getMessage() === 'Personal access client not found. Please create one.') {
                    alert()->html(__('Error'), __('Something went wrong'). " : " . "0xC0121001", 'error');
                    return back()->withInput();
                }
            }
            if ($throwable instanceof NotFoundHttpException) {
                return response()->view('errors.404', ['message' => __('Page Not Found')], 404);
            }
            if ($throwable instanceof MethodNotAllowedHttpException) {
                alert()->html(__('Error'), __('Method not allowed'), 'error');
                return back()->withInput();
            }
            return null;
        }
    }
}
