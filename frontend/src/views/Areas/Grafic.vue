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
const areas = ref([]);
const chartData = ref([]);
const chartOptions = ref([]);
const colors = ref([]);
const loaded = ref(false);
const random = ()=>{
    return Math.floor(Math.random() * 256);
}

onMounted( async ()=>{
    const info = await axios.get('/api/areasbyevent');
    info.data.sort((a, b) => a.id - b.id);
    info.data.map((row)=>(
        events.value.push(row.count),
        areas.value.push(row.count),
        areas.value.push(`ID: ${row.id} , ${row.name} `),
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
        labels:areas.value,
        datasets:[
            {label: 'AREAS', data: areas.value, backgroundColor:colors}
        ]
    };
    loaded.value = true;
})
</script>
<template>
    <div class="container-fluid">
        <div class="col-md-8 offset-md-2">
            <Bar v-if="loaded" :data="chartData" :options="chartOptions"></Bar>
            <!-- <Pie v-if="loaded" :data="chartData" :options="chartOptions"></Pie> -->
        </div>
    </div>
</template>