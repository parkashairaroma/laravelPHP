<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use \hisorange\BrowserDetect\Facade as Browser;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [];

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
        return parent::report($e);
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
        $uri = $request->server->get('REQUEST_URI');
        $appEnv = getenv('APP_ENV');

        switch ($appEnv) {
            case 'development':
                switch (true) {
                    case $e instanceof NotFoundHttpException:
                        break;
                    case $e instanceof TokenMismatchException:
                        break;
                    case $e instanceof ModelNotFoundException:
                        $this->alertSlack($request, class_basename($e));
                        break;
                    case $e instanceof MethodNotAllowedHttpException:
                        break;
                    default:
                        $this->alertSlack($request, class_basename($e));
                }
                $this->logError($request, class_basename($e));
                return parent::render($request, $e);
            break;
            case 'production':
                switch (true) {
                    case $e instanceof NotFoundHttpException:
                        return response()->view('errors.missing-route', [], 404);
                    break;
                    case $e instanceof TokenMismatchException:
                        return response()->view('errors.missing-route', [], 404);
                        break;
                    case $e instanceof ModelNotFoundException:
                        $this->alertSlack($request, class_basename($e));
                        $this->sendMail($request, $e);
                        return response()->view('errors.missing-route', [], 404);
                    break;
                    case $e instanceof MethodNotAllowedHttpException:
                        return response()->view('errors.missing-route', [], 404);
                    break;
                    default:
                        $this->alertSlack($request, class_basename($e));
                        $this->sendMail($request, $e);
                        return response()->view('errors.generic', [], 404);
                }
                $this->logError($request, class_basename($e));
                break;
        }
    }

    private function buildMessageData($request, $exception)
    {
        $clientemail = "";

        if (isset(auth()->guard('store')->user()->acc_email))
        {
            $clientemail = auth()->guard('store')->user()->acc_email;
        }

        $data = (object) [
            'ip' => $request->getClientIp(),
            'host' => $request->server->get('HTTP_HOST'),
            'hostIp' => $request->server->get('SERVER_ADDR'),
            'clientemail' => $clientemail,
            'timeStamp' => date('Y-m-d H:i:s', time()),
            'exception' => $exception,
            'referrer' => $request->server->get('HTTP_REFERER'),
            'url' => 'http://'.$request->server->get('HTTP_HOST').$request->server->get('REQUEST_URI'),
            'method' => $request->server('REQUEST_METHOD'),
            'browserName' => Browser::browserFamily(),
            'browserVersion' => Browser::browserVersion(),
            'browserIsMobile' => Browser::isMobile(),
            'browserIsDesktop' => Browser::isDesktop(),
            'browserIsTablet' => Browser::isTablet(),
            'browserIsBot' => Browser::isBot(),
            'browserPlatName' => Browser::platformFamily(),
            'browserPlatVersion' => Browser::platformVersion(),
            'browserDeviceFamily' => Browser::deviceFamily(),
            'browserDeviceModel' => Browser::deviceModel(),
            'browserUserAgent' => Browser::userAgent()
        ];

        return $data;
    }

    /**
     *     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     */
    private function alertSlack($request, $exception)
    {
        $api = app('GuzzleHttp\Client');

        $data = json_encode($this->buildMessageData($request, $exception));

        $channel = '#'.env('APP_NAME').'_'.env('BRANCH');

        $slackPayload =  json_encode([
            'channel'    => $channel,
            'text'       => $data,
            'username'   => 'AirAroma',
            'icon_emoji' => ':ghost:'
        ]);

        $api->request('POST', env('SLACK_HOOK'), ['body' => $slackPayload]);
    }

    /**
     *     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     */
    private function logError($request, $exception)
    {
        $log = app('Illuminate\Log\Writer');

        $data = $this->buildMessageData($request, $exception);

        $log->useDailyFiles(storage_path().'/logs/exceptions/errors.log');
        $log->info(json_encode($data));
    }

    /**
     *     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     */
    private function sendMail($request, $exception)
    {

        $mail = app('Illuminate\Mail\Mailer');

        $data = $this->buildMessageData($request, $exception);

        $data->emailTo = getConfig('app', 'email');
        $data->emailSubject = 'Website Request Error';

        if (Browser::browserFamily() != "Unknown")
        {
            $mail->send('emails.errors', ['data' => $data], function ($mail) use ($data) {
                $mail->to($data->emailTo)
                    ->subject($data->emailSubject);
            });

        }


    }
}
