<?php


namespace HoangDo\Common\Middleware;


use Closure;
use HoangDo\Common\Helper\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class ResponseJsonMiddleware
{
    public function handle($req, Closure $next)
    {
        /** @var Response $controllerResponse */
        $controllerResponse = $next($req);
//        dd($controllerResponse);
        $data = $controllerResponse->original;

        if (!in_array($controllerResponse->getStatusCode(), [200, 201]))
            return $controllerResponse;
        if ($controllerResponse instanceof JsonResponse) {
            if (is_array($data) || $data instanceof Collection || $data instanceof Model || is_object($data)) {
                $is_multi = false;
                $meta = null;
                if (Utils::isSequentialArray($data) || $data instanceof Collection) {
                    $is_multi = true;
                } elseif (is_array($data)) {
                    $has_data = array_key_exists('data', $data);
                    $has_datas = array_key_exists('datas', $data);

                    if (array_key_exists('message', $data) && array_key_exists('status', $data))
                        return response()->json($data, $controllerResponse->getStatusCode());

                    if (array_key_exists('meta', $data))
                        $meta = $data['meta'];

                    $data = $has_datas
                        ? $data['datas']
                        : ($has_data
                            ? $data['data']
                            : $data);
                    $is_multi = $has_datas;
                }
                return $this->makeResponse($data, $controllerResponse->getStatusCode(), $is_multi, $meta);
            }
        }

        return $controllerResponse;
    }

    private function makeResponse($data, $status, $is_multi = false, $meta = null, $message = null): JsonResponse
    {
        $res = [
            'status' => 1,
            'message' => $message ? $message : __('messages.success')
        ];
        if ($is_multi) {
            $res['datas'] = $data;
        } else {
            $res['data'] = $data;
        }
        if ($meta) {
            $res['meta'] = $meta;
        }

        return response()->json($res, $status);
    }
}
