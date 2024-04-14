<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps, onMounted, ref } from 'vue';
import bienvenidaGraficaTree from "./bienvenidaGraficaTree.vue";
import radialTotalsChart from "./radialTotalsChart.vue";
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
</script>

<template>
    <AppLayout title="Inicio">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inicio
            </h2>
        </template>
        <div class="relative h-[85vh] flex flex-col-reverse py-16 lg:pt-0 lg:flex-col lg:pb-0">
            <div
                class="inset-y-0 top-0 right-0 z-0 w-full max-w-xl px-4  md:px-0 lg:pr-0 lg:mb-0 lg:mx-0 lg:w-7/12 lg:max-w-full lg:absolute xl:px-0">
                <svg class="absolute left-0 hidden h-full text-white transform -translate-x-1/2 lg:block"
                    viewBox="0 0 100 100" fill="currentColor" preserveAspectRatio="none slice">
                    <path d="M50 0H100L50 100H0L50 0Z"></path>
                </svg>
                <img class="object-cover w-full h-56 rounded shadow-lg lg:rounded-none lg:shadow-none md:h-96 lg:h-full"
                    src="images/backgroundLoginRegister.jpg" alt="" />
            </div>
            <div class="relative flex flex-col items-start w-full max-w-xl px-4 md:px-0 lg:px-8 lg:max-w-screen-xl">
                <div class="mb-16 lg:my-40 lg:max-w-lg lg:pr-5">
                    <p
                        class="inline-block px-3 py-px mb-4 text-xs font-semibold tracking-wider text-teal-900 uppercase rounded-full bg-teal-accent-400">
                        RSAC
                    </p>
                    <h2 class="mb-5 font-sans text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl sm:leading-none">
                        Bienvenido a el <br class="hidden md:block" />
                        Sistema
                        <span class="inline-block text-deep-purple-accent-400">Reportes SAC</span>
                    </h2>
                    <p class="pr-5 mb-5 text-base text-gray-700 md:text-lg">
                        Aqui podras encontrar todo lo relacionado con los reportes SAC, desde la creacion de reportes,
                        ingresar información y ver graficas de los reportes.
                    </p>
                    <h3>Desplazate hacia abajo para ver indicadores sobre los proyectos!</h3>
                    
                </div>
                <div class="scroll-down-dude"></div>
            </div>
        </div>
        <div id="charts" class=" mt-40 w-full m-auto flex justify-center items-center gap-6">
            <div id="treeChart" class="w-2/3">
                <bienvenidaGraficaTree
                :enProcesoAutomotriz="enProcesoAutomotriz"
                :enProcesoCoordinacion="enProcesoCoordinacion"
                :enProcesoLAGE="enProcesoLAGE"
                :enProcesoManufactura="enProcesoManufactura"
                :enProcesoMecatronica="enProcesoMecatronica"
                :enProcesoNegocio="enProcesoNegocio"
                :enProcesoPosgrado="enProcesoPosgrado"
                :enProcesoRede="enProcesoRede"
                :enProcesoSistema="enProcesoSistema"
            />
            </div>

            <div id="radialChart" class="h-1/3">
                <radialTotalsChart 
                :enProcesoAutomotriz="enProcesoAutomotriz"
                :enProcesoCoordinacion="enProcesoCoordinacion"
                :enProcesoLAGE="enProcesoLAGE"
                :enProcesoManufactura="enProcesoManufactura"
                :enProcesoMecatronica="enProcesoMecatronica"
                :enProcesoNegocio="enProcesoNegocio"
                :enProcesoPosgrado="enProcesoPosgrado"
                :enProcesoRede="enProcesoRede"
                :enProcesoSistema="enProcesoSistema"

                :concluidoAutomotriz="concluidoAutomotriz"
                :concluidoCoordinacion="concluidoCoordinacion"
                :concluidoLAGE="concluidoLAGE"
                :concluidoManufactura="concluidoManufactura"
                :concluidoMecatronica="concluidoMecatronica"
                :concluidoNegocio="concluidoNegocio"
                :concluidoPosgrado="concluidoPosgrado"
                :concluidoRede="concluidoRede"
                :concluidoSistema="concluidoSistema"

                :canceladoAutomotriz="canceladoAutomotriz"
                :canceladoCoordinacion="canceladoCoordinacion"
                :canceladoLAGE="canceladoLAGE"
                :canceladoManufactura="canceladoManufactura"
                :canceladoMecatronica="canceladoMecatronica"
                :canceladoNegocio="canceladoNegocio"
                :canceladoPosgrado="canceladoPosgrado"
                :canceladoRede="canceladoRede"
                :canceladoSistema="canceladoSistema"

                
                />
            </div>
        </div>
        
    </AppLayout>
</template>

<style scoped>
.scroll-down-dude {
  position: absolute;
  bottom: 50px;
  left: 20%;
  margin-left: -12px;
  width: 24px;
  height: 24px;
  border: 2px solid rgb(255, 255, 255);
  border-radius: 50%;
  -webkit-animation: bounce 2s infinite 2s;
          animation: bounce 2s infinite 2s;
}
.scroll-down-dude:before,
.scroll-down-dude:after {
  content: "";
  display: block;
  width: 12px;
  height: 12px;
  transform: rotate(45deg);
  border-bottom: 4px solid #a1222c;
  border-right: 4px solid #a1222c;
}

.scroll-down-dude:before {
  -webkit-animation: down-arrow-before 2.6s cubic-bezier(0.77, 0, 0.175, 1) infinite;
          animation: down-arrow-before 2.6s cubic-bezier(0.77, 0, 0.175, 1) infinite;
}

.scroll-down-dude:after {
  -webkit-animation: down-arrow-after 2.6s cubic-bezier(0.77, 0, 0.175, 1) infinite;
          animation: down-arrow-after 2.6s cubic-bezier(0.77, 0, 0.175, 1) infinite;
}

@-webkit-keyframes down-arrow-before {
  50% {
    transform: rotate(45deg) translate(70%, 70%);
  }
  100% {
    transform: rotate(45deg) translate(70%, 70%);
  }
}

@keyframes down-arrow-before {
  50% {
    transform: rotate(45deg) translate(70%, 70%);
  }
  100% {
    transform: rotate(45deg) translate(70%, 70%);
  }
}
@-webkit-keyframes down-arrow-after {
  50% {
    transform: rotate(45deg) translate(110%, 110%);
    opacity: 0;
  }
  51% {
    transform: rotate(45deg) translate(-130%, -130%);
  }
  100% {
    transform: rotate(45deg) translate(-70%, -70%);
    opacity: 1;
  }
}
@keyframes down-arrow-after {
  50% {
    transform: rotate(45deg) translate(110%, 110%);
    opacity: 0;
  }
  51% {
    transform: rotate(45deg) translate(-130%, -130%);
  }
  100% {
    transform: rotate(45deg) translate(-70%, -70%);
    opacity: 1;
  }
}
</style>


