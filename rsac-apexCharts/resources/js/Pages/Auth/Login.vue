<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head title="Iniciar Sesión" />

  <!-- esto div es para el mensaje de error -->
  <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
    {{ status }}
  </div>

    <div className="grid grid-cols-1 lg:grid-cols-2 min-h-screen">
      <div id="ladoIzq" className="flex flex-col items-center justify-center bg-gray-100 rounded-tl-lg rounded-bl-lg p-4">
        <div className="my-1">
          <img src="images/logoUPQ.png" alt="Logo reportes SAC" width="200" height="200" />
        </div>
        <div className="flex flex-col items-center gap-8">
          <h1 className="text-4xl font-bold text-gray-900">Bienvenido</h1>
        </div>
        <div className="my-8">
          <p
            className="text-center relative text-gray-500 bg-gray-100 before:max-w-[50px] md:before:max-w-[120px] before:w-full before:-left-[60px] md:before:-left-[140px] before:h-[1px] before:bg-current before:absolute before:top-[50%] after:max-w-[50px] md:after:max-w-[120px] after:w-full after:h-[1px] after:bg-current after:absolute after:top-[50%] after:-right-[60px] md:after:-right-[140px]">
            Ingresa con tu correo
          </p>
        </div>
        <div className="w-1/2 mb-8">
          <form @submit.prevent="submit">

             <div class="col-span-6">
                  <div>
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"
                        required
                        autofocus
                        placeholder="Correo"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                 
                </div>

                <div class="col-span-6">
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        required
                        autocomplete="current-password"
                        placeholder="Contraseña"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
            <div className="w-full max-w-md mx-auto flex items-center justify-between text-gray-500 mb-8">

              <div className="flex items-center gap-2">
                <label class="flex items-center">
                  <Checkbox v-model:checked="form.remember" name="remember" />
                  <span class="ml-2 text-sm text-gray-600">Recuérdame</span>
                </label>
              </div>

              

            </div>
            
            <div className="w-full max-w-md mx-auto">
              <button type="submit"
                className="w-full bg-gray-200 py-2 px-4 rounded-lg text-gray-900 hover:bg-gray-300 transition-colors">
                Iniciar sesión
              </button>
            </div>
          </form>
        </div>
      </div>
      <div className="hidden lg:flex items-center justify-center border-t border-r border-b rounded-tr-lg rounded-br-lg">
        <img src="images/backgroundLoginRegister.jpg" className=" object-cover h-full" />

      </div>
    </div>
</template>

<style >
body {
  overflow-y: hidden !important;
}
</style>
