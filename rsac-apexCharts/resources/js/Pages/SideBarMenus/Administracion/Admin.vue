<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from '@/Components/InputError.vue';
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


const props = defineProps({
    users: {
        type: Array,
        required: true
    },
});

const roles = [
    { name: 'Administrador', value: 'Administrador' },
    { name: 'Automotriz', value: 'Automotriz' },
    { name: 'Manufactura', value: 'Manufactura' },
    { name: 'Redes', value: 'Redes' },
    { name: 'LAGE', value: 'LAGE' },
    { name: 'Mecatronica', value: 'Mecatronica' },
    { name: 'Negocios', value: 'Negocios' },
    { name: 'Posgrado', value: 'Posgrado' },
    { name: 'Sistemas', value: 'Sistemas' },
    { name: 'Coordinacion', value: 'Coordinacion' },
    { name: 'Resumen', value: 'Resumen' },
    { name: 'Rector', value: 'Rector' },
    { name: 'SecretarioAcademico', value: 'SecretarioAcademico' },
];

let rolesA = [
    'Automotriz',
    'Manufactura',
    'Redes',
    'LAGE',
    'Mecatronica',
    'Negocios',
    'Posgrado',
    'Sistemas',
    'Coordinacion',
    'Resumen',
    'Administrador',
    
].map(role => ({ role: role }));

let actions = ['registrar', 'eliminar'];




const emptyMessage = 'No hay registros';
const rolesDropdown = ref(null);
const nuevoUsuarioDialog = ref(false);
const deleteProductsDialog = ref(false);
const manageRolesDialog = ref(false);
const confirmDialog = ref(false);
const selectedProduct = ref();
const toast = useToast();
const selectedUserId = ref(null)
const pressedButtons = ref([]);

const nombre = ref('');
const email = ref('');
const password = ref('');
const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const closeDialogNuevo = () => {
    nuevoUsuarioDialog.value = false;
}

const openEliminarDialog = () => {
    deleteProductsDialog.value = true;
};

const openDialogNuevo = () => {
    nuevoUsuarioDialog.value = true;
}

const formatDateTime = (dateTime) => {
    const options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' , second: '2-digit'};
    return new Date(dateTime).toLocaleString(undefined, options);
}


const editRoles = (roles, id_user) => {
    // Limpiar el array de presionados
    pressedButtons.value = [];
    selectedUserId.value = id_user;
    // Agregar los roles del usuario al array de presionados
    for (let role of roles){
        pressedButtons.value.push(role.name);
    }
    // Abrir el diálogo de edición de roles
    manageRolesDialog.value = true;
}


// Definir método togglePress correctamente
const togglePress = (role) => {
    // Verificar si el rol seleccionado contiene un sufijo específico
    const hasSuffix = role.includes('-registrar') || role.includes('-eliminar') || role.includes('-editar');

    // Si tiene un sufijo, seleccionar automáticamente el rol base sin el sufijo
    if(!pressedButtons.value.includes(role)){
        if (hasSuffix) { 
            const baseRole = role.replace('-registrar', '').replace('-eliminar', '').replace('-editar', '');
            // Si el botón base no está seleccionado, selecciónalo
            if (!pressedButtons.value.includes(baseRole)) {
                pressedButtons.value.push(baseRole);
            }
        }

    }    

    // Toggle de la selección del rol
    if (pressedButtons.value.includes(role)) {
        pressedButtons.value = pressedButtons.value.filter(button => button !== role);
    } else {
        pressedButtons.value.push(role);
    }
}

// Definir método buttonClass correctamente
const buttonClass = (role) => {

    if (!pressedButtons.value.includes(role)) {
        return 'w-full flex justify-center items-center opacity-50';
    } else {
        return 'w-full flex justify-center items-center';
    }
}

const submit = () => {

    const data = {
        name: nombre.value,
        email: email.value,
        password: password.value,
    }
    Inertia.post("/registrar-nuevo-usuario", data, {
        onSuccess: () => {
            nuevoUsuarioDialog.value = false;
            toast.add({
                severity: "success",
                summary: "Exito",
                detail: "Registrado exitosamente",
                life: 3000,
            });
        },
    });
}

const editarRol = () =>{


    const id_user = selectedUserId.value;
    const data = {
        roles: pressedButtons.value
    }
    Inertia.post(`/asignar-rol/${id_user}`, data, {
        onSuccess: () => {
            toast.add({
                severity: "success",
                summary: "Exito",
                detail: "Roles actualizados exitosamente",
                life: 3000,
            });
        },
    });

    manageRolesDialog.value = false;

} 

const confirmarGuardar = () => {
    // Mostrar el diálogo de confirmación
    confirmDialog.value = true;
}

const openConfirmDialog = () => {
    // Mostrar el diálogo de confirmación si hay cambios
        confirmarGuardar();
}

const cancelConfirm = () => {
    // Cerrar el diálogo de confirmación
    confirmDialog.value = false;
}

const guardarCambios = () => {
    // Guardar los cambios
    editarRol();
    // Cerrar el diálogo de confirmación
    confirmDialog.value = false;
}

const eliminarUsuario = () => {
    const data = {
        id: selectedProduct.value.map((item) => item.id)
    }
    Inertia.post("/eliminar-usuario", data, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            deleteProductsDialog.value = false;
            selectedProduct.value = null;
            toast.add({
                severity: "success",
                summary: "Exito",
                detail: "Eliminado Exitosamente",
                life: 3000,
            });
        },
    });
}

const clearInput = () => {
    // Limpiar el valor de todos los filtros
    filters.value['global'].value = null;
};

</script>

<template>
    <AppLayout title="Administración">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Administración
            </h2>
            <Toast />
        </template>

        <div class="max-w-[99.9%] m-auto p-2">
            <Toolbar class="mb-4">
                <template #start>
                    <Button label="Registrar" icon="pi pi-plus" severity="success" class="!mr-3" @click="openDialogNuevo" />
                    <Button label="Eliminar" icon="pi pi-trash" severity="danger" @click="openEliminarDialog"
                        :disabled="!selectedProduct || !selectedProduct.length" />
                </template>
            </Toolbar>
            <!-- tabla con los registros de los usuarios -->
            <DataTable :value="users" 
                :paginator="true" :rows="10" :rowsPerPageOptions="[5, 10, 20]" :responsive="true" :filters="filters"
                v-model:selection="selectedProduct" :emptyMessage="emptyMessage" class="p-datatable-gridlines">

                <template #header>
                    <div class="flex flex-wrap align-items-center justify-between gap-2">
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters['global'].value" placeholder="Buscar" />
                            <Button
                                class="!ml-10"
                                label="limpiar"
                                icon="pi pi-trash"
                                severity="!ml-3"
                                @click="clearInput"
                            />
                        </span>
                    </div>
                </template>


                <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                <Column field="id" header="ID" sortable hidden />
                <Column field="name" header="Nombre" sortable :filter="true" filterMatchMode="in"/>
                <Column field="email" header="Correo" sortable :filter="true" filterMatchMode="in"/>
                <Column field="created_at" header="Fecha de creación" sortable :filter="true" filterMatchMode="in">
                    <template #body="slotProps">
                        {{ formatDateTime(slotProps.data.created_at) }}
                    </template>
                </Column>

                <Column field="roles" header="Rol" sortable>
                    <template #body="slotProps">
                        <div class="flex justify-center gap-3 p-4 flex-wrap"> <!-- Agrega flex-wrap aquí -->
                            <span v-for="role in slotProps.data.roles" :key="role.id"
                                class="p-tag p-tag-rounded p-tag-info">
                                {{ role.name }}
                            </span>
                        </div>
                    </template>
                </Column>
                <Column field="manageRoles" header="Permisos">
                    <template #body="slotProps">
                        <Button label="Editar" @click="editRoles(slotProps.data.roles, slotProps.data.id)" />
                    </template>
                </Column>            
            </DataTable>

        </div>

        <!-- Dialog para registrar un nuevo usuario -->
        <Dialog v-model:visible="nuevoUsuarioDialog" :style="{ width: '650px' }" header="Registro nuevo" :modal="true"
            class="p-fluid">
            <form @submit.prevent="submit">
                <div class="p-field">
                    <label for="name">Nombre</label>
                    <InputText id="name" v-model="nombre" />

                </div>

                <div class="p-field">
                    <label for="email">Correo</label>
                    <InputText type="email" id="email" v-model="email" />
                </div>

                <div class="p-field">
                    <label for="password">Contraseña</label>
                    <InputText type="password" id="password" v-model="password" />
                </div>

                <div class="flex justify-end items-center max-w-[100%] mt-4 gap-4">
                    <Button type="submit" class="w-auto" label="Registrar" icon="pi pi-check" />
                </div>
            </form>
        </Dialog>

        <!-- Dialog para eliminar -->
        <Dialog v-model:visible="deleteProductsDialog" :style="{ width: '400px' }" header="Confirmar" :modal="true">
            <div class="confirmation-content flex justify-center items-center">
                <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                <span>¿Esta seguro de eliminar los usuarios seleccionados?</span>
            </div>
            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" text @click="deleteProductsDialog = false" />
                <Button label="Eliminar" icon="pi pi-check" text @click="eliminarUsuario" />
            </template>
        </Dialog>

        <!-- Dialog para editar roles -->
        <Dialog v-model:visible="manageRolesDialog" header="Editar permisos">
            <DataTable :value="rolesA">
                <Column field="role" header="Rol">
                    <template #body="slotProps">
                        <Button 
                        v-if="slotProps.data.role !== 'Rector' && slotProps.data.role !== 'SecretarioAcademico'"
                         :class="buttonClass(slotProps.data.role)" v-text="slotProps.data.role" @click="togglePress(slotProps.data.role)"/>
                    </template>
                </Column>
                <Column v-for="action in actions" :field="action" :header="action === 'registrar' ? 'Registrar' : action === 'eliminar' ? 'Eliminar' : 'Editar'">
                    <template #body="slotProps">
                        <Button 
                            v-if="slotProps.data.role !== 'Administrador' && slotProps.data.role !== 'Rector' && slotProps.data.role !== 'SecretarioAcademico'"
                            :class="buttonClass(slotProps.data.role + '-' + action)"
                            v-text="slotProps.data.role + '-' + action"
                            :severity="action === 'registrar' ? 'success' : action === 'eliminar' ? 'danger' : 'warning'"
                            @click="togglePress(slotProps.data.role + '-' + action)"
                        />
                        <Button 
                            v-if="slotProps.data.role == 'Administrador' && action === 'registrar'"
                            :class="buttonClass('Rector')"
                            v-text="'Rector'"
                            @click="togglePress('Rector')"
                        />
                        <Button 
                            v-if="slotProps.data.role == 'Administrador' && action === 'eliminar'"
                            :class="buttonClass('SecretarioAcademico')"
                            v-text="'SecretarioAcademico'"
                            @click="togglePress('SecretarioAcademico')"
                        />
                    </template>
                </Column>
            </DataTable>

            <template #footer>
                <div class="flex justify-between mt-1">
                    <Button label="Cancelar" icon="pi pi-times" @click="manageRolesDialog = false" />
                    <Button label="Guardar" icon="pi pi-check" @click="openConfirmDialog" />
                </div>
            </template>
        </Dialog>

        <!-- Dialog para confirmar guardar cambios -->
        <Dialog v-model:visible="confirmDialog" header="Confirmar cambios">
            <div class="p-fluid">
                <p>¿Está seguro que desea guardar los cambios realizados?</p>
            </div>
            <template #footer>
                <div class="flex justify-between">
                    <Button label="Cancelar" icon="pi pi-times" @click="cancelConfirm" />
                    <Button label="Guardar" icon="pi pi-check" @click="guardarCambios" />
                </div>
            </template>
        </Dialog>





    </AppLayout>>
</template>

