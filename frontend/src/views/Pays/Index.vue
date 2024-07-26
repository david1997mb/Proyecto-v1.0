<script setup>
import axios from 'axios';
import { ref, onMounted, nextTick } from 'vue';
import { confirmation, sendRequest } from '@/functions';
import { useAuthStore } from '@/stores/auth';
import Modal from '@/components/Modal.vue';
import SelectInput from '@/components/SelectInput.vue';
import Paginate from 'vuejs-paginate-next';
const authStore = useAuthStore();
axios.defaults.headers.common['Authorization'] = 'Bearer '+authStore.authToken;
onMounted( ()=> { getPays(1), getEvents()});
const pays = ref([]);
const events = ref([]);
const load = ref(false);
const readonly = ref(false);
const rows = ref(0);
const form = ref({event_id:'', amount:'', pay_date:'', method:''});
const title = ref('');
const nameInput = ref('');
const operation = ref(1);
const id = ref('');
const close = ref([]);
const date=ref('');

const getPays = async (page) =>{
    await axios.get('/api/pays?page='+page).then(
        response => (
            pays.value = response.data,
            rows.value = response.data.last_page,
            date.value = new Date().toLocaleString()
            ));
    load.value=true;
    console.log(date.value);
}
const getEvents = async () =>{
    await axios.get('/api/eventsall').then(
        response => (events.value = response.data));
    load.value=true;
}
const deletePay = (id,name) =>{
    confirmation(name,('/api/pays/'+id),'/pays');
}
const openModal = (op,event_id,amount,pay_date,method,pay) =>{
    clear();
    setTimeout( ()=> nextTick( ()=> nameInput.value.focus()),600);
    operation.value = op;
    id.value = pay;
    if (op == 1) {
        title.value = 'Mostrar Pago';
        readonly.value=true;
        form.value.event_id = event_id;
        form.value.amount = amount;
        form.value.pay_date = pay_date;
        form.value.method = method;
     }
    else if (op == 2) {
        title.value = 'Insertar Pago';
        form.pay_date = date.value
    }
    else if (op == 3){
        title.value = 'Actualizar Pago';
        form.value.event_id = event_id;
        form.value.amount = amount;
        form.value.pay_date = pay_date;
        form.value.method = method;
    }
}
const clear = () =>{
        form.value.event_id = '';
        form.value.amount = '';
        form.value.pay_date = '';
        form.value.method = '';
}
const save = async ()=>{
    let res;
     if (operation.value == 2) {
        res = await sendRequest('POST',form.value, '/api/pays','/events');
        if (res == true) {
            clear();
            nextTick( ()=> nameInput.value.focus());
            getPays(1);
        }
    }else if (operation.value == 3){
        res = await sendRequest('PUT',form.value, ('/api/pays/'+id.value),'');
        if (res == true) {
            nextTick( ()=> close.value.click());
            getPays(1);
        }
    }
}
</script>
<template>
    <div class="row mt-3">
        <div class="col-md-12 offset-md-0">
            <div class="card border border-white card-header text-center h4"> <strong>Lista de Pagos</strong></div>
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
                            <th>Event</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Metodo</th>
                            <th>Creacion</th>
                            <th>Actualizado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="pa,i in pays.data" :key="pa.id">
                            <td class="text-center">{{(i+1)}}</td>
                            <td>{{pa.event}}</td>
                            <td>{{pa.amount+' BS.'}}</td>
                            <td class="text-center">{{new Date(pa.pay_date).toLocaleDateString({day,mont,year})}}</td>
                            <td>{{pa.method}}</td>
                            <td class="text-center">{{new Date(pa.created_at).toLocaleDateString({day,mont,year})}}</td>
                            <td class="text-center">{{new Date(pa.updated_at).toLocaleDateString({day,mont,year})}}</td>
                            <td class="text-center">
                                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modal"
                                @click="openModal(1,pa.event,pa.amount,pa.pay_date,pa.method,pa.id)">
                                    <i class="fa-solid fa-eye"></i>
                                </button> 
                                &nbsp;
                                <button class="btn btn-light btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modal"
                                @click="openModal(3,pa.event,pa.amount,pa.pay_date,pa.method,pa.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </button> 
                                &nbsp;
                                <button class="btn btn-danger btn-sm" @click="deletePay(pa.id)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Paginate :page-count="rows" :click-handler="getPays" :prev-text="'Anterior'" :next-text="'Siguiente'" :container-class="'pagination'"></Paginate>
            </div>
            <div class="card border border-light card-footer">
                    <div class="container-fluid">
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#modal" @click="openModal(2)">
                            <i class="fa-solid fa-circle-plus"></i> Nuevo Pago
                        </button>
                    </div>
                </div>
        </div>
    </div>
    <Modal :id="'modal'" :title="title">
        <div class="modal-body">
            <form @submit.prevent="save">
                <div class="input-group mb-3" >
                    <span class="input-group-text">
                        <i class="fa-solid fa-champagne-glasses"></i>   
                    </span>
                    <SelectInput v-model="form.event_id" :options="events"
                    class="form-select" required></SelectInput>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-sack-dollar"></i>    
                    </span>
                    <input autofocus type="number" v-model="form.amount" 
                    placeholder="Monto A Pagar" class="form-control" ref="nameInput">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-calendar"></i>    
                    </span>
                    <input type="datetime-local"  v-model="form.pay_date"
                   placeholder="Fecha Pago" class="form-control" >
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-circle-check"></i>    
                    </span>
                    <select class="form-select" id="type" v-model="form.method">
                        <option selected>Seleccione Metodo de Pago</option><hr>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Deposito">Deposito</option>
                        <option value="Tarjeta">Tarjeta</option>
                    </select>
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