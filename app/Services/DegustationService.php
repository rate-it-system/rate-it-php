<?php


namespace App\Services;


use App\Models\DegustationModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DegustationService
{
    private static ?DegustationModel $currentDegustation = null;

    public static function getMyDegustations()
    {
        $output = [];
        $degustationsIds = DB::table('degustation')
            ->join('degustation_to_users', 'degustation.degustation_id', '=', 'degustation_to_users.degustation_id')
            ->select('degustation.degustation_id')
            ->where('user_id', Auth::getCurrentUser()->getDatabaseID())
            ->get();
        foreach ($degustationsIds as $degustationId) {
            $output[] = new DegustationModel($degustationId->degustation_id);
        }
        return $output;
    }

    public static function setCurrentDegustation(DegustationModel $degustation)
    {
        self::$currentDegustation = $degustation;
        $_SESSION['currentDegustation'] = $degustation->getId();
    }

    public static function getCurrentDegustation(): DegustationModel
    {
        if (self::$currentDegustation === null) {
            self::$currentDegustation = new DegustationModel($_SESSION['currentDegustation']);
        }
        return self::$currentDegustation;
    }
}
