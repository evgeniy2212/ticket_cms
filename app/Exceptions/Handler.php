<?php

    namespace App\Exceptions;

    use Illuminate\Auth\AuthenticationException;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpKernel\Exception\HttpException;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
    use Throwable;

    class Handler extends ExceptionHandler
    {
        /**
         * A list of the exception types that are not reported.
         *
         * @var array
         */
        protected $dontReport
            = [
                //
            ];

        /**
         * A list of the inputs that are never flashed for validation exceptions.
         *
         * @var array
         */
        protected $dontFlash
            = [
                'password',
                'password_confirmation',
            ];

        /**
         * Report or log an exception.
         *
         * @param \Throwable $exception
         *
         * @return void
         *
         * @throws \Exception
         */
        public function report(Throwable $exception)
        {
            parent::report($exception);
        }

        /**
         * Render an exception into an HTTP response.
         *
         * @param Request    $request
         * @param \Throwable $exception
         *
         * @return Response
         *
         * @throws \Throwable
         */
        public function render($request, Throwable $exception)
        {
            if ($this->shouldReport($exception) && !$this->isHttpException($exception) && !config('app.debug')) {
                $exception = new HttpException(500, 'Whoops!');
            }

            if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
                if ($request->is(config('app.backend') . '*')) {
                    return response()->view('backend.errors.404', [], 404);
                }
                return response()->view('frontend.errors.404', [], 404);
            }
            if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
                return response()->view('backend.errors.403', [], 403);
            }

            return parent::render($request, $exception);
        }

        /**
         * Convert an authentication exception into an unauthenticated response.
         *
         * @param Request                 $request
         * @param AuthenticationException $exception
         *
         * @return JsonResponse|RedirectResponse
         */
        protected function unauthenticated($request, AuthenticationException $exception)
        {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect()->guest(route('login'));
        }
    }
