<?php
class ResponseHelper {
    public static function json($data, $code = 200) {
        http_response_code($code);
        echo json_encode($data);
        exit;
    }

    public static function error($message, $code = 400) {
        self::json(['error' => $message], $code);
    }
}