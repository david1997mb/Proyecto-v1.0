<script setup>
import axios from 'axios';
import { ref, onMounted, nextTick } from 'vue';
import { confirmation, sendRequest } from '@/functions';
import { useAuthStore } from '@/stores/auth';
import Modal from '@/components/Modal.vue';
import Paginate from 'vuejs-paginate-next';
const authStore = useAuthStore();
axios.defaults.headers.common['Authorization'] = 'Bearer '+authStore.authToken;
onMounted( ()=> { getClients(1), getUsers() });
const users = ref([]);
const clients = ref([]);
const load = ref(false);
const readonly = ref(false);
const rows = ref(0);
const form = ref({ user_id:'', name:'', lastname:'', email:'', phone:'', address:''});
const title = ref('');
const nameInput = ref('');
const operation = ref(1);
const id = ref('');
const close = ref([]);

const getClients = async (page) =>{
    await axios.get('/api/clients?page='+page).then(
        response => (
            clients.value = response.data,
            rows.value = response.data.last_page
            ));
    load.value=true;
}
const getUsers = async () =>{
    await axios.get('/api/usersall').then(
        response => (users.value = response.data));
    load.value=true;
}
const deleteClient = (id,name) =>{
    confirmation(name,('/api/clients/'+id),'/clients');
}
const openModal = (op,user,name,lastname,email,phone,address,client) =>{
    clear();
    setTimeout( ()=> nextTick( ()=> nameInput.value.focus()),600);
    operation.value = op;
    id.value = client;
    if (op == 1) {
        title.value = 'Mostrar Cliente';
        readonly.value=true;
        form.value.user_id = user;
        form.value.name = name;
        form.value.lastname = lastname;
        form.value.email = email;
        form.value.phone = phone;
        form.value.address = address;
     }
    else if (op == 2) {
        title.value = 'Crear Nuevo Cliente';
        form.value.user_id = user;
    }
    else if (op == 3){
        title.value = 'Actualizar Cliente';
        form.value.user_id = user;
        form.value.name = name;
        form.value.lastname = lastname;
        form.value.email = email;
        form.value.phone = phone;
        form.value.address = address;
    }
}
const clear = () =>{
        form.value.user_id = '';
        form.value.name = '';
        form.value.lastname = '';
        form.value.email = '';
        form.value.phone = '';
        form.value.address = '';
}
const save = async ()=>{
    let res;
     if (operation.value == 2) {
        res = await sendRequest('POST',form.value, '/api/clients','');
        if (res == true) {
            clear();
            nextTick( ()=> nameInput.value.focus());
            getClients(1);
        }
    }else if (operation.value == 3){
        res = await sendRequest('PUT',form.value, ('/api/clients/'+id.value),'');
        if (res == true) {
            nextTick( ()=> close.value.click());
            getClients(1);
        }
    }
}
</script>
<template>
    <div class="row mt-3">
        <div class="col-md-12 offset-md-0">
            <div class="card border border-white card-header bg-white text-center h4"> <strong>Lista de Clientes</strong></div>
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
                            <th>Usuario</th>
                            <th>Nombre Cliente</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Creacion</th>
                            <th>Actualizar</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="cli,i in clients.data" :key="cli.id">
                            <td class="text-center">{{(i+1)}}</td>
                            <td>{{cli.username}}</td>
                            <td>{{cli.name + ' '+cli.lastname}}</td>
                            <td>{{cli.email}}</td>
                            <td>{{cli.phone}}</td>
                            <td>{{cli.address}}</td>
                            <td class="text-center">{{new Date(cli.created_at).toLocaleDateString({day,mont,year})}}</td>
                            <td class="text-center">{{new Date(cli.updated_at).toLocaleDateString({day,mont,year})}}</td>
                            <td class="text-center">
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modal"
                                @click="openModal(1,cli.username,cli.name,cli.lastname,cli.email,cli.phone,cli.address,cli.id)">
                                    <i class="fa-solid fa-eye"></i>
                                </button> 
                                &nbsp;
                                <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modal"
                                @click="openModal(3, authStore.user.id,cli.name,cli.lastname,cli.email,cli.phone,cli.address,cli.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </button> 
                                &nbsp;
                                <button class="btn btn-outline-danger btn-sm" @click="deleteClient(cli.id,cli.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Paginate :page-count="rows" :click-handler="getClients" :prev-text="'Anterior'" :next-text="'Siguiente'" :container-class="'pagination'"></Paginate>
            </div>
            <div class="card border border-light card-footer bg-white">
                    <div class="container-fluid">
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modal" @click="openModal(2,authStore.user.id)">
                            <i class="fa-solid fa-circle-plus"></i>Insertar Nuevo Cliente
                        </button>
                    </div>
                </div>
        </div>
    </div>
    <Modal :id="'modal'" :title="title">
        <div class="modal-body">
            <form @submit.prevent="save">
                &nbsp;<label for="user" class="form-label"><b>Nombre Administrador</b></label>
                <div class="input-group mb-3" v-if="operation !== 2">
                    <span class="input-group-text">
                        <i class="fa-solid fa-user"></i>    
                    </span>
                    <input autofocus type="text" v-model="form.user_id" 
                    placeholder="Usuario" class="form-control" readonly>
                </div>
                &nbsp;<label for="name" class="form-label"><b>Nombre Cliente</b></label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-circle-user"></i>    
                    </span>
                    <input autofocus type="text" v-model="form.name" :readonly="readonly.value" 
                    placeholder="Nombre" class="form-control" required ref="nameInput">
                </div>
                &nbsp;<label for="lastname" class="form-label"><b>Apellido Cliente</b></label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-regular fa-circle-user"></i>    
                    </span>
                    <input autofocus type="text" v-model="form.lastname" :readonly="readonly.value" 
                    placeholder="Apellido" class="form-control" required>
                </div>
                &nbsp;<label for="email" class="form-label"><b>Correo del Cliente</b></label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-at"></i>    
                    </span>
                    <input autofocus type="email" v-model="form.email" :readonly="readonly.value" 
                    placeholder="Correo Electronico" class="form-control" required>
                </div>
                &nbsp;<label for="phone" class="form-label"><b>Telefono del Cliente</b></label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-building"></i>    
                    </span>
                    <input autofocus type="text" v-model="form.phone" :readonly="readonly.value" 
                    placeholder="Telefono" class="form-control" required >
                </div>
                &nbsp;<label for="address" class="form-label"><b>Direccion del Cliente</b></label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-location-dot"></i>    
                    </span>
                    <input autofocus type="text" v-model="form.address" :readonly="readonly.value" 
                    placeholder="Direccion" class="form-control" required>
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