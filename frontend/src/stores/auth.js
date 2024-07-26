import axios from "axios";
import { defineStore } from 'pinia';
import { show_alerta } from '@/functions';

export const useAuthStore = defineStore('auth', {
    state: ()=> ({authUser: null, authToken: null}),
    getters:{
        user:(state) => state.authUser,
        token:(state) => state.authToken
    },
    actions:{
        async getToken(){
            await axios.get('/sanctum/csrf-cookie');
        },
        async login(form){
            await this.getToken();
            await axios.post('/api/auth/login',form).then(
                (res) =>{
                    this.authToken = res.data.token;
                    this.authUser = res.data.data;
                    show_alerta(res.data.message,'success','');
                    this.router.push('/');
                }
            ).catch(
                (errors) =>{
                    let desc = '';
                    errors.response.data.errors.map(
                        (e) => {desc = desc + ' '+ e}
                    )
                    show_alerta(desc,'error','');
                }
            )
        },
        async logout(){
            await axios.get('/api/auth/logout',this.authToken).then(
                (res) =>{
                    show_alerta(res.data.message,'success','');
                    this.authToken = null;
                    this.authUser = null;
                    this.router.push('/login');
                }
            ).catch(
                (errors) =>{
                    let desc = '';
                    errors.response.data.errors.map(
                        (e) => {desc = desc + ' '+ e}
                    )
                    show_alerta(desc,'error','');
                }
            );
        }
    },
    persist:true
});