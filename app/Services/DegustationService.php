<?php


namespace App\Services;


use App\Models\DegustationModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DegustationService
{
    public function create(string $name, $arrayUserList)
    {

    }

    public static function getMyDegustations(){
        $output = [];
        $degustationsIds = DB::table('degustation')
            ->join('degustation_to_users', 'degustation.degustation_id', '=', 'degustation_to_users.degustation_id')
            ->select('degustation.degustation_id')
            ->where('user_id', Auth::getCurrentUser()->getDatabaseID())
            ->get();
        foreach ($degustationsIds as $degustationId){
            $output[] = new DegustationModel($degustationId->degustation_id);
        }
        return $output;
    }
}
