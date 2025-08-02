<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Exceptions\TaskNotFoundException;
use App\Exceptions\CategoryHasTasksException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Handle ModelNotFoundException (when findOrFail fails)
        if ($exception instanceof ModelNotFoundException) {
            $modelName = class_basename($exception->getModel());
            
            switch ($modelName) {
                case 'Task':
                    return redirect()->route('tasks.index', -1)
                        ->with('error', 'Task not found or you do not have permission to access it.');
                case 'Category':
                    return redirect()->route('categorys.index')
                        ->with('error', 'Category not found or you do not have permission to access it.');
                default:
                    return redirect()->back()
                        ->with('error', 'The requested resource was not found.');
            }
        }

        // Handle TaskNotFoundException
        if ($exception instanceof TaskNotFoundException) {
            return redirect()->route('tasks.index', -1)
                ->with('error', $exception->getMessage());
        }

        // Handle CategoryHasTasksException
        if ($exception instanceof CategoryHasTasksException) {
            return redirect()->route('categorys.index')
                ->with('error', $exception->getMessage());
        }

        // Handle ValidationException
        if ($exception instanceof ValidationException) {
            return redirect()->back()
                ->withErrors($exception->errors())
                ->withInput();
        }

        // Handle general exceptions in production
        if (app()->environment('production')) {
            // Log the exception for debugging
            \Log::error('Unhandled exception: ' . $exception->getMessage(), [
                'exception' => $exception,
                'request' => $request->all(),
                'user_id' => auth()->id(),
            ]);

            // Return user-friendly error page
            return redirect()->back()
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }

        return parent::render($request, $exception);
    }
}

