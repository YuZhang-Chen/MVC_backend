<?php

namespace Vendor;

abstract class Controller {
    protected static function response($status, $message, $result=null) {
        return ['status' => $status, 'message' => $message, 'result' => $result];
    }
}