<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
const authStore = useAuthStore();
const form = ref({email:'',password:''});
</script>
<template>
    <div class="row mt-5">
        <div class="col-md-4 offset-md-4">
            <div class="card border border-dark">
                <div class="card-header bg-dark border border-dark text-white"> 
                    <h1 class="h3 mb-2 fw-normal text-center">Iniciar Sesion</h1>
                </div>
                <div class="card-body">
                    <form @submit.prevent="$event => authStore.login(form)" class="needs-validation" novalidate>
                        <div class="input-group mb-3 has-validation">
                            <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
                            <div class="form-floating">
                                <input autofocus type="email" v-model="form.email" class="form-control" id="email" placeholder="Correo Electronico">
                                <label for="email">Correo Electronico</label>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Por Favor Ingrese Su Usuario.
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3 has-validation">
                            <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                            <div class="form-floating">
                                <input autofocus type="password" v-model="form.password" class="form-control" id="password" placeholder="Contraseña">
                                <label for="password">Contraseña</label>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Por Favor Ingrese Su Contraseña.
                                </div>
                            </div>
                        </div>
                        <div class="d-grid col-10 mx-auto">
                            <button class="border border-dark btn btn-light">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template> 