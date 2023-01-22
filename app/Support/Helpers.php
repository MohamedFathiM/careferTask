<?php

if (! function_exists('successResponse')) {
    function successResponse($data = null, $pagination = null, $extra = [], $status = 200, $message = ' ')
    {
        $json['status'] = true;
        if ($message) {
            $json['message'] = $message;
        }

        if ($extra) {
            foreach ($extra as $key => $value) {
                $json[$key] = $value;
            }
        }

        if ($data) {
            $json['data'] = $data;
        }

        if ($pagination) {
            $meta = [
                'meta' => [
                    'total' => $pagination->total(),
                    'from' => $pagination->firstItem(),
                    'to' => $pagination->lastItem(),
                    'count' => $pagination->count(),
                    'per_page' => $pagination->perPage(),
                    'current_page' => $pagination->currentPage(),
                    'last_page' => $pagination->lastPage(),
                ],
            ];
        }

        return response()->json($json + ($meta ?? []), $status);
    }
}

if (! function_exists('failedResponse')) {
    function failedResponse($message = 'Failure', $status = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => null,
        ], $status);
    }
}
