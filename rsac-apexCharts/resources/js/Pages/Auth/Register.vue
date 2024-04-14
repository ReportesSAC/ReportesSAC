<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Registro" />

    <form @submit.prevent="submit">
        <div className="grid grid-cols-1 lg:grid-cols-2 min-h-screen">
            <div id="ladoIzq"
                className="flex flex-col items-center justify-center bg-gray-100 rounded-tl-lg rounded-bl-lg p-4">
                <div className="my-1">
                    <img src="images/logoUPQ.png" alt="Logo reportes SAC" width="200" height="200" />
                </div>
                <div className="flex flex-col items-center gap-8">
                    <h1 className="text-4xl font-bold text-gray-900">Registro</h1>
                </div>
                <div className="my-8">
                    <p
                        className="text-center relative text-gray-500 bg-gray-100 before:max-w-[50px] md:before:max-w-[120px] before:w-full before:-left-[60px] md:before:-left-[140px] before:h-[1px] before:bg-current before:absolute before:top-[50%] after:max-w-[50px] md:after:max-w-[120px] after:w-full after:h-[1px] after:bg-current after:absolute after:top-[50%] after:-right-[60px] md:after:-right-[140px]">
                        Creación de cuenta
                    </p>
                </div>
                <div className="w-full mb-8">
                    <form @submit.prevent="submit">
                        <div className="flex justify-center mb-2">
                            <input type="text" v-model="form.name" required autofocus
                                className="w-full max-w-md py-2 px-4 rounded-lg outline-none" placeholder="Nombre" />

                        </div>
                        <div className="flex justify-center ">
                            <InputError class="" :message="form.errors.name" />

                        </div>
                        <div className="flex justify-center mb-2">
                            <input type="email" v-model="form.email" required
                                className="w-full max-w-md py-2 px-4 rounded-lg outline-none" placeholder="Correo"
                                autocomplete="username" />
                        </div>
                        <div className="flex justify-center ">

                            <InputError class="" :message="form.errors.email" />
                        </div>

                        <div className="flex justify-center mb-2">
                            <input type="password" v-model="form.password" required
                                className="w-full max-w-md py-2 px-4 rounded-lg outline-none" placeholder="Contraseña"
                                autocomplete="new-password" />
                        </div>
                        <div className="flex justify-center">
                            <InputError class="" :message="form.errors.password" />
                        </div>

                        <div className="flex justify-center mb-2">
                            <input type="password" v-model="form.password_confirmation" required
                                className="w-full max-w-md py-2 px-4 rounded-lg outline-none"
                                placeholder="Confirmar Contraseña" autocomplete="new-password" />

                        </div>
                        <div className="flex justify-center">

                            <InputError class="" :message="form.errors.password_confirmation" />
                        </div>



                        <div className="w-full max-w-md mx-auto">
                            <button type="submit"
                                className="w-full bg-gray-200 py-2 px-4 rounded-lg text-gray-900 hover:bg-gray-300 transition-colors">
                                Registrar
                            </button>
                        </div>
                    </form>
                </div>
                <div>
                    <span className="text-gray-500">
                        ¿Ya tienes una cuenta?
                        <Link :href="route('login')" class="text-gray-700 underline">
                        Iniciar Sesión
                        </Link>
                    </span>
                </div>
            </div>
            <div
                className="hidden lg:flex items-center justify-center border-t border-r border-b rounded-tr-lg rounded-br-lg">
                <img src="images/backgroundLoginRegister.jpg" className=" object-cover h-full" />

            </div>
        </div>
    </form>
</template>
