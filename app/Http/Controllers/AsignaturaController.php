<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignaturaController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function get(Request $request)
    {
        $usuarioID = $request['usuario'];
        $sedeID = $request['sede'];

        $types = 'asignatura_grupo';
        $typesAsig = 'asignatura';
        $typesGrupo = 'grupo';
        $typesUserGrupo = 'estudiante_asignatura_grupo';
        $typesUser = 'users';
        $typesMod = 'modalidad';

        $data = DB::table($types)
            ->where('users_id', $usuarioID)
            ->where('sede_id', $sedeID)
            ->join($typesAsig, "$types.asignatura_id", '=', "$typesAsig.id")
            ->join($typesGrupo, "$types.grupo_id", '=', "$typesGrupo.id")
            ->select(
                "$types.id",
                "$types.headers",
                "$types.subheaders",
                "$typesAsig.nombre",
                "$typesAsig.intensidad",
                "$typesAsig.modalidad_id",
                "$typesGrupo.consecutivo",
                "$typesGrupo.jornada",
                "$typesGrupo.anio",
                "$typesGrupo.salon",
            )
            ->get();

        foreach ($data as $item) {
            $item->notas = DB::table($typesUserGrupo)
                ->where('id_asignatura_grupo', $item->id)
                ->join($typesUser, "id_users", "=", "$typesUser.id")
                ->select(
                    "$typesUserGrupo.id",
                    "notas",
                    "$typesUser.name as estudiante",
                    "$typesUser.code as codigo",
                )
                ->get();

            $item->modalidad = DB::table($typesMod)
                ->where('id', $item->modalidad_id)
                ->first();

            foreach ($item->notas as $notes) {
                $notes->notas = json_decode($notes->notas);
            }
        }

        return $data;
    }

    public function storeNote(Request $request)
    {
        $typesUserGrupo = 'estudiante_asignatura_grupo';


        DB::table($typesUserGrupo)
            ->where("id", $request["id"])
            ->update([
                'notas' => json_encode($request['notas'])
            ]);


        return $request;
    }
}