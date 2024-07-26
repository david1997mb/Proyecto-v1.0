<script setup>
import axios from 'axios';
import { ref, onMounted, nextTick } from 'vue';
import { confirmation, sendRequest } from '@/functions';
import { useAuthStore } from '@/stores/auth';
import Modal from '@/components/Modal.vue';
import Paginate from 'vuejs-paginate-next';
const authStore = useAuthStore();
axios.defaults.headers.common['Authorization'] = 'Bearer '+authStore.authToken;
onMounted( ()=> { getAreas(1) });
const Areas = ref([]);
const load = ref(false);
const readonly = ref(false);
const rows = ref(0);
const form = ref({ name:''});
const title = ref('');
const nameInput = ref('');
const operation = ref(1);
const id = ref('');
const close = ref([]);

const getAreas = async (page) =>{
    await axios.get('/api/areas?page='+page).then(
        response => (
            Areas.value = response.data,
            rows.value = response.data.last_page
            ));
    load.value=true;
}
const deletearea = (id,name) =>{
    confirmation(name,('/api/areas/'+id),'/areas');
}
const openModal = (op,name,area) =>{
    clear();
    setTimeout( ()=> nextTick( ()=> nameInput.value.focus()),600);
    operation.value = op;
    id.value = area;
    if (op == 1) {
        title.value = 'Mostrar Area';
        readonly.value=true;
        form.value.name = name;
    }
    else if (op == 2) {
        title.value = 'Crear Nuevo Area';
    }
    else if (op == 3){
        title.value = 'Actualizar Area';
        form.value.name = name;
    }
}
const clear = () =>{
        form.value.name = '';
}
const save = async ()=>{
    let res;
     if (operation.value == 2) {
        res = await sendRequest('POST',form.value, '/api/areas','');
        if (res == true) {
            clear();
            nextTick( ()=> nameInput.value.focus());
            getAreas(1);
        }
    }else if (operation.value == 3){
        res = await sendRequest('PUT',form.value, ('/api/areas/'+id.value),'');
        if (res == true) {
            nextTick( ()=> close.value.click());
            getAreas(1);
        }
    }
}
</script>
<template>
    <div class="row mt-3">
        <div class="col-md-10 offset-md-1">
            <div class="card border border-white card-header text-center h4"> <strong>Lista de Areas</strong></div>
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
                            <th>Nombre Area</th>
                            <th>Creacion</th>
                            <th>Actualizado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="are,i in Areas.data" :key="are.id">
                            <td class="text-center">{{(i+1)}}</td>
                            <td>{{are.name}}</td>
                            <td class="text-center">{{new Date(are.created_at).toLocaleDateString({day,mont,year})}}</td>
                            <td class="text-center">{{new Date(are.updated_at).toLocaleDateString({day,mont,year})}}</td>
                            <td class="text-center">
                                <button class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#modal"
                                @click="openModal(1,are.name,are.id)">
                                    <i class="fa-solid fa-eye"></i>
                                </button> 
                                &nbsp;
                                <button class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#modal"
                                @click="openModal(3,are.name,are.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </button> 
                                &nbsp;
                                <button class="btn btn-danger" @click="deletearea(are.id,are.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Paginate :page-count="rows" :click-handler="getAreas" :prev-text="'Anterior'" :next-text="'Siguiente'" :container-class="'pagination'"></Paginate>
            </div>
            <div class="card border border-light card-footer">
                    <div class="container-fluid">
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#modal" @click="openModal(2)">
                            <i class="fa-solid fa-circle-plus"></i> Nueva Area
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
                        <i class="fa-solid fa-building"></i>    
                    </span>
                    <input autofocus type="text" v-model="form.name" :readonly="readonly.value" 
                    placeholder="Name" class="form-control" required ref="nameInput">
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