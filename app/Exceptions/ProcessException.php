<?php

namespace App\Exceptions;

use App\Traits\Responder;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProcessException extends Exception
{
    use Responder;

    /**
     * Report the exception.
     */
    public function report(): bool
    {
        return true;
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return $this->error($this->getMessage(), ResponseAlias::HTTP_NOT_FOUND);
        } else {
            alert()->html(__('Error'), $this->getMessage(), 'error');
            return back()->withInput();
        }
    }
}
