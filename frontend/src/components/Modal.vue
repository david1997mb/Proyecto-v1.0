<script setup>
const props = defineProps({
    modal: String, title:String
});
</script>
<template>
    <div class="modal fade" :id="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header ">
                    <label class="h4">{{ title }}</label>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <slot></slot>
            </div>
        </div>
    </div>
</template>