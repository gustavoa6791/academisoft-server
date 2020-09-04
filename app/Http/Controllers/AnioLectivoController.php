<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;


class AnioLectivoController extends Controller
{
    /**
     * @param $id
     */
    public function get($id)
    {
        $types = 'anio_lectivo';
        $typesMod = 'modalidad';

        $data = DB::table($types)
            ->where('sede_id', $id)
            ->where('estado', 1)
            ->get();

        foreach ($data as $item) {
            $item->modalidades = DB::table($typesMod)
                ->where('anio_lectivo_id', $item->id)
                ->get();
        }




        return $data;
    }
}