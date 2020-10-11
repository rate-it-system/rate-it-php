<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class Auth
{
    public static function securePage(): void
    {
        if (@$_SESSION['logged'] === true) {
            return;
        }
        try {
            \App::abort(302, '', ['Location' => '/login']);
        } catch (\Exception $exception) {
            //TODO: dodać stronę błędu 500
            echo 'error';
            $previousErrorHandler = set_exception_handler(function () {
            });
            restore_error_handler();
            call_user_func($previousErrorHandler, $exception);
            die;
        }
        exit;
    }

    public static function loginByPassword($login, $password): bool
    {
        $userBD = DB::table('users')
            ->select('id')
            ->where('email', $login)
            ->whereRaw('password = PASSWORD(?)', [$password])
            -> first();
        if ($userBD === null) {
            return false;
        } else {
            $_SESSION['logged'] = true;
            $_SESSION['userid'] = $userBD->id;
            return true;
        }
    }
}
