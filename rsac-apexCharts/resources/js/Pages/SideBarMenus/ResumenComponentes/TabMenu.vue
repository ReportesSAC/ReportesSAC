<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Registros from "@/Pages/SideBarMenus/ResumenComponentes/Registros.vue";
import ActsTransversales from "@/Pages/SideBarMenus/ResumenComponentes/ActsTransversales.vue";
import { ref, onMounted } from 'vue';

import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';


const props = defineProps({
    registrosResumen: {
        type: Array,
        required: true
    },
    registrosTransversales: {
        type: Array,
        required: true
    },
    totalAcreditacion: {
        type: Number,
    },
    totalCapacitacion: {
        type: Number,
    },
    totalCertificacion: {
        type: Number,
    },
    totalEvento: {
        type: Number,
    },
    totalInvestigacion: {
        type: Number,
    },
    totalMaterialEducativo: {
        type: Number,
    },
    totalPlanEstudios: {
        type: Number,
    },
    totalProyecto: {
        type: Number,
    },
    totalOtro: {
        type: Number,
    },
    totalTodos: {
        type: Number,
    },
    totales: {
        type: Array,
    }
    
});

// checar si llegaron los props con onmounted
onMounted(() => {
    // console.log(props.registrosResumen);
    // console.log(props.registrosTransversales);
});


</script>

<template>
    <AppLayout title="Resúmen">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Resumen
            </h2>
        </template>
        <TabView ref="tabview1" class="p-3">
            <TabPanel header="Registros">
                <Registros 
                :registrosTransversales="registrosTransversales"
                :registrosResumen="registrosResumen" 
                :totalAcreditacion="totalAcreditacion"
                :totalCapacitacion="totalCapacitacion"
                :totalCertificacion="totalCertificacion"
                :totalEvento="totalEvento"
                :totalInvestigacion="totalInvestigacion"
                :totalMaterialEducativo="totalMaterialEducativo"
                :totalPlanEstudios="totalPlanEstudios"
                :totalProyecto="totalProyecto"
                :totalOtro="totalOtro"
                :totalTodos="totalTodos"
                :totales="totales"
                 />
            </TabPanel>
            <TabPanel header="Actividades Transversales">
                <ActsTransversales :registrosTransversales="registrosTransversales"   />
            </TabPanel>
        </TabView>
    </AppLayout>
</template>