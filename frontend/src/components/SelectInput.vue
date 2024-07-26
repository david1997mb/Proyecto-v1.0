<script setup>
import { onMounted,ref } from 'vue';

defineProps(['modelValue','options']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() =>{
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: ()=> input.value.focus()});
</script>

<template>
    <select 
    class="form-select"
     :value="modelValue"
     @change="$emit('update:modelValue', $event.target.value)"
     ref="input">
        <option v-for="op in options" :key="op.i" :value="op.id">
            {{ ' Id: ' + op.id + ' | ' 
               + (op.name + op.lastname ? op.name + ' '+ op.lastname : op.type + '-> ' + op.status)+ ' | ' 
               + (op.client ? ' Cliente: ' + op.client : '') }}
        </option>
     </select>
</template>