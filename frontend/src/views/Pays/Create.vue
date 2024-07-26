<script setup>
import axios from 'axios'
import { ref, nextTick , onMounted } from 'vue'
import {show_alerta, sendRequest} from '../../functions'
import SelectInput from '@/components/SelectInput.vue'
onMounted( ()=> { getEvents() });
const form = ref({event_id:'',amount:'',pay_date:'',method:''});
const events = ref([]);
const clients = ref([]);

const getEvents = async () =>{
    await axios.get('/api/eventsall').then(
        response => (events.value = response.data));
}
// const getAreas = async () =>{
//     await axios.get('/api/areas?page=1').then(
//         response => (areas.value = response.data));
// }
const save=() =>{
        sendRequest('POST',form.value,'/api/events','');
        form.value.event_id='';
        form.value.amount='';
        form.value.pay_date='';
        form.value.method='';
}

</script>
<template>
<div class="row mt-5">
    <div class="col-md-10 offset-md-1">
        <div class="card border border-dark">
            <div class="card-header text-center bg-dark border border-dark text-white"><b class="h3">Insertar Nuevo Pago</b></div>
            <div class="card-body">
                    <form @submit.prevent="save">
                        &nbsp;<label for="client" class="form-label"><b>Evento </b></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="fa-solid fa-circle-user"></i>
                            </span>
                            <SelectInput v-model="form.event_id" :options="events"
                            class="form-select" required></SelectInput>
                        </div>
                        &nbsp;<label for="reserve_at" class="form-label"><b>Fecha de Reserva</b></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="fa-solid fa-calendar-days"></i>    
                            </span>
                            <input type="datetime-local" v-model="form.reserve_at"
                            placeholder="Fecha de Reserva" class="form-control">
                        </div>
                        &nbsp;<label for="type" class="form-label"><b>Tipo del Evento</b></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="fa-solid fa-building"></i>&nbsp;Evento
                            </span>
                            <select class="form-select" id="type" v-model="form.type" required>
                                <option value="Matrimonio">Matrimonio</option>
                                <option value="Cumpleaños">Cumpleaños</option>
                                <option value="Reuniones">Reuniones</option>
                                <option value="Bautizo">Bautizo</option>
                            </select>
                        </div>
                        &nbsp;<label for="event_date" class="form-label"><b>Fecha del Evento</b></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="fa-solid fa-calendar-days"></i>    
                            </span>
                            <input type="date" v-model="form.event_date"
                            placeholder="Fecha Del Evento" class="form-control" required>
                        </div>
                        &nbsp;<label for="guest" class="form-label"><b>Cantidad de Invitados</b></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="fa-solid fa-users"></i>    
                            </span>
                            <input type="number" v-model="form.guests"
                            placeholder="Invitados" class="form-control" >
                        </div>
                        &nbsp;<label for="cost" class="form-label"><b>Costo Total del Evento</b></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="fa-solid fa-sack-dollar"></i>    
                            </span>
                            <input type="number" v-model="form.cost"
                            placeholder="Costo" class="form-control" >
                        </div>
                        &nbsp;<label for="status" class="form-label"><b>Estado de Pago del Evento</b></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="fa-solid fa-circle-exclamation"></i>    
                            </span>
                            <select class="form-select" id="status" v-model="form.status">
                                <option value="Pagando">Pagando</option>
                                <option value="Cancelado">Cancelado</option>
                                <option value="Completo">Completo</option>
                            </select>
                        </div>
                       
                        <div class="d-grid col-10 mx-auto">
                            <button class="btn btn-success"><i class="fa-solid fa-save"></i>&nbsp;Save</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
</template>
