<?php


namespace HoangDo\Common\Helper;


use BenSampo\Enum\Enum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Utils
{
    public static function isSequentialArray($arr): bool {
        return is_array($arr) && $arr === array_values($arr);
    }

    public static function filterData($data): array {
        return array_filter($data, function ($value, $key) {
            return !is_null($value);
        }, ARRAY_FILTER_USE_BOTH);
    }

    public static function getMeta(LengthAwarePaginator $paginateData): array
    {
        $paginateData->appends(request()->query());

        return [
            'total' => $paginateData->total(),
            'limit' => (int)$paginateData->perPage(),
            'current_page' => $paginateData->currentPage(),
            'last_page' => $paginateData->lastPage(),
            'next_url' => $paginateData->nextPageUrl(),
            'prev_url' => $paginateData->previousPageUrl()
        ];
    }

    public static function parseNumberProperties(array $data): array {
        foreach ($data as $key => $value) {
            if (is_numeric($value)) {
                $data[$key] = $value * 1;
                if (!array_key_exists($key . '_pretty', $data)) {
                    $data[$key . '_pretty'] = number_format($data[$key]);
                }

            }
            if (is_array($value)) {
                $data[$key] = parse_number_properties($value);
            }
        }
        return $data;
    }

    /**
     * @param Enum[] $enums
     * @return string
     */
    public static function generateDbComment(array $enums) {
        $comment = '';
        foreach ($enums as $enum)
            $comment .= $enum->value . ': ' . $enum->description . '. ';
        return $comment;
    }
}
