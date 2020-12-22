<?php


namespace HoangDo\Notification\Controller;


use HoangDo\Notification\Service\NotifyService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{
    private NotifyService $notifyService;

    public function __construct(NotifyService $notifyService)
    {
        $this->notifyService = $notifyService;
    }

    public function list(Request $req)
    {
        $limit = $req->get('limit');

        $notify = $this->notifyService->listNotifications($limit, $req->user());
        return $notify->items();
    }
    public function read($id)
    {
        return $this->notifyService->findOneAndReadNotification(\request()->user(), $id);
    }
}
