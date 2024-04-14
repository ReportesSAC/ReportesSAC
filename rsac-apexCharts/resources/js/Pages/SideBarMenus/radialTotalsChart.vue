<script setup>
import { defineProps, onMounted, ref } from 'vue';
let series = ref([]);
let chartOptions = ref({});

const props = defineProps({
    enProcesoAutomotriz: {
        type: Number,
    },
    enProcesoCoordinacion: {
        type: Number,
    },
    enProcesoLAGE: {
        type: Number,
    },
    enProcesoManufactura: {
        type: Number,
    },
    enProcesoMecatronica: {
        type: Number,
    },
    enProcesoNegocio: {
        type: Number,
    },
    enProcesoPosgrado: {
        type: Number,
    },
    enProcesoRede: {
        type: Number,
    },
    enProcesoSistema: {
        type: Number,
    },

    concluidoAutomotriz: {
        type: Number,
    },
    concluidoCoordinacion: {
        type: Number,
    },
    concluidoLAGE: {
        type: Number,
    },
    concluidoManufactura: {
        type: Number,
    },
    concluidoMecatronica: {
        type: Number,
    },
    concluidoNegocio: {
        type: Number,
    },
    concluidoPosgrado: {
        type: Number,
    },
    concluidoRede: {
        type: Number,
    },
    concluidoSistema: {
        type: Number,
    },

    canceladoAutomotriz: {
        type: Number,
    },
    canceladoCoordinacion: {
        type: Number,
    },
    canceladoLAGE: {
        type: Number,
    },
    canceladoManufactura: {
        type: Number,
    },
    canceladoMecatronica: {
        type: Number,
    },
    canceladoNegocio: {
        type: Number,
    },
    canceladoPosgrado: {
        type: Number,
    },
    canceladoRede: {
        type: Number,
    },
    canceladoSistema: {
        type: Number,
    },

});

onMounted(() => {
});
series = [
    props.enProcesoAutomotriz + props.enProcesoCoordinacion + props.enProcesoLAGE + props.enProcesoManufactura + props.enProcesoMecatronica + props.enProcesoNegocio + props.enProcesoPosgrado + props.enProcesoRede + props.enProcesoSistema,

    props.concluidoAutomotriz + props.concluidoCoordinacion + props.concluidoLAGE + props.concluidoManufactura + props.concluidoMecatronica + props.concluidoNegocio + props.concluidoPosgrado + props.concluidoRede + props.concluidoSistema,

    props.canceladoAutomotriz + props.canceladoCoordinacion + props.canceladoLAGE + props.canceladoManufactura + props.canceladoMecatronica + props.canceladoNegocio + props.canceladoPosgrado + props.canceladoRede + props.canceladoSistema,
],
    chartOptions = {
        chart: {
            height: 350,
            type: 'radialBar',
        },
        title: {
            text: 'Estatus de Proyectos',
            align: 'center',
            style: {
                fontSize: '16px',
                color: '#666'
            }
        },
        plotOptions : {
            radialBar: {
                dataLabels: {
                    name: {
                        fontSize: '22px',
                    },
                    value: {
                        fontSize: '16px',
                    },
                    total: {
                        show: true,
                        label: 'Total',
                        formatter: function (w) {
                            const maxPercent = 30;
                            let sumaEnProceso = props.enProcesoAutomotriz + props.enProcesoCoordinacion + props.enProcesoLAGE + props.enProcesoManufactura + props.enProcesoMecatronica + props.enProcesoNegocio + props.enProcesoPosgrado + props.enProcesoRede + props.enProcesoSistema;

                            let sumaConcluido = props.concluidoAutomotriz + props.concluidoCoordinacion + props.concluidoLAGE + props.concluidoManufactura + props.concluidoMecatronica + props.concluidoNegocio + props.concluidoPosgrado + props.concluidoRede + props.concluidoSistema;

                            let sumaCancelado = props.canceladoAutomotriz + props.canceladoCoordinacion + props.canceladoLAGE + props.canceladoManufactura + props.canceladoMecatronica + props.canceladoNegocio + props.canceladoPosgrado + props.canceladoRede + props.canceladoSistema;

                            let sumaTotal = sumaEnProceso + sumaConcluido + sumaCancelado;

                            return sumaTotal;
                        }
                    }
                }
            }
        },
        labels: [
            'En Proceso',
            'Concluido',
            'Cancelado',
            'Total'
        ],
        colors: ['#1ab7ea', '#0084ff', '#39539E'],

    }
</script>

<template>
    <div id="chart">
        <apexchart type="radialBar" height="350" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>