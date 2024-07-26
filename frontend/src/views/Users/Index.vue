<script setup>
import axios from 'axios';
import { ref, onMounted, nextTick } from 'vue';
import { confirmation, sendRequest } from '@/functions';
import { useAuthStore } from '@/stores/auth';
import Modal from '@/components/Modal.vue';
import Paginate from 'vuejs-paginate-next';
const authStore = useAuthStore();
axios.defaults.headers.common['Authorization'] = 'Bearer '+authStore.authToken;
onMounted( ()=> { getUsers(1) });
const users = ref([]);
const load = ref(false);
const readonly = ref(false);
const rows = ref(0);
const form = ref({ name:'',lastname:'',email:'',password:''});
const title = ref('');
const nameInput = ref('');
const operation = ref(1);
const id = ref('');
const close = ref([]);

const getUsers = async (page) =>{
    await axios.get('/api/users?page='+page).then(
        response => (
            users.value = response.data,
            rows.value = response.data.last_page
            ));
    load.value=true;
}
const deleteUser = (id,name) =>{
    confirmation(name,('/api/users/'+id),'/users');
}
const openModal = (op,name,lastname,email,password,user) =>{
    clear();
    setTimeout( ()=> nextTick( ()=> nameInput.value.focus()),600);
    operation.value = op;
    id.value = user;
    if (op == 1) {
        title.value = 'Mostrar Usuario';
        readonly.value=true;
        form.value.name = name;
        form.value.lastname = lastname;
        form.value.email = email;
        form.value.password = password;
    }
    else if (op == 2) {
        title.value = 'Crear Nuevo Usuario';
    }
    else if (op == 3){
        title.value = 'Actualizar Usuario';
        form.value.name = name;
        form.value.lastname = lastname;
        form.value.email = email;
        form.value.password = password;
    }
}
const clear = () =>{
        form.value.name = '';
        form.value.lastname = '';
        form.value.email = '';
        form.value.password = '';
}
const save = async ()=>{
    let res;
    if (operation.value == 1) {
        res = await sendRequest('GET',form.value, ('/api/users/'+id.value),'');
        if (res == true) {
            clear();
            nextTick( ()=> nameInput.value.focus());
            getUsers(1);
        }
    }else if (operation.value == 2) {
        res = await sendRequest('POST',form.value, '/api/users','');
        if (res == true) {
            clear();
            nextTick( ()=> nameInput.value.focus());
            getUsers(1);
        }
    }else if (operation.value == 3){
        res = await sendRequest('PUT',form.value, ('/api/users/'+id.value),'');
        if (res == true) {
            nextTick( ()=> close.value.click());
            getUsers(1);
        }
    }
}
</script>
<template>
    <div class="row mt-3">
        <div class="col-md-10 offset-md-1">
            <div class="card border border-white card-header text-center h4"> <strong>Lista de Usuarios</strong></div>
            <div class="card border border-white text-center" v-if="!load">
                <div class="card-body">
                    <img src="/loading.gif" class="img-fluid">
                </div>
            </div>
            <div class="table-responsive" v-else>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Creacion</th>
                            <th>Actualizacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="us,i in users.data" :key="us.id">
                            <td class="text-center">{{(i+1)}}</td>
                            <td>{{us.name}}</td>
                            <td>{{us.lastname}}</td>
                            <td>{{us.email}}</td>
                            <td class="text-center">{{new Date(us.created_at).toLocaleDateString({day,mont,year})}}</td>
                            <td class="text-center">{{new Date(us.updated_at).toLocaleDateString({day,mont,year})}}</td>
                            <td class="text-center">
                                <button class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#modal"
                                @click="openModal(1,us.name,us.lastname,us.email,us.password,us.id)">
                                    <i class="fa-solid fa-eye"></i>
                                </button> 
                                &nbsp;
                                <button class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#modal"
                                @click="openModal(3,us.name,us.lastname,us.email,us.password,us.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </button> 
                                &nbsp;
                                <button class="btn btn-danger" @click="deleteUser(us.id,us.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Paginate :page-count="rows" :click-handler="getUsers" :prev-text="'Anterior'" :next-text="'Siguiente'" :container-class="'pagination'"></Paginate>
            </div>
            <div class="card border border-light card-footer">
                    <div class="container-fluid">
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#modal" @click="openModal(2)">
                            <i class="fa-solid fa-circle-plus"></i> Nuevo Usuario
                        </button>
                    </div>
                </div>
        </div>
    </div>
    <Modal :id="'modal'" :title="title">
        <div class="modal-body">
            <form @submit.prevent="save">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-user"></i>    
                    </span>
                    <input autofocus type="text" v-model="form.name" :readonly="readonly.value" 
                    placeholder="Nombre" class="form-control" required ref="nameInput">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-user"></i>    
                    </span>
                    <input  type="text" v-model="form.lastname" :readonly="readonly.value"
                    placeholder="Apellido" class="form-control" >
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-at"></i>    
                    </span>
                    <input  type="email" v-model="form.email" :readonly="readonly.value"
                    placeholder="Correo Electronico" class="form-control" >
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-key"></i>    
                    </span>
                    <input type="password" v-model="form.password" :readonly="readonly.value"
                    placeholder="Contraseña" class="form-control" >
                </div>
                <div class="d-grid col-10 mx-auto" v-if="operation !== 1">
                    <button class="btn btn-success"><i class="fa-solid fa-save"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-dark" ref="close" data-bs-dismiss="modal">Close</button>
        </div>
    </Modal>
</template>