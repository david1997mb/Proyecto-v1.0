<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { Bar, Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement,
CategoryScale, LinearScale, ArcElement } from 'chart.js';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);
const authStore = useAuthStore();
axios.defaults.headers.common['Authorization'] = 'Bearer '+authStore.authToken;

const users = ref([]);
const clients = ref([]);
const chartData = ref([]);
const chartOptions = ref([]);
const colors = ref([]);
const loaded = ref(false);
const random = ()=>{
    return Math.floor(Math.random() * 256);
}

onMounted( async ()=>{
    const info = await axios.get('/api/clientsbyuser');
    info.data.sort((a, b) => a.id - b.id);
    info.data.map((row)=>(
        users.value.push(row.name),
        clients.value.push(row.count),
        colors.value.push("rgb("+random()+","+random()+","+random()+")")
    ));
    chartOptions.value = { responsive: true,
        font: {
        family: 'Roboto',
        size: 10,
        weight: 'bold',
        style: 'italic',
    },};
    chartData.value = {
        labels:users.value,
        datasets:[
            {label: 'Clientes', data: clients.value, backgroundColor:colors}
        ]
    };
    loaded.value = true;
})
</script>
<template>
    <div class="container-fluid bg-white">
        <div class="col-md-6 offset-md-3 text-center">
            <h3 class="h3">Clientes por Usuario</h3>
            <Bar v-if="loaded" :data="chartData" :options="chartOptions"></Bar>
        </div>
        <div class="row bg-white">
            <div class="col-md-4 offset-md-4">
                <Pie v-if="loaded" :data="chartData" :options="chartOptions"></Pie>
            </div>
        </div>
    </div><br><hr>
</template>