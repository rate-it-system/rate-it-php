<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;

class DegustationModel
{
    private $id;
    private ?array $admins = [];
    private ?array $viewers = [];
    private string $name;
    private bool $edited = false;

    /**
     * @param array|null $admins
     */
    public function adduser(User $user, bool $isAdmin = false): void
    {
        if ($isAdmin) {
            $this->admins[] = $user;
        } else {
            $this->viewers[] = $user;
        }
        $this->edited = true;
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed|string $name
     */
    public function setName(string $name): void
    {
        $this->edited = true;
        $this->name = $name;
    }

    /**
     * @return mixed|string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __construct($id = null)
    {
        $this->id = $id;
        if ($id !== null) {
            $this->name = DB::table('degustation')
                ->select('name')
                ->where('degustation_id', $id)
                ->first()->name;
        }
    }

    public function save(): void
    {
        if ($this->edited) {
            if ($this->id === null) {
                $this->id = DB::table('degustation')->insertGetId(['name' => $this->name]);
            } else {
                DB::table('degustation')->where('degustation_id', $this->id)->update(['name' => $this->name]);
            }
            $this->edited = false;
        }
    }
}
