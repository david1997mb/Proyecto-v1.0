<template>
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="table-responsive">
                <DataTable :data="users" :columns="columns" class="table table-striped table-bordered table-hover bg-white display"
                :options="{responsive:true, autoWidth:false, dom:'Bfrtip',language:{
                    search:'Buscar', zeroRecords:'No Hay Registros para Mostrar',
                    info:'Mostrando del _START_ a _END_ de _TOTAL_ registros',
                    infoFiltered: '(Filtrados de _MAX_ registros.)',
                    paginate:{first:'Primero',previous:'Anterior',next:'Siguiente',last:'Ultimo'}
                }, buttons: botones}">
                    <thead class="bg-white">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Creacion</th>
                            <th>Actualizacion</th>
                        </tr>
                    </thead>
                </DataTable>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import DataTable from 'datatables.net-vue3'
import DataTableLib from 'datatables.net-bs5'
import Buttons from 'datatables.net-buttons-bs5'
import ButtonsHtml5 from 'datatables.net-buttons/js/buttons.html5'
import print from 'datatables.net-buttons/js/buttons.print'
import pdfmake from 'pdfmake'
import pdfFonts from 'pdfmake/build/vfs_fonts';
pdfmake.vfs = pdfFonts.pdfMake.vfs;
import 'datatables.net-responsive-bs5';
import JSZip from 'jszip';
window.JSZip = JSZip;
DataTable.use(DataTableLib);
DataTable.use(pdfmake);
DataTable.use(ButtonsHtml5);
export default{
    components:{DataTable},
    data(){
        return{
            users:null,
            columns:[
                    {data:null,render: function(data,type,row,meta)
                    {return `${meta.row+1}`}},
                    {data:'name'},
                    {data:'lastname'},
                    {data:'email'},
                    {data: 'created_at',render: function(data, type, row) {
                            const createdAt = new Date(data);
                            return createdAt.toLocaleString();}},
                    {data: 'updated_at',render: function(data, type, row) {
                            const updatedAt = new Date(data);
                            return updatedAt.toLocaleString();}}
            ],
            botones:[
                {
                    title:'Reporte de Usuarios',
                    extend: 'pdfHtml5',
                    text: '<i class="fa-solid fa-file-pdf"></i> PDF',
                    className:'btn btn-danger'
                },
                {
                    title:'Reporte de Usuarios',
                    extend: 'excelHtml5',
                    text: '<i class="fa-solid fa-file-excel"></i> Excel',
                    className:'btn btn-success'
                },
                {
                    title:'Reporte de Usuarios',
                    extend: 'print',
                    text: '<i class="fa-solid fa-print"></i> Print',
                    className:'btn btn-secondary'
                },
                {
                    title:'Reporte de Usuarios',
                    extend: 'copy',
                    text: '<i class="fa-solid fa-copy"></i> Copiar Texto',
                    className:'btn btn-warning'
                }
            ]
        }
    },
    mounted(){
        this.getUsers();
    },
    methods:{
        getUsers(){
            axios.get('api/usersall').then(
                response =>(
                    this.users = response.data
                )
            );
        }
    }
}
</script>
<style scoped>
@import 'datatables.net-bs5';
/* Your custom styles for the table */
.table {
  width: 100%;
  font-size: 14px;
}

.table thead th {
  background-color: #f5f5f5;
  color: #333333;
  text-align: left;
}

.table tbody tr td {
  vertical-align: middle;
}

.table-responsive {
  overflow-x: auto;
}

</style>