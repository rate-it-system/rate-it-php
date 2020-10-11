<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class User
{
    public static int $FIND_USER_BY_MAIL = 1;
    public static int $FIND_USER_BY_ID = 2;

    private string $databaseID;
    private string $name;
    private string $email;
    private Boolean $emailVerified;
    private ?string $tokenToVeriEmail;
    private ?string $tokenToResetPassword;

    /**
     * User constructor.
     * @param $value
     * @param int $findUserBy
     * Object can find user by id or email
     * depends of second parameter
     * current available are User::$FIND_USER_BY_MAIL or User::$FIND_USER_BY_ID
     */
    public function __construct($value, int $findUserBy = 1)
    {
        $databaseUser = DB::table('user')
            ->select(['id', 'name', 'email', 'email_verified_at', 'remember_token'])
            ->where((($findUserBy === User::$FIND_USER_BY_MAIL) ? "email" : "id"), $value)
            ->first();
        if ($databaseUser == null) {
            throw new Exception('Cannot load user ' . $value . ' by ' . (($findUserBy === User::$FIND_USER_BY_MAIL) ? "email" : "id"));
        }
        $this->databaseID = $databaseUser->id;
        $this->name = $databaseUser->name;
        $this->email = $databaseUser->email;
        if ($databaseUser->email_verified_at) {
            $this->emailVerified = true;
            $this->tokenToVeriEmail = null;
        } else {
            $this->emailVerified = false;
            $this->tokenToVeriEmail = $databaseUser->remember_token;
        }
        $this->databaseID = $databaseUser->id;
    }
}
