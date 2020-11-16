<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;

class DegustationModel
{
    private array $admins;
    private array $viewers;
    private string $name;

    /**
     * @return mixed|string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __construct($id = null)
    {
        if ($id !== null) {
            $this->name = DB::table('degustation')
                ->select('name')
                ->where('degustation_id', $id)
                ->first()->name;
        }
    }
}
