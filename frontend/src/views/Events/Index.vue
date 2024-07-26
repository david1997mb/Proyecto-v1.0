<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { confirmation } from '@/functions';
import { useAuthStore } from '@/stores/auth';
import Paginate from 'vuejs-paginate-next';
import Modal from '@/components/Modal.vue';
const authStore = useAuthStore();
axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;
onMounted(() => {
    getEvents(1);
    getAreas();
    getClients();
});
const events = ref([]);
const areas = ref([]);
const clients = ref([]);
const load = ref(false);
const rows = ref(0);
const title = ref('');
const close = ref([]);
const eventData = ref(null);
const clientData = ref(null);

const openEventModal = async (event) => {
    try {
        const response = await axios.get(`/api/events/${event}`);
        eventData.value = response.data.data;
        clientData.value = response.data.data.client;
        title.value = 'Detalles del Evento';
        close.value.push('eventModal');
        console.log(clientData.value);
    } catch (error) {
        console.error('Error al obtener los datos del evento:', error);
    }
}

const getEvents = async (page) => {
    await axios.get('/api/events?page=' + page).then(response => {
        events.value = response.data;
        rows.value = response.data.last_page;
    });
    load.value = true;
}
const getClients = async () => {
    await axios.get('/api/clientsall').then(response => {
        clients.value = response.data;
    });
    load.value = true;
}
const getAreas = async () => {
    await axios.get('/api/areas?page=1').then(response => {
        areas.value = response.data;
    });
    load.value = true;
}
const deleteEvents = (id, type, client) => {
    const datos = type + ' de ' + client;
    confirmation(datos, ('/api/events/' + id), '/events');
}
const clearFields = () => {
    eventData.value = null;
    clientData.value = null;
}
</script>
<template>
    <div class="row mt-3">
        <div class="col-md-10 offset-md-1">
            <div class="card card-header bg-dark text-white text-center h2"> Lista de Eventos</div>
            <div class="card border border-dark text-center" v-if="!load">
                <div class="card-body">
                    <img src="/loading.gif" alt="loading img" class="img-fluid">
                </div>
            </div>
            <div class="table-responsive" v-else>
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Cliente</th>
                            <th>Reserva</th>
                            <th>Evento</th>
                            <th>Fecha</th>
                            <th>Invitados</th>
                            <th>Costo</th>
                            <th>Estado</th>
                            <th>Saldo Restante</th>
                            <th>Creación</th>
                            <th>Actualización</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="(eve, i) in events.data" :key="eve.id">
                            <td>{{ (i + 1) }}</td>
                            <td>{{ eve.user }}</td>
                            <td>{{ eve.client }}</td>
                            <td>{{ eve.reserve_at }}</td>
                            <td>{{ eve.type }}</td>
                            <td>{{ eve.event_date }}</td>
                            <td>{{ eve.guests }}</td>
                            <td>{{ eve.cost }}</td>
                            <td>{{ eve.status }}</td>
                            <td>{{parseInt(eve.saldo)+' BS.'}}</td>
                            <td class="text-center">{{ new Date(eve.created_at).toLocaleDateString({ day, mont, year })
                                }}</td>
                            <td class="text-center">{{ new Date(eve.updated_at).toLocaleDateString({ day, mont, year })
                                }}</td>
                            <td>
                                <button @click="openEventModal(eve.id)" class="btn btn-outline-secondary btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#modal">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                &nbsp;&nbsp;
                                <router-link :to="{path:'events/edit/'+eve.id}" 
                                    class="btn btn-outline-warning btn-sm"
                                    v-if="eve.status !== 'Completado'">
                                    <i class="fa-solid fa-edit"></i>
                                </router-link>
                                &nbsp;&nbsp;
                                <button class="btn btn-outline-danger btn-sm" 
                                    @click="deleteEvents(eve.id, eve.type, eve.client)"
                                    v-if="eve.status !== 'Completado'">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Paginate :page-count="rows" :click-handler="getEvents" :prev-text="'Anterior'" :next-text="'Siguiente'" :container-class="'pagination'"></Paginate>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="d-grid col-10 mx-auto ">
                <router-link to="/events/create" class="bg-primary btn btn-outline-light btn">
                    <i class="fa-solid fa-circle-plus"></i>&nbsp;&nbsp;Insertar Nuevo Evento
                </router-link>
            </div>
        </div>
    </div>
    <Modal :id="'modal'" :title="title" @hidden="clearFields" class="modal-lg">
        <div class="modal-body">
            <h4><b>ID evento:</b>&nbsp;&nbsp;{{ eventData ? eventData.id : '' }}</h4><br>
            <h4><b>Usuario:</b>&nbsp;&nbsp;{{ eventData ? clientData.user.name : '' }}</h4><br>
            <h4><b>Cliente:</b>&nbsp;&nbsp;{{ clientData ? clientData.name : '' }}</h4><br>
            <h4><b>Reserva:</b>&nbsp;&nbsp;{{ eventData ? eventData.reserve_at : '' }}</h4><br>
            <h4><b>Tipo Evento:</b>&nbsp;&nbsp;{{ eventData ? eventData.type : '' }}</h4><br>
            <h4><b>Fecha Evento:</b>&nbsp;&nbsp;{{ eventData ? eventData.event_date : '' }}</h4><br>
            <h4><b>Invitados:</b>&nbsp;&nbsp;{{ eventData ? eventData.guests : '' }}</h4><br>
            <h4><b>Costo Evento:</b>&nbsp;&nbsp;{{ eventData ? eventData.cost : '' }}</h4><br>
            <h4><b>Estado Pago:</b>&nbsp;&nbsp;{{ eventData ? eventData.status : '' }}</h4><br>
            <h4><b>Saldo Restante:</b>&nbsp;&nbsp;{{ eventData ? eventData.saldo : '' }} BS.</h4><br>
            <div v-if="eventData && eventData.areas">
                <h4><b>Areas:</b></h4>
                <ul>
                    <li v-for="area in eventData.areas" :key="area.id" class="h4">
                        {{ area.name }}
                    </li>
                </ul>
            </div>
            <div v-if="eventData && eventData.pays">
                <h4><b>Pagos:</b></h4>
                <ul>
                    <li v-for="pay,i in eventData.pays" :key="pay.id" class="h4">
                        Numero Pagos: {{ i+1 }} <br>
                        Monto pagado: {{ pay.amount }} Bs.<br>
                        Fecha Pago: {{ pay.pay_date }}<br>
                        Metodo Pago: {{ pay.method }}<br>
                    </li>
                </ul>
            </div>
        </div>
    </Modal>
</template>