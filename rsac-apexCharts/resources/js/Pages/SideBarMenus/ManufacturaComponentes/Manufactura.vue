<script setup>
import { ref, onMounted } from "vue";
import { watchEffect } from 'vue';
import { watch } from "vue";
import html2pdf from "html2pdf.js";
import AppLayout from "@/Layouts/AppLayout.vue";
import { FilterMatchMode } from "primevue/api";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import Toolbar from "primevue/toolbar";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Dropdown from "primevue/dropdown";
import Textarea from "primevue/textarea";
import Calendar from "primevue/calendar";
import { useToast } from "primevue/usetoast";
import Toast from "primevue/toast";
import { Inertia } from "@inertiajs/inertia";
import Chart from "primevue/chart";
import graficaHM from "../graficaHM.vue";
const props = defineProps({
    registrosManufactura: {
        type: Array,
        required: true,
    },
    enProcesoCount: {
        type: Number,
    },
    concluidoCount: {
        type: Number,
    },
    canceladoCount: {
        type: Number,
    },

    acreditacionCount: {
        type: Number,
    },
    capacitacionCount: {
        type: Number,
    },
    CertificaciónCompetenciasCount: {
        type: Number,
    },
    eventoCount: {
        type: Number,
    },
    investigacionCount: {
        type: Number,
    },
    materialEducativoCount: {
        type: Number,
    },
    planDeEstudioCount: {
        type: Number,
    },
    proyectoCount: {
        type: Number,
    },
    otroCount: {
        type: Number,
    },
    countEstatus: {
        type: Array,
    },
});
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    programa_educativo: { value: null, matchMode: FilterMatchMode.CONTAINS },
    proyecto_actividad: { value: null, matchMode: FilterMatchMode.CONTAINS },
    descripcion: { value: null, matchMode: FilterMatchMode.CONTAINS },
    beneficios_impacto: { value: null, matchMode: FilterMatchMode.CONTAINS },
    responsable: { value: null, matchMode: FilterMatchMode.CONTAINS },
    involucrados: { value: null, matchMode: FilterMatchMode.CONTAINS },
    PDI: { value: null, matchMode: FilterMatchMode.CONTAINS },
    especificar: { value: null, matchMode: FilterMatchMode.CONTAINS },
    categoria: { value: null, matchMode: FilterMatchMode.CONTAINS },
    estatus: { value: null, matchMode: FilterMatchMode.CONTAINS },
    fecha_inicio: { value: null, matchMode: FilterMatchMode.CONTAINS },
    fecha_fin: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const selectedProduct = ref();
const editingRows = ref([]);
const dt = ref();
const productDialog = ref(false);
const deleteProductsDialog = ref(false);

const toast = useToast();
const noDataMessage = "No se encontraron datos";

// variables reactivas para un nuevo REGISTRO
const programaEducativo = ref(null);
const proyecto_actividad = ref(null);
const descripcion = ref(null);
const beneficios_impacto = ref(null);
const responsable = ref();
const involucrados = ref();
const displayResponsive = ref(false);
const pdi = ref(null);
const fecha_inicio = ref();
const fecha_fin = ref();
const unidad1 = ref();
const mujeres1 = ref(0);
const hombres1 = ref(0);
const unidad2 = ref();
const mujeres2 = ref(0);
const hombres2 = ref(0);
const cantidad = ref(0);
const estatusModel = ref();
const categoria = ref();
const especificar = ref();

const programas_educativos_lista = ref([
    {
        nombre: "Ing. en Tecnologías de Manufactura",
        value: "Ing. en Tecnologías de Manufactura",
    },
]);

const unidad_lista = ref([
    { nombre: "Asignatura", value: "Asignatura" },
    { nombre: "Convenio", value: "Convenio" },
    { nombre: "Docentes", value: "Docentes" },
    { nombre: "Empresas", value: "Empresas" },
    { nombre: "Estudiantes", value: "Estudiantes" },
    { nombre: "Programa", value: "Programa" },
    { nombre: "Proyecto", value: "Proyecto" },
    { nombre: "Publicaciones", value: "Publicaciones" },
    { nombre: "Reglamento", value: "Reglamento" },
    { nombre: "Otro", value: "Otro" },
    { nombre: "No aplica", value: "No aplica" },
]);

const estatus = ref([
    { nombre: "En proceso", value: "En proceso" },
    { nombre: "Concluido", value: "Concluido" },
    { nombre: "Cancelado", value: "Cancelado" },
]);

const categorias_lista = ref([
    { nombre: "Acreditación", value: "Acreditación" },
    { nombre: "Capacitación", value: "Capacitación" },
    {
        nombre: "Certificación-Competencias",
        value: "Certificación-Competencias",
    },
    { nombre: "Evento", value: "Evento" },
    { nombre: "Investigación", value: "Investigación" },
    { nombre: "Material educativo", value: "Material educativo" },
    { nombre: "Plan de estudio", value: "Plan de estudio" },
    { nombre: "Proyecto", value: "Proyecto" },
    { nombre: "Otro", value: "Otro" },
]);

const onRowSelect = (event) => {
    const selectedRowData = event.data;
    console.log(selectedRowData);
};
const onRowUnselect = (event) => {
    // alert('Producto deseleccionado')
};

const openResponsive = () => {
    displayResponsive.value = true;
};

const closeResponsive = () => {
    displayResponsive.value = false;
};

const openDialogNuevo = () => {
    productDialog.value = true;
};

const ocultarNuevoRegistro = () => {
    // cerrar el dialog
    productDialog.value = false;
};

function calcularCantidad() {
    cantidad.value =
        hombres1.value + mujeres1.value + hombres2.value + mujeres2.value;
}

watch([hombres1, mujeres1, hombres2, mujeres2], () => {
    calcularCantidad();
});

const openEliminarDialog = () => {
    deleteProductsDialog.value = true;
};
const eliminarProductos = () => {
    const data = {
        id: selectedProduct.value.map((item) => item.id),
    };
    Inertia.post("/eliminar-manufactura", data, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            deleteProductsDialog.value = false;
            selectedProduct.value = null;
            chartData.value = setChartData();
            toast.add({
                severity: "success",
                summary: "Exito",
                detail: "Eliminado exitosamente",
                life: 3000,
            });
        },
    });
};

const registrarNuevo = () => {
    // Validar que los campos no estén vacíos o nulos
    if (
        programaEducativo.value == null ||
        programaEducativo.value < 0 ||
        proyecto_actividad.value == null ||
        proyecto_actividad.value < 0 ||
        descripcion.value == null ||
        descripcion.value < 0 ||
        beneficios_impacto.value == null ||
        beneficios_impacto.value < 0 ||
        pdi.value == null ||
        pdi.value < 0 ||
        fecha_inicio.value == null ||
        fecha_inicio.value < 0 ||
        fecha_fin.value == null ||
        fecha_fin.value < 0 ||
        cantidad.value == null ||
        cantidad.value < 0 ||
        unidad1.value == null ||
        unidad1.value < 0 ||
        mujeres1.value == null ||
        mujeres1.value < 0 ||
        hombres1.value == null ||
        hombres1.value < 0 ||
        unidad2.value == null ||
        unidad2.value < 0 ||
        mujeres2.value == null ||
        mujeres2.value < 0 ||
        hombres2.value == null ||
        hombres2.value < 0 ||
        estatusModel.value == null ||
        estatusModel.value < 0 ||
        categoria.value == null ||
        categoria.value < 0
    ) {
        toast.add({
            severity: "error",
            summary: "Campos faltantes",
            detail: "Por favor, llena todos los campos del formulario",
            life: 3000,
        });
        return;
    } else {
        // Obtener los valores del formulario
        const data = {
            programaEducativo: programaEducativo.value,
            proyecto_actividad: proyecto_actividad.value,
            descripcion: descripcion.value,
            beneficios_impacto: beneficios_impacto.value,
            responsable: responsable.value,
            involucrados: involucrados.value,
            pdi: pdi.value,
            fecha_inicio: fecha_inicio.value,
            fecha_fin: fecha_fin.value,
            cantidad: cantidad.value,
            unidad1: unidad1.value,
            mujeres1: mujeres1.value,
            hombres1: hombres1.value,
            unidad2: unidad2.value,
            mujeres2: mujeres2.value,
            hombres2: hombres2.value,
            estatusModel: estatusModel.value,
            categoria: categoria.value,
            especificar: especificar.value,
        };
        // Enviar los datos al servidor
        Inertia.post("/registro-manufactura", data, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                productDialog.value = false;
                // resetear el valor de los inputs
                programaEducativo.value = null;
                proyecto_actividad.value = null;
                descripcion.value = null;
                beneficios_impacto.value = null;
                pdi.value = null;
                fecha_inicio.value = null;
                fecha_fin.value = null;
                unidad1.value = null;
                mujeres1.value = 0;
                hombres1.value = 0;
                unidad2.value = null;
                mujeres2.value = 0;
                hombres2.value = 0;
                cantidad.value = 0;
                estatusModel.value = null;
                categoria.value = null;
                especificar.value = null;
                chartData.value = setChartData();
                toast.add({
                    severity: "success",
                    summary: "Exito",
                    detail: "Registro exitoso",
                    life: 3000,
                });
            },
        });
    }
};
const formatearFechaFin = () => {
    const fecha_fin_sin_formatear = fecha_fin.value;

    const options = { year: "numeric", month: "2-digit", day: "2-digit" };
    const fecha_fin_formateada = fecha_fin_sin_formatear.toLocaleDateString(
        "es-MX",
        options
    );

    fecha_fin.value = fecha_fin_formateada;
};
const formatearFechaInicio = () => {
    const fecha_inicio_sin_formatear = fecha_inicio.value;

    const options = { year: "numeric", month: "2-digit", day: "2-digit" };
    const fecha_inicio_formateada =
        fecha_inicio_sin_formatear.toLocaleDateString("es-MX", options);

    fecha_inicio.value = fecha_inicio_formateada;
};

const onRowEditSave = (event) => {
    let { newData } = event;

    const data = {
        id: newData.id,
        programaEducativo: newData.programa_educativo,
        proyecto_actividad: newData.proyecto_actividad,
        descripcion: newData.descripcion,
        beneficios_impacto: newData.beneficios_impacto,
        pdi: newData.PDI,
        fecha_inicio: newData.fecha_inicio,
        fecha_fin: newData.fecha_fin,
        cantidad: newData.cantidad,
        cantidad: newData.cantidad,
        unidad1: newData.unidad,
        hombres1: newData.hombres1,
        mujeres1: newData.mujeres1,
        unidad2: newData.unidad2,
        hombres2: newData.hombres2,
        mujeres2: newData.mujeres2,
        estatusModel: newData.estatus,
        categoria: newData.categoria,
        especificar: newData.especificar,
    };
    Inertia.post(`/editar-manufactura/${newData.id}`, data, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            chartData.value = setChartData();
            toast.add({
                severity: "success",
                summary: "Exito",
                detail: "Editado correctamente",
                life: 3000,
            });
        },
    });
};

const exportCSV = () => {
    dt.value.exportCSV();
};
const chartData = ref();
const chartOptions = ref();

const setChartData = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const hombresTotal = props.registrosManufactura.reduce(
        (total, item) => total + item.hombres1 + item.hombres2,
        0
    );
    const mujeresTotal = props.registrosManufactura.reduce(
        (total, item) => total + item.mujeres1 + item.mujeres2,
        0
    );

    return {
        labels: ["Cantidad"],
        datasets: [
            {
                label: "Hombres",
                backgroundColor: documentStyle.getPropertyValue("--blue-500"),
                borderColor: documentStyle.getPropertyValue("--blue-500"),
                data: [hombresTotal],
            },
            {
                label: "Mujeres",
                backgroundColor: documentStyle.getPropertyValue("--pink-500"),
                borderColor: documentStyle.getPropertyValue("--pink-500"),
                data: [mujeresTotal],
            },
        ],
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue("--text-color");
    const textColorSecondary = documentStyle.getPropertyValue(
        "--text-color-secondary"
    );
    const surfaceBorder = documentStyle.getPropertyValue("--surface-border");

    return {
        indexAxis: "y",
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        plugins: {
            legend: {
                labels: {
                    fontColor: textColor,
                },
            },
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary,
                    font: {
                        weight: 500,
                    },
                },
                grid: {
                    display: false,
                    drawBorder: false,
                },
            },
            y: {
                ticks: {
                    color: textColorSecondary,
                },
                grid: {
                    color: surfaceBorder,
                    drawBorder: false,
                },
            },
        },
    };
};
onMounted(() => {
    chartData.value = setChartData();
    chartOptions.value = setChartOptions();
});

const exportPDF = () => {
    const divContainer = document.createElement("div");

    divContainer.innerHTML = `
            <div id="heading" class="flex justify-between"> 
                 <div id="img1">
                     <img  src="images/UPQLOGOREDONDO.png" alt="Logo-UTVT-1"  width="100px !import">
                </div>
                <div id="img2">
                    <img  src="images/RSAC-logos_transparent.png" alt="Logo-UTVT-1"  width="100px">
                </div>
            </div>
                <div>
                    <div>
                        <h3 class="text-xl font-bold text-indigo-600 sm:text-3xl m-5">
                            RSAC - Reporte de Proyectos y Actividades
                        </h3>
                     </div>
                     <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                        <thead class="ltr:text-left rtl:text-right">
                            <tr class='text-left'>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Programa Educativo</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Proyecto/Actividad</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Responsable</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Estatus</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Categoria</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">PDI</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Fecha Inicio</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Fecha Fin</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Unidades</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Hombres</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Mujeres</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            ${selectedProduct.value
                                .map((item) => {
                                    return `
                                    <tr class="odd:bg-gray-50">
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">${
                                            item.programa_educativo
                                        }</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">${
                                            item.proyecto_actividad
                                        }</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">${
                                            item.responsable
                                        }</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">${
                                            item.estatus
                                        }</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">${
                                            item.categoria
                                        }</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">${
                                            item.PDI
                                        }</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">${
                                            item.fecha_inicio
                                        }</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">${
                                            item.fecha_fin
                                        }</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">${
                                            item.unidad + " - " + item.unidad2
                                        }</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">${
                                            item.hombres1 + item.hombres2
                                        }</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">${
                                            item.mujeres1 + item.mujeres2
                                        }</td>
                                    </tr>
                                `;
                                })
                                .join("")}
                        </tbody>
                    </table>
                </div
            </div>
            
        `;
    const opt = {
        margin: 0,
        filename: "reporte.pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: {
            unit: "in",
            format: "letter",
            orientation: "landscape",
            format: [14, 20], //hacer grande el pdf, pa que quepa todas las columnas
        },
    };

    html2pdf().from(divContainer).set(opt).save();
};
const titlePie = ref('Título inicial');

const seriesProgramas = () => {
  let data;
  const datos = props.countEstatus;
  if(titlePie.value === 'Acreditación') {
    data = [datos[0], datos[1], datos[2]];
  } else if(titlePie.value === 'Capacitación') {
    data = [datos[3], datos[4], datos[5]];
  } else if(titlePie.value === 'Certificación-Competencias') {
    data = [datos[6], datos[7], datos[8]];
  } else if(titlePie.value === 'Evento') {
    data = [datos[9], datos[10], datos[11]];
  } else if(titlePie.value === 'Investigación') {
    data = [datos[12], datos[13], datos[14]];
  } else if(titlePie.value === 'Material educativo') {
    data = [datos[15], datos[16], datos[17]];
  } else if(titlePie.value === 'Plan de estudio') {
    data = [datos[18], datos[19], datos[20]];
  } else if(titlePie.value === 'Proyecto') {
    data = [datos[21], datos[22], datos[23]];
  } else if(titlePie.value === 'Otro') {
    data = [datos[24], datos[25], datos[26]];
  } else {
    data = [0, 0, 0];
  }
  return data;
};

const programasOptions = () => ({
    chart: {
        id: "char-estatus",
        type: "pie",
    },
    labels: ["En proceso", "Concluido", "Cancelado"],
    responsive: [
        {
            breakpoint: 480,
            options: {
                chart: {
                    width: 200,
                },
                legend: {
                    position: "top",
                },
            },
        },
    ],
    colors: ["#008FFB", "#00E396", "#900C3F"],
    dataLabels: {
        enabled: true,
        dropShadow: {
            enabled: false,
        },
        style: {
            fontSize: "14px",
            fontFamily: "Helvetica, Arial, sans-serif",
            fontWeight: "bold",
            colors: ["#fff"],
        },
    },
    chart: {
        toolbar: {
            show: true,
        },
    },
    title: {
        text: titlePie.value,
        align: "bottom",
        style: {
            fontSize: "16px",
            color: "#666",
        },
    },
});

const categoriasOptions = {
    chart: {
        type: "bar",
        height: 390,
    },
    plotOptions: {
        bar: {
            barHeight: "100%",
            distributed: true,
            horizontal: true,
            dataLabels: {
                position: "bottom",
            },
        },
    },
    dataLabels: {
        enabled: true,
        textAnchor: "start",
        style: {
            colors: ["#fff"],
        },
        formatter: function (val, opt) {
            //retornar el nombre y el valor
            return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val;
        },
        offsetX: 0,
        dropShadow: {
            enabled: true,
        },
    },
    stroke: {
        width: 1,
        colors: ["#fff"],
    },
    xaxis: {
        categories: [
            "Acreditación",
            "Capacitación",
            "Certificación-Competencias",
            "Evento",
            "Investigación",
            "Material educativo",
            "Plan de estudio",
            "Proyecto",
            "Otro",
        ],
    },
    yaxis: {
        labels: {
            show: false,
        },
    },
    colors: [
        "#008FFB",
        "#00E396",
        "#900C3F",
        "#FF4560",
        "#775DD0",
        "#546E7A",
        "#26a69a",
        "#D10CE8",
        "#FF8F00",
    ],
    title: {
        text: "Categorias",
        align: "bottom",
        style: {
            fontSize: "16px",
            color: "#666",
        },
    },
    tooltip: {
        theme: "dark",
        x: {
            show: false,
        },
        y: {
            title: {
                formatter: function () {
                    return "";
                },
            },
        },
    },
};

const seriesCategorias = [
    {
        data: [
            props.acreditacionCount,
            props.capacitacionCount,
            props.CertificaciónCompetenciasCount,
            props.eventoCount,
            props.investigacionCount,
            props.materialEducativoCount,
            props.planDeEstudioCount,
            props.proyectoCount,
            props.otroCount,
        ],
    },
];

const isHidden = ref(true);

const toggleDiv = () => {
    isHidden.value = !isHidden.value;
};

const clearInput = () => {
    // Limpiar el valor de todos los filtros
    filters.value.responsable.value = null;
    filters.value.involucrados.value = null;
    filters.value.PDI.value = null;
    filters.value.programa_educativo.value = null;
    filters.value.beneficios_impacto.value = null;
    filters.value.proyecto_actividad.value = null;
    filters.value.descripcion.value = null;
    filters.value.global.value = null;
    filters.value.fecha_inicio.value = null;
    filters.value.fecha_fin.value = null;
    filters.value.categoria.value = null;
    filters.value.especificar.value = null;
    filters.value.estatus.value = null;
};

const showChart2 = ref(false);

// Manejar el evento de clic en las barras del gráfico
function handleBarClick(event, chartContext, config) {
    if(config.dataPointIndex != -1){
        const barName = chartContext.w.globals.labels[config.dataPointIndex];
        titlePie.value = barName;
        showSecondChart();
    }else{
        showChart2.value = false;
    }

}

function showSecondChart() {
  showChart2.value = true;
}

watchEffect(() => {
    // Observa los cambios en los datos de la serie
    seriesProgramas();

    // Cuando los datos cambien, dispara el evento de redimensionamiento
    window.dispatchEvent(new Event('resize'));
});

</script>
<style scoped>
/* Estilos específicos para este componente */
#miDiv {
    background-color: rgb(255, 255, 255);
}
.input-container {
    display: flex;
    flex-direction: column; /* Alinear los elementos en una columna */
    align-items: center; /* Centrar horizontalmente los elementos */
    margin-top: 10px;
}
</style>

<template>
    <AppLayout title="Manufactura">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ing. en Tecnologías de Manufactura
            </h2>
            <Toast />
        </template>

        <div class="max-w-[99.9%] m-auto p-2">
            <Toolbar class="mb-4">
                <template #start>
                    <Button
                        v-if="is('Manufactura-registrar || Administrador || SecretarioAcademico')"
                        label="Registrar"
                        icon="pi pi-plus"
                        severity="success"
                        class="!mr-3"
                        @click="openDialogNuevo"
                    />
                    <Button
                        v-if="is('Manufactura-eliminar || Administrador || SecretarioAcademico')"
                        label="Eliminar"
                        icon="pi pi-trash"
                        severity="danger"
                        @click="openEliminarDialog"
                        :disabled="!selectedProduct || !selectedProduct.length"
                    />
                    <Button
                        label="Grafica"
                        icon="pi pi-chart-bar"
                        class="!ml-3"
                        @click="openResponsive"
                        :disabled="!selectedProduct || !selectedProduct.length"
                    />
                    <Button
                        label="PDF"
                        icon="pi pi-file-excel"
                        class="!ml-3"
                        @click="exportPDF"
                        :disabled="!selectedProduct || !selectedProduct.length"
                    />
                </template>

                <template #end>
                    <Button
                        label="Excel"
                        icon="pi pi-upload"
                        severity="help"
                        @click="exportCSV($event)"
                    />
                </template>
            </Toolbar>
            <div class="contenedorGraficaTabla">
                <div
                    id="contenedorGraficas"
                    class="w-full flex items-center flex-col gap-0.2 mt-15 mb-20"
                >
                    <div class="w-full">
                        <Chart
                            type="bar"
                            :data="chartData"
                            :options="chartOptions"
                            class="h-30rem"
                        />
                    </div>
                    <div
                        id="graficas"
                        class="flex justify-center items-center w-full mb-20"
                    >
                        <div id="chartCategorias" class="w-full">
                            <apexchart
                                type="bar"
                                height="430"
                                width="99%"
                                :options="categoriasOptions"
                                :series="seriesCategorias"
                                @click="handleBarClick"
                            ></apexchart>
                        </div>  
                        <div id="chartEstatus" v-show="showChart2" class="w-full">
                            <apexchart
                                type="pie"
                                height="250"
                                :options="programasOptions()"
                                :series="seriesProgramas()"
                                ref="pieChart"
                            ></apexchart>
                        </div>
                    </div>
                    <div class="w-full flex gap-5 mt-500">
                        <div
                            class="group flex flex-col justify-between rounded-sm bg-white p-4 shadow-xl transition-shadow hover:shadow-lg sm:p-6 lg:p-8 w-1/3"
                        >
                            <div>
                                <h3
                                    class="text-3xl font-bold text-indigo-600 sm:text-3xl"
                                >
                                    {{ enProcesoCount }}
                                </h3>

                                <div
                                    class="mt-2 border-t-2 border-gray-100 pt-4"
                                >
                                    <p
                                        class="text-sm font-medium uppercase text-gray-500"
                                    >
                                        En Proceso
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="group flex flex-col justify-between rounded-sm bg-white p-4 shadow-xl transition-shadow hover:shadow-lg sm:p-6 lg:p-8 w-1/3"
                        >
                            <div>
                                <h3
                                    class="text-3xl font-bold text-indigo-600 sm:text-3xl"
                                >
                                    {{ concluidoCount }}
                                </h3>

                                <div
                                    class="mt-2 border-t-2 border-gray-100 pt-4"
                                >
                                    <p
                                        class="text-sm font-medium uppercase text-gray-500"
                                    >
                                        Concluidos
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="group flex flex-col justify-between rounded-sm bg-white p-4 shadow-xl transition-shadow hover:shadow-lg sm:p-6 lg:p-8 w-1/3"
                        >
                            <div>
                                <h3
                                    class="text-3xl font-bold text-indigo-600 sm:text-3xl"
                                >
                                    {{ canceladoCount }}
                                </h3>

                                <div
                                    class="mt-2 border-t-2 border-gray-100 pt-4"
                                >
                                    <p
                                        class="text-sm font-medium uppercase text-gray-500"
                                    >
                                        Cancelados
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contendorTabla">
                    <DataTable
                        :value="registrosManufactura"
                        ref="dt"
                        class="p-datatable-sm"
                        showGridlines
                        stripedRows
                        paginator
                        :rows="5"
                        :rowsPerPageOptions="[5, 10, 20, 50]"
                        v-model:selection="selectedProduct"
                        @rowSelect="onRowSelect"
                        @rowUnselect="onRowUnselect"
                        :filters="filters"
                        :emptyMessage="noDataMessage"
                        v-model:editingRows="editingRows"
                        editMode="row"
                        @row-edit-save="onRowEditSave"
                    >
                        <template #header>
                            <div class="cc">
                                <div
                                    class="flex flex-wrap align-items-center justify-between gap-4"
                                >
                                    <!-- Add a gap between elements -->
                                    <span class="text-xl text-900 font-bold">
                                        <Button
                                            label="Filtros"
                                            severity="help"
                                            @click="toggleDiv"
                                        />
                                    </span>

                                    <span
                                        class="p-input-icon-left"
                                        style="margin-right: 10px"
                                    >
                                        <i class="pi pi-search" />
                                        <InputText
                                            v-model="filters['global'].value"
                                            placeholder="buscador"
                                        />
                                    </span>
                                    <Button
                                        label="limpiar"
                                        icon="pi pi-trash"
                                        severity="!ml-3"
                                        @click="clearInput"
                                    />
                                    <span>
                                        Total Proyectos Registrados:
                                        {{ registrosManufactura.length }}
                                    </span>

                                    <div
                                        id="miDiv"
                                        v-if="!isHidden"
                                        class="flex flex-wrap justify-center gap-4 items-center"
                                    >
                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters[
                                                        'programa_educativo'
                                                    ].value
                                                "
                                                placeholder="Programa Educativo"
                                            />
                                        </span>
                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters[
                                                        'proyecto_actividad'
                                                    ].value
                                                "
                                                placeholder="Proyecto/Actividad"
                                            />
                                        </span>

                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters['descripcion'].value
                                                "
                                                placeholder="Descripcion"
                                            />
                                        </span>
                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters[
                                                        'beneficios_impacto'
                                                    ].value
                                                "
                                                placeholder="Beneficios/Impacto"
                                            />
                                        </span>
                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters['responsable'].value
                                                "
                                                placeholder="Responsable"
                                            />
                                        </span>

                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters['involucrados']
                                                        .value
                                                "
                                                placeholder="Involucrados"
                                            />
                                        </span>

                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="filters['PDI'].value"
                                                placeholder="PDI"
                                            />
                                        </span>
                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters['fecha_inicio']
                                                        .value
                                                "
                                                placeholder="fecha_inicio"
                                            />
                                        </span>
                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters['fecha_fin'].value
                                                "
                                                placeholder="fecha_fin"
                                            />
                                        </span>
                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters['categoria'].value
                                                "
                                                placeholder="categoria"
                                            />
                                        </span>
                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters['estatus'].value
                                                "
                                                placeholder="Estatus"
                                            />
                                        </span>

                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters['especificar'].value
                                                "
                                                placeholder="Especificar"
                                            />
                                        </span>
                                    </div>
                                    <template></template>
                                </div>
                            </div>
                        </template>

                        <Column
                            selectionMode="multiple"
                            headerStyle="width: 3rem"
                        ></Column>

                        <Column field="id" header="ID" hidden> </Column>

                        <Column
                            field="programa_educativo"
                            header="Programa Educativo"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Dropdown
                                    v-model="data[field]"
                                    :options="programas_educativos_lista"
                                    optionLabel="nombre"
                                    optionValue="value"
                                >
                                </Dropdown>
                            </template>
                        </Column>

                        <Column
                            field="proyecto_actividad"
                            header="Proyecto/Actividad"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Textarea
                                    v-model="data[field]"
                                    rows="5"
                                    cols="30"
                                />
                            </template>
                        </Column>

                        <Column
                            field="descripcion"
                            header="Descripción"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Textarea
                                    v-model="data[field]"
                                    rows="5"
                                    cols="30"
                                />
                            </template>
                        </Column>

                        <Column
                            field="beneficios_impacto"
                            header="Beneficios/Impacto"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Textarea
                                    v-model="data[field]"
                                    rows="5"
                                    cols="30"
                                />
                            </template>
                        </Column>
                        <Column
                            field="responsable"
                            header="Responsable"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <InputText v-model="data[field]" />
                            </template>
                        </Column>

                        <Column
                            field="involucrados"
                            header="Involucrados"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <InputText v-model="data[field]" />
                            </template>
                        </Column>

                        <Column
                            field="PDI"
                            header="PDI"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Textarea
                                    v-model="data[field]"
                                    rows="5"
                                    cols="30"
                                />
                            </template>
                        </Column>

                        <Column
                            field="fecha_inicio"
                            header="Fecha Inicio"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Calendar
                                    id="fecha_inicio"
                                    v-model="data[field]"
                                    dateFormat="dd-mm-yy"
                                    showIcon
                                    @date-select="formatearFechaInicio"
                                />
                            </template>
                        </Column>

                        <Column
                            field="fecha_fin"
                            header="Fecha Fin"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Calendar
                                    id="fecha_inicio"
                                    v-model="data[field]"
                                    dateFormat="dd-mm-yy"
                                    showIcon
                                    @date-select="formatearFechaInicio"
                                />
                            </template>
                        </Column>

                        <Column
                            field="cantidad"
                            header="Cantidad"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <InputNumber
                                    v-model="data[field]"
                                    mode="decimal"
                                    :min="0"
                                    :max="10000"
                                    :showButtons="true"
                                />
                            </template>
                        </Column>

                        <Column
                            field="unidad"
                            header="Unidad"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Dropdown
                                    v-model="data[field]"
                                    :options="unidad_lista"
                                    optionLabel="nombre"
                                    optionValue="value"
                                >
                                </Dropdown>
                            </template>
                        </Column>

                        <Column
                            field="hombres1"
                            header="Hombres"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <InputNumber
                                    v-model="data[field]"
                                    mode="decimal"
                                    :min="0"
                                    :max="10000"
                                    :showButtons="true"
                                />
                            </template>
                        </Column>

                        <Column
                            field="mujeres1"
                            header="Mujeres"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <InputNumber
                                    v-model="data[field]"
                                    mode="decimal"
                                    :min="0"
                                    :max="10000"
                                    :showButtons="true"
                                />
                            </template>
                        </Column>

                        <Column
                            field="unidad2"
                            header="Unidad"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Dropdown
                                    v-model="data[field]"
                                    :options="unidad_lista"
                                    optionLabel="nombre"
                                    optionValue="value"
                                >
                                </Dropdown>
                            </template>
                        </Column>

                        <Column
                            field="hombres2"
                            header="Hombres"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <InputNumber
                                    v-model="data[field]"
                                    mode="decimal"
                                    :min="0"
                                    :max="10000"
                                    :showButtons="true"
                                />
                            </template>
                        </Column>

                        <Column
                            field="mujeres2"
                            header="Mujeres"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <InputNumber
                                    v-model="data[field]"
                                    mode="decimal"
                                    :min="0"
                                    :max="10000"
                                    :showButtons="true"
                                />
                            </template>
                        </Column>

                        <Column
                            field="estatus"
                            header="Estatus"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Dropdown
                                    v-model="data[field]"
                                    :options="estatus"
                                    optionLabel="nombre"
                                    optionValue="value"
                                >
                                </Dropdown>
                            </template>
                        </Column>

                        <Column
                            field="categoria"
                            header="Categoria"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Dropdown
                                    v-model="data[field]"
                                    :options="categorias_lista"
                                    optionLabel="nombre"
                                    optionValue="value"
                                >
                                </Dropdown>
                            </template>
                        </Column>

                        <Column
                            field="especificar"
                            header="Especificar"
                            :filter="true"
                            filterMatchMode="in"
                        >
                            <template #editor="{ data, field }">
                                <Textarea
                                    v-model="data[field]"
                                    rows="5"
                                    cols="30"
                                />
                            </template>
                        </Column>

                        <Column
                            :rowEditor="true"
                            style="width: 10%; min-width: 8rem"
                            bodyStyle="text-align:center"
                        >
                        </Column>

                        <!-- mensaje de no hay datos -->
                        <template #empty>
                            <div
                                class="flex justify-center align-middle text-xl"
                            >
                                <h2>No se encontraron datos</h2>
                            </div>
                        </template>
                    </DataTable>
                </div>
            </div>

            <!-- Dialog para REGISTRAR nuevo -->
            <Dialog
                v-model:visible="productDialog"
                :style="{ width: '650px' }"
                header="Registro nuevo"
                :modal="true"
                class="p-fluid"
            >
                <label for="carrera" class="mb-3">Programa Educativo</label>
                <Dropdown
                    id="carrera"
                    v-model="programaEducativo"
                    :options="programas_educativos_lista"
                    optionLabel="nombre"
                    optionValue="value"
                    placeholder="Programa Educativo"
                />

                <label for="minmax">Proyecto / Actividad</label>
                <InputText
                    inputId="proyecto_actividad"
                    v-model="proyecto_actividad"
                />

                <div class="mt-7 flex gap-5 justify-center">
                    <div class="w-full">
                        <span class="p-float-label">
                            <Textarea
                                v-model="descripcion"
                                rows="5"
                                cols="30"
                            />
                            <label>Descripción</label>
                        </span>
                    </div>

                    <div class="w-full">
                        <span class="p-float-label">
                            <Textarea
                                v-model="beneficios_impacto"
                                rows="5"
                                cols="30"
                            />
                            <label>Beneficios / Impacto</label>
                        </span>
                    </div>
                </div>

                <div class="w-full mt-6">
                    <span class="p-float-label">
                        <Textarea v-model="responsable" rows="5" cols="30" />
                        <label>Responsable</label>
                    </span>
                </div>

                <div class="w-full mt-6">
                    <span class="p-float-label">
                        <Textarea v-model="involucrados" rows="5" cols="30" />
                        <label>Involucrados</label>
                    </span>
                </div>

                <label for="pdi">PDI</label>
                <InputText inputId="pdi" v-model="pdi" />

                <div class="flex items-center gap-5 mt-2 justify-center">
                    <div class="w-full">
                        <label for="fecha_inicio">Fecha Inicio</label>
                        <Calendar
                            id="fecha_inicio"
                            v-model="fecha_inicio"
                            dateFormat="dd-mm-yy"
                            showIcon
                            @date-select="formatearFechaInicio"
                        />
                    </div>
                    <div class="w-full">
                        <label for="fecha_fin">Fecha Término</label>
                        <Calendar
                            id="fecha_fin"
                            v-model="fecha_fin"
                            dateFormat="dd-mm-yy"
                            showIcon
                            @date-select="formatearFechaFin"
                        />
                    </div>
                </div>

                <div
                    class="flex items-center justify-center gap-4 mt-3 text-center m-auto w-2/3"
                >
                    <div>
                        <label for="unidad1" class="mb-3">Unidad</label>
                        <Dropdown
                            id="unidad1"
                            v-model="unidad1"
                            :options="unidad_lista"
                            optionLabel="nombre"
                            optionValue="value"
                            placeholder="Unidad"
                        />
                    </div>

                    <div>
                        <label for="hombres1">H</label>
                        <InputNumber
                            inputId="hombres1"
                            v-model="hombres1"
                            mode="decimal"
                            :min="0"
                            :max="10000"
                            :showButtons="true"
                        />
                    </div>

                    <div>
                        <label for="mujeres1">M</label>
                        <InputNumber
                            inputId="mujeres1"
                            v-model="mujeres1"
                            mode="decimal"
                            :min="0"
                            :max="10000"
                            :showButtons="true"
                        />
                    </div>
                </div>
                <div
                    class="flex items-center justify-center m-auto gap-4 mt-3 text-center w-2/3"
                >
                    <div>
                        <label for="unidad2" class="mb-3">Unidad</label>
                        <Dropdown
                            id="unidad2"
                            v-model="unidad2"
                            :options="unidad_lista"
                            optionLabel="nombre"
                            optionValue="value"
                            placeholder="Unidad"
                        />
                    </div>

                    <div>
                        <label for="hombres2">H</label>
                        <InputNumber
                            inputId="hombres2"
                            v-model="hombres2"
                            mode="decimal"
                            :min="0"
                            :max="10000"
                            :showButtons="true"
                        />
                    </div>

                    <div>
                        <label for="mujeres2">M</label>
                        <InputNumber
                            inputId="mujeres2"
                            v-model="mujeres2"
                            mode="decimal"
                            :min="0"
                            :max="10000"
                            :showButtons="true"
                        />
                    </div>
                </div>
                <div class="text-center w-2/6 m-auto mt-3">
                    <label for="cantidad">Cantidad</label>
                    <InputNumber
                        inputId="cantidad"
                        v-model="cantidad"
                        disabled
                        mode="decimal"
                        :min="0"
                        :max="10000"
                        :showButtons="true"
                    />
                </div>

                <div class="flex items-center gap-3 text-center mt-4">
                    <div class="w-1/2">
                        <label for="estatus" class="mb-3">Estatus</label>
                        <Dropdown
                            v-model="estatusModel"
                            :options="estatus"
                            optionLabel="nombre"
                            optionValue="value"
                            placeholder="Estatus"
                        >
                        </Dropdown>
                    </div>
                    <div class="w-1/2">
                        <label for="categoria" class="mb-3">Categoria</label>
                        <Dropdown
                            v-model="categoria"
                            :options="categorias_lista"
                            optionLabel="nombre"
                            optionValue="value"
                            placeholder="Categoría"
                        >
                        </Dropdown>
                    </div>
                </div>

                <div class="w-full mt-6">
                    <span class="p-float-label">
                        <Textarea v-model="especificar" rows="5" cols="30" />
                        <label>Especificar</label>
                    </span>
                </div>

                <template #footer>
                    <Button
                        label="Cancelar"
                        icon="pi pi-times"
                        text
                        @click="ocultarNuevoRegistro"
                    />
                    <Button
                        label="Registrar"
                        icon="pi pi-check"
                        text
                        @click="registrarNuevo"
                    />
                </template>
            </Dialog>

            <!-- Dialog para ELIMINAR -->
            <Dialog
                v-model:visible="deleteProductsDialog"
                :style="{ width: '400px' }"
                header="Confirmar"
                :modal="true"
            >
                <div
                    class="confirmation-content flex justify-center items-center"
                >
                    <i
                        class="pi pi-exclamation-triangle mr-3"
                        style="font-size: 2rem"
                    />
                    <span
                        >¿Esta seguro de eliminar los registro(s)
                        seleccionado(s)?</span
                    >
                </div>
                <template #footer>
                    <Button
                        label="Cancelar"
                        icon="pi pi-times"
                        text
                        @click="deleteProductsDialog = false"
                    />
                    <Button
                        label="Eliminar"
                        icon="pi pi-check"
                        text
                        @click="eliminarProductos"
                    />
                </template>
            </Dialog>

            <!-- Dialog para Grafica -->
            <Dialog
                header=" "
                v-model:visible="displayResponsive"
                :breakpoints="{ '960px': '75vw', '75vw': '90vw' }"
                :style="{ width: '70vw' }"
            >
                <graficaHM class="m-auto" :datos="selectedProduct" />

                <template #footer>
                    <Button
                        label="Cerrar"
                        icon="pi pi-check"
                        @click="closeResponsive"
                        autofocus
                    />
                </template>
            </Dialog>
        </div>
    </AppLayout>
</template>

<style scoped></style>
