<?php
namespace App\Helpers;

use App\User;

class apiHelper
{

    public static function success($message, $data)
    {
        $data = array('status' => 200, 'response' => array('message' => $message, 'detail' => $data), 'error' => array('status' => 0));
        return $data;
    }

    public static function successMessage($message)
    {
        $data = array('status' => 200, 'response' => array('message' => $message), 'error' => array('status' => 0));
        return $data;
    }

    public static function error($message)
    {
        $data = array('status' => 404 , 'response' => array(), 'error' => array('message' => $message));
        return $data;
    }

    public static function validation_error($message, $data)
    {
        $data = array('status' => 403 , 'response' => array(), 'error' => array('message' => $message, 'detail' => $data));
        return $data;
    }

    public static function authenticate($user_id, $auth_id)
    {
        if (empty($user_id) or empty($auth_id)) {
            return false;
        } else {
            if (User::where('user_id', $user_id)->where('auth_id', $auth_id)->exists())
                return true;
            else
                return false;
        }
    }

    public static function apiHeaders()
    {
        $headers = [
            'apiKey' => config('main.api_auth_key'),
        ];

        return $headers;
    }

}
