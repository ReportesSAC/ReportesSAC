<script setup>
import { ref, onMounted } from 'vue';
import { watch } from 'vue';

import { FilterMatchMode } from 'primevue/api';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Dropdown from 'primevue/dropdown';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';
import { Inertia } from '@inertiajs/inertia'
import Chart from 'primevue/chart';

const props = defineProps({
    registrosTransversales: {
        type: Array,
        required: true
    },

});

const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const dt = ref();
const registroActTransversalDialog = ref(false);
const nueva_act_transversal = ref(null);
const selectedProduct = ref();
const toast = useToast();
const editingRows = ref([]);
const noDataMessage = "No se encontraron datos";
const deleteProductsDialog = ref(false);

const onRowSelect = (event) => {
    const selectedRowData = event.data;
};
const onRowUnselect = (event) => {
    // alert('Producto deseleccionado')
}

const openDialogRegistrarActTransversal = () => {
    registroActTransversalDialog.value = true;
};

const registrarActTransversal = () => {
    const data = {
        nombre_evento: nueva_act_transversal.value,

    }
    Inertia.post("/registrar-act-transversal", data, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            registroActTransversalDialog.value = false;
            toast.add({
                severity: "success",
                summary: "Exito",
                detail: `Evento ${nueva_act_transversal.value} agregado exitosamente`,
                life: 7000,
            });
        },
    });
}

const onRowEditSave = (event) => {
    let { newData } = event;

    const data = {
        id: newData.id,
        nombre_evento: newData.nombre_evento,
    }

    Inertia.post(`/editar-act-transversal/${newData.id}`, data, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            toast.add({
                severity: "success",
                summary: "Exito",
                detail: "Editado correctamente",
                life: 3000,
            });
        },
    });

}

const eliminarActividad = () => {
    const data = {
        id: selectedProduct.value.map((item) => item.id)
    }
    Inertia.post("/eliminar-act-transversal", data, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            deleteProductsDialog.value = false;
            selectedProduct.value = null;
            toast.add({
                severity: "success",
                summary: "Exito",
                detail: "Eliminado exitosamente",
                life: 3000,
            });
        },
    });
}

const openEliminarDialog = () => {
    deleteProductsDialog.value = true;
};
</script>

<template>
    <div class="max-w-[99.9%] m-auto p-2">
        <Toolbar class="mb-4">
            <template #start>
                <Button v-if="is('Resumen-registrar || Administrador || SecretarioAcademico')" label="Registrar nueva Act. Transversal" icon="pi pi-plus" severity="success" class="!mr-3"
                    @click="openDialogRegistrarActTransversal" />
                <Button v-if="is('Resumen-eliminar || Administrador || SecretarioAcademico')" label="Eliminar" icon="pi pi-trash" severity="danger" @click="openEliminarDialog"
                    :disabled="!selectedProduct || !selectedProduct.length" />
            </template>

            <template #end>
                <Button label="Excel" icon="pi pi-upload" severity="help" @click="exportCSV($event)" />
            </template>
        </Toolbar>

        <DataTable :value="registrosTransversales" ref="dt" class="p-datatable-sm" showGridlines stripedRows paginator
                :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" v-model:selection="selectedProduct" @rowSelect="onRowSelect"
                @rowUnselect="onRowUnselect" :filters="filters" :emptyMessage="noDataMessage"
                v-model:editingRows="editingRows" editMode="row" @row-edit-save="onRowEditSave">

                <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                <Column field="nombre_evento" header="Nombre Act. Transversal" sortable>
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]"  />
                    </template>
                </Column>

                <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center">
                </Column>
        </DataTable>

    </div>

     <!-- dialog para registrar una NUEVA Act transversal -->
     <Dialog v-model:visible="registroActTransversalDialog" :style="{ width: '400px' }" header="Registrar Act. Transversal"
            :modal="true">

           <div class="flex flex-col">
            <label for="nombre_actividad">Nombre Act. Transversal</label>
            <InputText id="nombre_actividad" v-model="nueva_act_transversal" />
          
           </div>

            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" text @click="registroActTransversalDialog = false" />
                <Button label="Registrar" icon="pi pi-check" text @click="registrarActTransversal" />
            </template>

        </Dialog>

          <!-- Dialog para ELIMINAR -->
          <Dialog v-model:visible="deleteProductsDialog" :style="{ width: '400px' }" header="Confirmar" :modal="true">
            <div class="confirmation-content flex justify-center items-center">
                <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                <span>¿Esta seguro de eliminar los registro(s) seleccionado(s)?</span>
            </div>
            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" text @click="deleteProductsDialog = false" />
                <Button label="Eliminar" icon="pi pi-check" text @click="eliminarActividad" />
            </template>
        </Dialog>

</template>

<style scoped></style>