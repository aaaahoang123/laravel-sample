<?php

namespace HoangDo\Notification\Middleware;

use Closure;
use Exception;
use HoangDo\Notification\Service\NotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotifyTokenMiddleware
{
    private NotifyService $notifyService;
    public function __construct(
        NotifyService $notifyService
    )
    {
        $this->notifyService = $notifyService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $appToken = $request->header(config('notification.token_header'));
        $os = $request->header(config('notification.os_header'));
//        if (!$os || !in_array($os, [OSOptions::ANDROID, OSOptions::IOS]))
//            $os = OSOptions::ANDROID;
        if ($user && $appToken) {
            try {
                $this->notifyService->storeTokenForUser($user->id, $appToken, $os);
            } catch (Exception $e) {
                Log::error($e);
            }

        }
        return $next($request);
    }
}
