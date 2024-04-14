<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\tb_mecatronica; 

class mecatronicaController extends Controller
{
    public function mecatronicaView() {
        $mecatronica = tb_mecatronica::all();
        $enProcesoCount = tb_mecatronica::where('estatus', 'En proceso')->count();
        $concluidoCount = tb_mecatronica::where('estatus', 'Concluido')->count();
        $canceladoCount = tb_mecatronica::where('estatus', 'Cancelado')->count();

        $acreditacionCount = tb_mecatronica::where('categoria', 'Acreditación')->count();
        $capacitacionCount = tb_mecatronica::where('categoria', 'Capacitación')->count();
        $CertificaciónCompetenciasCount = tb_mecatronica::where('categoria', 'Certificación-Competencias')->count();
        $eventoCount = tb_mecatronica::where('categoria', 'Evento')->count();
        $investigacionCount = tb_mecatronica::where('categoria', 'Investigación')->count();
        $materialEducativoCount = tb_mecatronica::where('categoria', 'Material educativo')->count();
        $planDeEstudioCount = tb_mecatronica::where('categoria', 'Plan de estudio')->count();
        $proyectoCount = tb_mecatronica::where('categoria', 'Proyecto')->count();
        $otroCount = tb_mecatronica::where('categoria', 'Otro')->count();

        $categorias = ['Acreditación', 'Capacitación', 'Certificación-Competencias', 'Evento', 'Investigación', 'Material educativo', 'Plan de estudio', 'Proyecto', 'Otro'];
        $estatus = ['En proceso', 'Concluido', 'Cancelado'];
        $countEstatus = [];
        
        $categorias = ['Acreditación', 'Capacitación', 'Certificación-Competencias', 'Evento', 'Investigación', 'Material educativo', 'Plan de estudio', 'Proyecto', 'Otro'];
        $estatus = ['En proceso', 'Concluido', 'Cancelado'];
        $countEstatus = [];
        
        for ($i=0; $i<count($categorias); $i++) {
            for($j=0; $j<count($estatus); $j++) {
                $count = tb_mecatronica::where('categoria', $categorias[$i])->where('estatus', $estatus[$j])->count();
                $countEstatus[]= $count;
            }   
        }

        return Inertia::render('SideBarMenus/MecatronicaComponentes/Mecatronica', [
            'registrosMecatronica' => $mecatronica,
            'enProcesoCount' => $enProcesoCount,
            'concluidoCount' => $concluidoCount,
            'canceladoCount' => $canceladoCount,

             'acreditacionCount' => $acreditacionCount,
            'capacitacionCount' => $capacitacionCount,
            'CertificaciónCompetenciasCount' => $CertificaciónCompetenciasCount,
            'eventoCount' => $eventoCount,
            'investigacionCount' => $investigacionCount,
            'materialEducativoCount' => $materialEducativoCount,
            'planDeEstudioCount' => $planDeEstudioCount,
            'proyectoCount' => $proyectoCount,
            'otroCount' => $otroCount,
            'countEstatus' => $countEstatus,
        ]);
    }

    public function registrar(Request $request) {
        $programa_educativo = $request->input('programaEducativo');
        $proyecto_actividad = $request->input('proyecto_actividad');
        $descripcion = $request->input('descripcion');
        $beneficios_impacto = $request->input('beneficios_impacto');
        $responsable = $request->input('responsable');
        $involucrados = $request->input('involucrados');
        $PDI = $request->input('pdi');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $cantidad = $request->input('cantidad');
        $unidad = $request->input('unidad1');
        $hombres1 = $request->input('hombres1');
        $mujeres1 = $request->input('mujeres1');
        $unidad2 = $request->input('unidad2');
        $hombres2 = $request->input('hombres2');
        $mujeres2 = $request->input('mujeres2');
        $estatus = $request->input('estatusModel');
        $categoria = $request->input('categoria');
        $especificar = $request->input('especificar');

         // crear un nuevo registro en la tabla tb_admision
        $automotriz = new tb_mecatronica;
        $automotriz->programa_educativo = $programa_educativo;
        $automotriz->proyecto_actividad = $proyecto_actividad;
        $automotriz->descripcion = $descripcion;
        $automotriz->beneficios_impacto = $beneficios_impacto;
        $automotriz->responsable = $responsable;
        $automotriz->involucrados = $involucrados;
        $automotriz->PDI = $PDI;        
        $automotriz->fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $automotriz->fecha_fin = date('Y-m-d', strtotime($fecha_fin));
        $automotriz->cantidad = $cantidad;
        $automotriz->unidad = $unidad;
        $automotriz->hombres1 = $hombres1;
        $automotriz->mujeres1 = $mujeres1;
        $automotriz->unidad2 = $unidad2;
        $automotriz->hombres2 = $hombres2;
        $automotriz->mujeres2 = $mujeres2;
        $automotriz->estatus = $estatus;
        $automotriz->categoria = $categoria;
        $automotriz->especificar = $especificar;
        $automotriz->save();

        return redirect()->route('view.mecatronica');

    }


    public function eliminar(Request $request) {
        $id = $request->id;
        $admision = tb_mecatronica::whereIn('id', $id);
        $admision->delete();
        return redirect()->route('view.mecatronica');
    }

    public function editar(Request $request) {
        $id = $request->input('id');
        $programa_educativo = $request->input('programaEducativo');
        $proyecto_actividad = $request->input('proyecto_actividad');
        $descripcion = $request->input('descripcion');
        $beneficios_impacto = $request->input('beneficios_impacto');
        $responsable = $request->input('responsable');
        $involucrados = $request->input('involucrados');
        $PDI = $request->input('pdi');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $cantidad = $request->input('cantidad');
        $unidad = $request->input('unidad1');
        $hombres1 = $request->input('hombres1');
        $mujeres1 = $request->input('mujeres1');
        $unidad2 = $request->input('unidad2');
        $hombres2 = $request->input('hombres2');
        $mujeres2 = $request->input('mujeres2');
        $estatus = $request->input('estatusModel');
        $categoria = $request->input('categoria');
        $especificar = $request->input('especificar');


        $automotriz = tb_mecatronica::find($id);
        $automotriz->programa_educativo = $programa_educativo;
        $automotriz->proyecto_actividad = $proyecto_actividad;
        $automotriz->descripcion = $descripcion;
        $automotriz->beneficios_impacto = $beneficios_impacto;
        $automotriz->responsable = $responsable;
        $automotriz->involucrados = $involucrados;
        $automotriz->PDI = $PDI;        
        $automotriz->fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $automotriz->fecha_fin = date('Y-m-d', strtotime($fecha_fin));
        $automotriz->cantidad = $cantidad;
        $automotriz->unidad = $unidad;
        $automotriz->hombres1 = $hombres1;
        $automotriz->mujeres1 = $mujeres1;
        $automotriz->unidad2 = $unidad2;
        $automotriz->hombres2 = $hombres2;
        $automotriz->mujeres2 = $mujeres2;
        $automotriz->estatus = $estatus;
        $automotriz->categoria = $categoria;
        $automotriz->especificar = $especificar;
        $automotriz->save();

        return redirect()->route('view.mecatronica');
    }
}
