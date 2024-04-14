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
});

onMounted(() => {
});
series = [
    {
        data: [
            {
                x: 'Ing. Sistemas Computacionales',
                y:  props.enProcesoSistema,
            },
            {
                x: 'Ing. Manufactura',
                y: props.enProcesoManufactura,
            },
            {
                x: 'Ing. Mecatrónica',
                y: props.enProcesoMecatronica,
            },
            {
                x: 'Ing. Automotriz',
                y: props.enProcesoAutomotriz,
            },
            {
                x: 'Ing. Negocios',
                y: props.enProcesoNegocio,
            },
            {
                x: 'Ing. Coordinación',
                y: props.enProcesoCoordinacion,
            },
            {
                x: 'Ing. LAGE',
                y: props.enProcesoLAGE,
            },
            {
                x: 'Posgrado',
                y: props.enProcesoPosgrado,
            },
            {
                x: 'REDES',
                y: props.enProcesoRede,
            },
        ]
    }
],
chartOptions = {
        chart: {
            height: 350,
            type: 'treemap'
        },
        title: {
            text: 'Proyectos en proceso por programa educativo',
            align: 'center',
            style: {
                fontSize: '18px',
                color: '#666',
                fontFamily: 'Roboto, sans-serif',
                fontWeight: 'bold'
            },
        },
        series: series.value,
        legend: {
            show: false
        },
        plotOptions: {
            treemap: {
                distributed: true,
                enableShades: false
            }
        },
        fill: {
            type: 'solid',
            opacity: 0.8
        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '18px',
                fontFamily: 'Roboto, sans-serif',
                fontWeight: 'bold'
            },
        },
        tooltip: {
            enabled: true,
        },
        //colors -- se pueden remplazar por los colores de cada programa educativo
        // colors: ['#3B93A5', '#F7B844', '#ADD8C7', '#EC3C65', '#CDD7B6', '#C1F666', '#D43F97', '#1E5D8C', '#421243', '#7F94B0', '#EF6537', '#C0ADDB'],
        
    }
</script>

<template>
    <div id="chart">
        <apexchart type="treemap" height="350" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>