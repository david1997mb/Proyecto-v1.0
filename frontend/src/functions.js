import Swal from "sweetalert2";
import { nextTick } from "vue";
import { useAuthStore } from "./stores/auth";
import axios from "axios";

export function show_alerta(msj,icon,focus){
    if (focus !== '') {
        nextTick( ()=> focus.value.focus());
    }
    Swal.fire({
        title:msj,icon:icon,buttonsStyling:true
    });
}

export function confirmation(name,url,redirect){
    const alert = Swal.mixin({buttonsStyling:true});
    alert.fire({
        title:'Esta Seguro Que Desea Eliminar A: '+name+' ?',
        icon:'question',showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Si, Eliminar',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancelar'
    }).then( (result) =>{
        if (result.isConfirmed) {
            sendRequest('DELETE',{},url,redirect);
        }
    });
}

export async function sendRequest(method,params,url,redirect='') {
    const authStore = useAuthStore();
    axios.defaults.headers.common['Authorization'] = 'Bearer '+authStore.authToken;
    let res;
    await axios({method:method, url:url, data:params}).then(
        response =>{
            res = response.data.status,
            show_alerta(response.data.message,'success',''),
            setTimeout(
                () => (redirect !== '') ? window.location.href = redirect:''
            ,2000)
        }).catch((errors) =>{
            let desc='';
            res = errors.response.data.status;
            errors.response.data.errors.map( (e)=>{ desc = desc + ' '+e})
            show_alerta(desc,'error','')
        })
        return res;
}