<?php


namespace HoangDo\Notification\Controller;


use HoangDo\Notification\Request\NotificationRequest;
use HoangDo\Notification\Service\NotifyService;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    private NotifyService $notifyService;

    public function __construct(NotifyService $notifyService)
    {
        $this->notifyService = $notifyService;
    }

    public function create(NotificationRequest $req)
    {
        return $this->notifyService->createNotifiesAndPush($req);
    }
}
