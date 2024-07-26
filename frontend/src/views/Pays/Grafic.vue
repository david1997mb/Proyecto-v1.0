<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { Bar, Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement,
CategoryScale, LinearScale, ArcElement } from 'chart.js';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);
const authStore = useAuthStore();
axios.defaults.headers.common['Authorization'] = 'Bearer '+authStore.authToken;

const events = ref([]);
const pays = ref([]);
const chartData = ref([]);
const chartOptions = ref([]);
const colors = ref([]);
const loaded = ref(false);
const random = ()=>{
    return Math.floor(Math.random() * 256);
}

onMounted( async ()=>{
    const info = await axios.get('/api/paysbyevent');
    info.data.sort((a, b) => a.id - b.id);
    info.data.map((row)=>(
        // users.value.push(row.count),
        pays.value.push(row.count),
        events.value.push(row.type),
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
        labels:events.value,
        datasets:[
            {label: 'Clientes', data: pays.value, backgroundColor:colors}
        ]
    };
    loaded.value = true;
})
</script>
<template>
    <div class="container-fluid">
        <div class="col-md-8 offset-md-2 text-center">
            <h3 class="h3">Clientes por Usuario</h3>
            <Bar v-if="loaded" :data="chartData" :options="chartOptions"></Bar>
        </div>
    </div><br><hr>
    <div class="row mt-3">
        <div class="col-md-8 offset-md-3">
            <Pie v-if="loaded" :data="chartData" :options="chartOptions"></Pie>
        </div>
    </div>
</template>