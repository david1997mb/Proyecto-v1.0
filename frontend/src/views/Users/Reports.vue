<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '@/stores/auth';
import SelectInput from '@/components/SelectInput.vue';
import DataTable from 'datatables.net-vue3';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import ButtonsHtml5 from 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-responsive-dt';
import 'datatables.net-responsive-dt/css/responsive.dataTables.min.css';
import JSZip from 'jszip';
import pdfmake from "pdfmake/build/pdfmake";
import * as pdfFonts from "pdfmake/build/vfs_fonts";
pdfmake.vfs = pdfFonts.pdfMake ? pdfFonts.pdfMake.vfs : pdfmake.vfs;
window.JSZip = JSZip;
DataTable.use(ButtonsHtml5);
const authStore = useAuthStore();
axios.defaults.headers.common['Authorization'] = 'Bearer '+authStore.authToken;

const users = ref([]);
const clients = ref([]);
const events = ref([]);
const pays = ref([]);
const areas = ref([]);
const columns1 = ref([]);
const columns2 = ref([]);
const columns3 = ref([]);
const columns4 = ref([]);
const columns5 = ref([]);
const buttons1 = ref([]);
const buttons2 = ref([]);
const buttons3 = ref([]);
const buttons4 = ref([]);
const buttons5 = ref([]);
const report = ref('1');
const types = ref([
    {'id':'1','name':'Usuarios'},
    {'id':'2','name':'Clientes'},
    {'id':'3','name':'Eventos'},
    {'id':'4','name':'Pagos'},
    {'id':'5','name':'Areas'}]);

onMounted( async() =>{
    const u = await axios.get('/api/usersall');
    users.value = u.data;
    const c = await axios.get('/api/clientsall');
    clients.value = c.data;
    const e = await axios.get('/api/eventsall');
    events.value = e.data;
    const p = await axios.get('/api/paysall');
    pays.value = p.data;
    const a = await axios.get('/api/areasall');
    areas.value = a.data;
});

columns1.value = [{data:null,render:function(data,type,row,meta)
    {return (meta.row+1)}},
    {data:'name'},
    {data:'lastname'},
    {data:'email'},
    { 
        data: 'created_at',
        render: function(data, type, row) {
            const createdAt = new Date(data);
            return createdAt.toLocaleString();
        }
    },
    { 
        data: 'updated_at',
        render: function(data, type, row) {
            const updatedAt = new Date(data);
            return updatedAt.toLocaleString();
        }}
];
columns2.value = [{data:null,render:function(data,type,row,meta)
    {return (meta.row+1)}},
    {data:'user'},
    {data:'name'},
    {data:'lastname'},
    {data:'email'},
    {data:'phone'},
    {data:'address'},
    { 
        data: 'created_at',
        render: function(data, type, row) {
            const createdAt = new Date(data);
            return createdAt.toLocaleString();
        }
    },
    { 
        data: 'updated_at',
        render: function(data, type, row) {
            const updatedAt = new Date(data);
            return updatedAt.toLocaleString();
        }}
];
columns3.value = [{data:null,render:function(data,type,row,meta)
    {return (meta.row+1)}},
    {data:'user'},
    {data:'client'},
    {data:'reserve_at'},
    {data:'type'},
    {data:'event_date'},
    {data:'guests'},
    {data:'cost'},
    {data:'status'},
    { 
        data: 'created_at',
        render: function(data, type, row) {
            const createdAt = new Date(data);
            return createdAt.toLocaleString();
        }
    },
    { 
        data: 'updated_at',
        render: function(data, type, row) {
            const updatedAt = new Date(data);
            return updatedAt.toLocaleString();
        }}
];
columns4.value = [{data:null,render:function(data,type,row,meta)
    {return (meta.row+1)}},
    {data:'event'},
    {data:'amount'},
    {data:'pay_date'},
    {data:'method'},
    { 
        data: 'created_at',
        render: function(data, type, row) {
            const createdAt = new Date(data);
            return createdAt.toLocaleString();
        }
    },
    { 
        data: 'updated_at',
        render: function(data, type, row) {
            const updatedAt = new Date(data);
            return updatedAt.toLocaleString();
        }}
];
columns5.value = [{data:null,render:function(data,type,row,meta)
    {return (meta.row+1)}},
    {data:'name'},
    { 
        data: 'created_at',
        render: function(data, type, row) {
            const createdAt = new Date(data);
            return createdAt.toLocaleString();
        }
    },
    { 
        data: 'updated_at',
        render: function(data, type, row) {
            const updatedAt = new Date(data);
            return updatedAt.toLocaleString();
        }}
];
buttons1.value = [
    {
        title:'Usuarios', extend:'excelHtml5',
        text:'<i class="fa-solid fa-file-excel"></i> EXCEL',
        className:'btn btn-success'
    },
    {
        title:'Usuarios', extend:'pdfHtml5',
        text:'<i class="fa-solid fa-file-pdf"></i> PDF',
        className:'btn btn-danger'
    },
    {
        title:'Usuarios', extend:'print',
        text:'<i class="fa-solid fa-print"></i> PRINT',
        className:'btn btn-dark'
    },
    {
        title:'Usuarios', extend:'copy',
        text:'<i class="fa-solid fa-copy"></i> COPY',
        className:'btn btn-secondary'
    }
];
buttons2.value = [
    {
        title:'Clientes', extend:'excelHtml5',
        text:'<i class="fa-solid fa-file-excel"></i> EXCEL',
        className:'btn btn-success'
    },
    {
        title:'Clientes', extend:'pdfHtml5',
        text:'<i class="fa-solid fa-file-pdf"></i> PDF',
        className:'btn btn-danger'
    },
    {
        title:'Clientes', extend:'print',
        text:'<i class="fa-solid fa-print"></i> PRINT',
        className:'btn btn-dark'
    },
    {
        title:'Clientes', extend:'copy',
        text:'<i class="fa-solid fa-copy"></i> COPY',
        className:'btn btn-secondary'
    }
];
buttons3.value = [
    {
        title:'Eventos', extend:'excelHtml5',
        text:'<i class="fa-solid fa-file-excel"></i> EXCEL',
        className:'btn btn-success'
    },
    {
        title:'Eventos', extend:'pdfHtml5',
        text:'<i class="fa-solid fa-file-pdf"></i> PDF',
        className:'btn btn-danger'
    },
    {
        title:'Eventos', extend:'print',
        text:'<i class="fa-solid fa-print"></i> PRINT',
        className:'btn btn-dark'
    },
    {
        title:'Eventos', extend:'copy',
        text:'<i class="fa-solid fa-copy"></i> COPY',
        className:'btn btn-secondary'
    }
];
buttons4.value = [
    {
        title:'Pagos', extend:'excelHtml5',
        text:'<i class="fa-solid fa-file-excel"></i> EXCEL',
        className:'btn btn-success'
    },
    {
        title:'Pagos', extend:'pdfHtml5',
        text:'<i class="fa-solid fa-file-pdf"></i> PDF',
        className:'btn btn-danger'
    },
    {
        title:'Pagos', extend:'print',
        text:'<i class="fa-solid fa-print"></i> PRINT',
        className:'btn btn-dark'
    },
    {
        title:'Pagos', extend:'copy',
        text:'<i class="fa-solid fa-copy"></i> COPY',
        className:'btn btn-secondary'
    }
];
buttons5.value = [
    {
        title:'Areas', extend:'excelHtml5',
        text:'<i class="fa-solid fa-file-excel"></i> EXCEL',
        className:'btn btn-success'
    },
    {
        title:'Areas', extend:'pdfHtml5',
        text:'<i class="fa-solid fa-file-pdf"></i> PDF',
        className:'btn btn-danger'
    },
    {
        title:'Areas', extend:'print',
        text:'<i class="fa-solid fa-print"></i> PRINT',
        className:'btn btn-dark'
    },
    {
        title:'Areas', extend:'copy',
        text:'<i class="fa-solid fa-copy"></i> COPY',
        className:'btn btn-secondary'
    }
];
</script>

<template>
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            Reportes:
            <SelectInput id="rep" class="mt-1" v-model="report" :options="types">
            </SelectInput>
        </div>
    </div>
    <div class="row mb-3" v-if="report == '1'">
    <div class="col-md-8 offset-md-2">
      <div class="table-responsive">
        <DataTable :data="users" :columns="columns1" class="table table-bordered table-striped table-hover display"
          :options="{  
            dom: 'Bftip',
            responsive: true,
            select: true, 
            buttons: buttons1
            }">
          <thead class="table-dark">
            <tr class="text-center">
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Creacion</th>
                            <th>Edicion</th>
                        </tr>
                    </thead>
                </DataTable>
            </div>
        </div>
    </div>
    <div class="row" v-if="report == '2'">
        <div class="col-md-8 offset-md-2">
            <div class="table-responsive"  >
                <DataTable :data="clients" :columns="columns2" class="display table table-bordered table-hover"
                :options="{responsive:true, autoWidth:true, dom:'Bfrtip', buttons:buttons2}">
                <thead class="table-dark">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Creacion</th>
                        </tr>
                    </thead>
                </DataTable>
            </div>
        </div>
    </div>
    <div class="row" v-if="report == '3'">
        <div class="col-md-8 offset-md-2">
            <div class="table-responsive"  >
                <DataTable :data="events" :columns="columns3" class="display table table-bordered table-hover"
                :options="{responsive:true, autoWidth:true, dom:'Bfrtip', buttons:buttons3}">
                <thead class="table-dark">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Cliente</th>
                            <th>Reserva</th>
                            <th>Evento</th>
                            <th>Fecha</th>
                            <th>N° In.</th>
                            <th>Costo</th>
                            <th>Estado</th>
                            <th>Creacion</th>
                        </tr>
                    </thead>
                </DataTable>
            </div>
        </div>
    </div>
    <div class="row" v-if="report == '4'">
        <div class="col-md-8 offset-md-2">
            <div class="table-responsive"  >
                <DataTable :data="pays" :columns="columns4" class="display table table-bordered table-hover"
                :options="{responsive:true, autoWidth:true, dom:'Bfrtip', buttons:buttons4}">
                <thead class="table-dark">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Event</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Metodo</th>
                            <th>Creacion</th>
                            <th>Actualizado</th>
                        </tr>
                    </thead>
                </DataTable>
            </div>
        </div>
    </div>
    <div class="row" v-if="report == '5'">
        <div class="col-md-8 offset-md-2">
            <div class="table-responsive"  >
                <DataTable :data="areas" :columns="columns5" class="display table table-bordered table-hover"
                :options="{responsive:true, autoWidth:true, dom:'Bfrtip', buttons:buttons5}">
                <thead class="table-dark">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nombre Area</th>
                            <th>Creacion</th>
                            <th>Actualizado</th>
                        </tr>
                    </thead>
                </DataTable>
            </div>
        </div>
    </div>
</template>
