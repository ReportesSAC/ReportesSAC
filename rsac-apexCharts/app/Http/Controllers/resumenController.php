<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\tb_resumen;
use App\Models\tb_actividades_transversale;
use App\Models\tb_automotriz;
use App\models\tb_coordinacion;
use App\Models\tb_LAGE;
use App\models\tb_manufactura;
use App\models\tb_mecatronica;
use App\models\tb_negocio;
use App\models\tb_posgrado;
use App\models\tb_rede;
use App\models\tb_sistema;

class resumenController extends Controller
{
    public function viewBienvenida() {
        $enProcesoAutomotriz = tb_automotriz::where('estatus', 'En proceso')->count();
        $enProcesoCoordinacion = tb_coordinacion::where('estatus', 'En proceso')->count();
        $enProcesoLAGE = tb_LAGE::where('estatus', 'En proceso')->count();
        $enProcesoManufactura = tb_manufactura::where('estatus', 'En proceso')->count();
        $enProcesoMecatronica = tb_mecatronica::where('estatus', 'En proceso')->count();
        $enProcesoNegocio = tb_negocio::where('estatus', 'En proceso')->count();
        $enProcesoPosgrado = tb_posgrado::where('estatus', 'En proceso')->count();
        $enProcesoRede = tb_rede::where('estatus', 'En proceso')->count();
        $enProcesoSistema = tb_sistema::where('estatus', 'En proceso')->count();

        $concluidoAutomotriz = tb_automotriz::where('estatus', 'Concluido')->count();
        $concluidoCoordinacion = tb_coordinacion::where('estatus', 'Concluido')->count();
        $concluidoLAGE = tb_LAGE::where('estatus', 'Concluido')->count();
        $concluidoManufactura = tb_manufactura::where('estatus', 'Concluido')->count();
        $concluidoMecatronica = tb_mecatronica::where('estatus', 'Concluido')->count();
        $concluidoNegocio = tb_negocio::where('estatus', 'Concluido')->count();
        $concluidoPosgrado = tb_posgrado::where('estatus', 'Concluido')->count();
        $concluidoRede = tb_rede::where('estatus', 'Concluido')->count();
        $concluidoSistema = tb_sistema::where('estatus', 'Concluido')->count();

        $canceladoAutomotriz = tb_automotriz::where('estatus', 'Cancelado')->count();
        $canceladoCoordinacion = tb_coordinacion::where('estatus', 'Cancelado')->count();
        $canceladoLAGE = tb_LAGE::where('estatus', 'Cancelado')->count();
        $canceladoManufactura = tb_manufactura::where('estatus', 'Cancelado')->count();
        $canceladoMecatronica = tb_mecatronica::where('estatus', 'Cancelado')->count();
        $canceladoNegocio = tb_negocio::where('estatus', 'Cancelado')->count();
        $canceladoPosgrado = tb_posgrado::where('estatus', 'Cancelado')->count();
        $canceladoRede = tb_rede::where('estatus', 'Cancelado')->count();
        $canceladoSistema = tb_sistema::where('estatus', 'Cancelado')->count();


        return Inertia::render('SideBarMenus/Bienvenido', [
            'enProcesoAutomotriz' => $enProcesoAutomotriz,
            'enProcesoCoordinacion' => $enProcesoCoordinacion,
            'enProcesoLAGE' => $enProcesoLAGE,
            'enProcesoManufactura' => $enProcesoManufactura,
            'enProcesoMecatronica' => $enProcesoMecatronica,
            'enProcesoNegocio' => $enProcesoNegocio,
            'enProcesoPosgrado' => $enProcesoPosgrado,
            'enProcesoRede' => $enProcesoRede,
            'enProcesoSistema' => $enProcesoSistema,

            'concluidoAutomotriz' => $concluidoAutomotriz,
            'concluidoCoordinacion' => $concluidoCoordinacion,
            'concluidoLAGE' => $concluidoLAGE,
            'concluidoManufactura' => $concluidoManufactura,
            'concluidoMecatronica' => $concluidoMecatronica,
            'concluidoNegocio' => $concluidoNegocio,
            'concluidoPosgrado' => $concluidoPosgrado,
            'concluidoRede' => $concluidoRede,
            'concluidoSistema' => $concluidoSistema,

            'canceladoAutomotriz' => $canceladoAutomotriz,
            'canceladoCoordinacion' => $canceladoCoordinacion,
            'canceladoLAGE' => $canceladoLAGE,
            'canceladoManufactura' => $canceladoManufactura,
            'canceladoMecatronica' => $canceladoMecatronica,
            'canceladoNegocio' => $canceladoNegocio,
            'canceladoPosgrado' => $canceladoPosgrado,
            'canceladoRede' => $canceladoRede,
            'canceladoSistema' => $canceladoSistema,


        ]);
    }

    public function resumenView() {
        $this->actualizarTbResumen();
        $resumen = tb_resumen::all();
        $transversales = tb_actividades_transversale::all();



        // Inicializar variables de totales
        $totalAcreditacion = 0;
        $totalCapacitacion = 0;
        $totalCertificacion = 0;
        $totalEvento = 0;
        $totalInvestigacion = 0;
        $totalMaterialEducativo = 0;
        $totalPlanEstudios = 0;
        $totalProyecto = 0;
        $totalOtro = 0;
        $totalTodos = 0;
        $totales=[];

        // Iterar sobre los registros de la tabla
        foreach ($resumen as $registro) {
            $totalAcreditacion += $registro->acreditacion;
            $totalCapacitacion += $registro->capacitacion;
            $totalCertificacion += $registro->certificacion_competencias;
            $totalEvento += $registro->evento;
            $totalInvestigacion += $registro->investigacion;
            $totalMaterialEducativo += $registro->material_educativo;
            $totalPlanEstudios += $registro->plan_estudios;
            $totalProyecto += $registro->proyecto;
            $totalOtro += $registro->otro;
            $totalTodos += $registro->total;
            $totales[] = [$registro->programa_educativo, $registro->acreditacion, $registro->capacitacion, $registro->certificacion_competencias, $registro->evento, $registro->investigacion, $registro->material_educativo, $registro->plan_estudios, $registro->proyecto, $registro->otro];
        }


        return Inertia::render('SideBarMenus/ResumenComponentes/TabMenu', [
            'registrosResumen' => $resumen,
            'registrosTransversales' => $transversales,

            'totalAcreditacion' => $totalAcreditacion,
            'totalCapacitacion' => $totalCapacitacion,
            'totalCertificacion' => $totalCertificacion,
            'totalEvento' => $totalEvento,
            'totalInvestigacion' => $totalInvestigacion,
            'totalMaterialEducativo' => $totalMaterialEducativo,
            'totalPlanEstudios' => $totalPlanEstudios,
            'totalProyecto' => $totalProyecto,
            'totalOtro' => $totalOtro,
            'totalTodos' => $totalTodos,
            'totales' => $totales,
        ]);
    }

    public function registrar(Request $request) {
        $programa_educativo = $request->input('programa_educativo');
        $acreditacion = $request->input('acreditacion');
        $certificacion_competencias = $request->input('certificacion_competencias');
        $evento = $request->input('evento');
        $investigacion = $request->input('investigacion');
        $material_educativo = $request->input('material_educativo');
        $plan_estudios = $request->input('plan_estudios');
        $proyecto = $request->input('proyecto');
        $otro = $request->input('otro');
        $total = $request->input('total');

        $resumen = new tb_resumen();
        $resumen->programa_educativo = $programa_educativo;
        $resumen->acreditacion = $acreditacion;
        $resumen->certificacion_competencias = $certificacion_competencias;
        $resumen->evento = $evento;
        $resumen->investigacion = $investigacion;
        $resumen->material_educativo = $material_educativo;
        $resumen->plan_estudios = $plan_estudios;
        $resumen->proyecto = $proyecto;
        $resumen->otro = $otro;
        $resumen->total = $total;
        $resumen->save();

        return redirect()->route('resumen');
    }

    public function eliminar(Request $request) {
        $id = $request->id;
        $admision = tb_resumen::whereIn('id', $id);
        $admision->delete();
        return redirect()->route('resumen');
    }

    public function editar(Request $request) {
        $id = $request->input('id');
        $programa_educativo = $request->input('programa_educativo');
        $acreditacion = $request->input('acreditacion');
        $capacitacion = $request->input('capacitacion');
        $certificacion_competencias = $request->input('certificacion_competencias');
        $evento = $request->input('evento');
        $investigacion = $request->input('investigacion');
        $material_educativo = $request->input('material_educativo');
        $plan_estudios = $request->input('plan_estudios');
        $proyecto = $request->input('proyecto');
        $otro = $request->input('otro');
        $total = $request->input('total');
        $actividades_transversales = $request->input('actividades_transversales');
        $persona_acargo = $request->input('persona_acargo');
        
        $resumen = tb_resumen::find($id);
        $resumen->programa_educativo = $programa_educativo;
        $resumen->acreditacion = $acreditacion;
        $resumen->capacitacion = $capacitacion;
        $resumen->certificacion_competencias = $certificacion_competencias;
        $resumen->evento = $evento;
        $resumen->investigacion = $investigacion;
        $resumen->material_educativo = $material_educativo;
        $resumen->plan_estudios = $plan_estudios;
        $resumen->proyecto = $proyecto;
        $resumen->otro = $otro;
        $resumen->total = $total;
        $resumen->actividades_transversales = $actividades_transversales;
        $resumen->persona_acargo = $persona_acargo;
        $resumen->save();

        return redirect()->route('resumen');

    }

    public function actualizarTbResumen() {
        $tablas = [
            'App\Models\tb_automotriz',
            'App\Models\tb_coordinacion',
            'App\Models\tb_LAGE',
            'App\Models\tb_manufactura',
            'App\Models\tb_mecatronica',
            'App\Models\tb_negocio',
            'App\Models\tb_posgrado',
            'App\Models\tb_rede',
            'App\Models\tb_sistema',
        ];

        for ($i = 0; $i < count($tablas); $i++) {
            $tabla = $tablas[$i];
            $registros = $tabla::all();

            $acreditacion = 0;
            $programa_educativo = "";
            $acreditacion = 0;
            $capacitacion = 0;
            $certificacion_competencias = 0;
            $evento = 0;
            $investigacion = 0;
            $material_educativo = 0;
            $plan_estudios = 0;
            $proyecto = 0;
            $otro = 0;
            $total = 0;

            for($j=0; $j < count($registros); $j++) {
                if($j==0){
                    $programa_educativo = $registros[$j]->programa_educativo;
                }
                if($registros[$j]->categoria == 'Acreditación') {
                    $acreditacion ++;
                } else if ($registros[$j]->categoria == 'Capacitación'){
                    $capacitacion ++;
                } else if ($registros[$j]->categoria == 'Certificación-Competencias'){
                    $certificacion_competencias ++;
                } else if ($registros[$j]->categoria == 'Evento'){
                    $evento ++;
                } else if ($registros[$j]->categoria == 'Investigación'){
                    $investigacion ++;
                } else if ($registros[$j]->categoria == 'Material educativo'){
                    $material_educativo ++;
                } else if ($registros[$j]->categoria == 'Plan de estudio'){
                    $plan_estudios ++;
                } else if ($registros[$j]->categoria == 'Proyecto'){
                    $proyecto ++;
                } else if ($registros[$j]->categoria == 'Otro'){
                    $otro ++;
                }
                $total ++;
            }

            $resumen = tb_resumen::where('programa_educativo', $programa_educativo)->first();

            $resumen->update([
                'acreditacion' => $acreditacion,
                'capacitacion' => $capacitacion,
                'certificacion_competencias' => $certificacion_competencias,
                'evento' => $evento,
                'investigacion' => $investigacion,
                'material_educativo' => $material_educativo,
                'plan_estudios' => $plan_estudios,
                'proyecto' => $proyecto,
                'otro' => $otro,
                'total' => $total
            ]);
        }

        return redirect()->route('resumen');
    }

    public function asignarActTransversal(Request $request) {
        $nombre_evento = $request->input('nombre_evento');
        $id = $request->input('id');
        
        // Obtener el valor anterior de la columna actividades_transversales de la tabla tb_resumen
        $resumen = tb_resumen::findOrFail($id);
        $actividades_transversales_anterior = $resumen->actividades_transversales;
    
        // Concatenar el valor anterior con el nuevo valor, separados por una coma y un espacio
        $actividades_transversales_nuevo = $actividades_transversales_anterior ? $actividades_transversales_anterior . ', ' . $nombre_evento : $nombre_evento;
    
        // Actualizar la fila en la tabla tb_resumen con el nuevo valor de actividades_transversales
        $resumen->update(['actividades_transversales' => $actividades_transversales_nuevo]);
    
        return redirect()->route('resumen');
    }

    public function registrarActTransversal(Request $request) {
        $nombre_evento = $request->input('nombre_evento');
        $transversal = new tb_actividades_transversale();
        $transversal->nombre_evento = $nombre_evento;
        $transversal->save();

        return redirect()->route('resumen');
    }

    public function editarActividadTransversal(Request $request) {
        $id = $request->input('id');
        $nombre_evento = $request->input('nombre_evento');

        $transversal = tb_actividades_transversale::find($id);
        $transversal->nombre_evento = $nombre_evento;
        $transversal->save();

        return redirect()->route('resumen');
    }

    public function eliminarActividadTransversal(Request $request) {
        $id = $request->id;
        $transversal = tb_actividades_transversale::whereIn('id', $id);
        $transversal->delete();
        return redirect()->route('resumen');
    }
    
  
    
}
