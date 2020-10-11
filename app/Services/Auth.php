<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class Auth
{
    /**
     * @param string $page
     * When you execute this method then dependency if user is login or do nothing or redirect to page from parameters;
     * Default redirect page is `/login`
     */
    public static function securePage($page = '/login'): void
    {
        if (self::isLogin()) {
            return;
        }
        try {
            \App::abort(302, '', ['Location' => $page]);
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

    /**
     * @param $login
     * @param $password
     * @return bool
     * If user is login then it switch user account
     * if user isn't login then function login new user
     * result login user by credentail is returned if login pass then return true
     * if user don't exist or wrong password then method return false
     */
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

    /**
     * method logout current user
     * method is safety for not logged user
     */
    public static function logout():void
    {
        $_SESSION['logged'] = false;
    }


    /**
     * @return bool
     * method return current login status
     */
    public static function isLogin():bool{
        if (@$_SESSION['logged'] === true) {
            return true;
        } else {
            return false;
        }
    }
}
