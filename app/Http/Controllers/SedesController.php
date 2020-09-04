<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class SedesController extends Controller
{
    /**
     * @param $id
     */
    public function get($id)
    {
        $types = 'sede_user';
        $typesSede = 'sedes';

        $data = DB::table($types)
            ->where('users_id', $id)
            ->join($typesSede, "$types.sedes_id", '=', "$typesSede.id")
            ->select(
                "$typesSede.id",
                "$typesSede.nombre",
                "$typesSede.direccion",
                "$typesSede.telefono"
            )
            ->get();

        return $data;
    }
}