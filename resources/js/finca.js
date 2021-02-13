const { default: Axios } = require('axios');

window.Vue = require('vue');
import mapa from './Map.vue';
import mapa2 from './Map2.vue';

const appp = window.App = new Vue({

    el: '#finca',
    components: {
mapa:mapa,
        mapa2:mapa2
    },
    data:{
      fincas:[],
        fincas2:[],
        finca:{nombre:'',municipio:'',departamento:'',direccion:''},
        modoEditar: false,
        fincausuario:{},

        usuario:{ nombre:'' ,email:'', password:''}



    }, created(){

        this.traerFincas();
    this.traerFincasdireccion();



    },



    methods:
        {



            traerFincas(){
                Axios.get('/fincas')
                    .then((res) =>{
                        this.fincas = res.data;
                        console.log(res.data);
                    })
            }, cambiarEditar(item){
                this.finca.nombre = item.nombre;
                this.finca.municipio = item.municipio;
                this.finca.departamento= item.departamento;
                this.finca.id = item.id;

                this.modoEditar = true;
                this.$refs.mapa2.traerfinca(item);
            },
            verPerfil(){
                window.location.href =`/page`;
            },
            colocarfinca(finca){
                this.finca=finca;
                this.$refs.mapa.calcularAutomatico(finca.direccion);

            }, colocarfinca2(finca){
                this.finca=finca;
              /*  const map= this.$refs.mapa.map;
                console.log(map);*/
                this.$refs.mapa.geocodificar(finca.direccion);



            },
            cambiarAgregar(){

                this.modoEditar = false;
            },
            editarFinca(finca){
                const params = {nombre: finca.nombre, direccion: finca.direccion,municipio:finca.municipio,departamento:finca.departamento};
                axios.put(`/fincas/${finca.id}`, params)
                    .then(res=>{

                        const index = this.fincas.findIndex(item => item.id === finca.id);
                        this.fincas[index] = res.data;
                    })
            },
            agregar_firestore(){
                if(this.usuario.nombre.trim() === '' && this.usuario.email.trim() === ''&& this.usuario.password.trim() === ''  ){
                    alert('Debes completar todos los campos antes de guardar');
                    return;
                }
                const userNuevo = this.usuario;
                this.usuario = {nombre:'' ,email:'', password:''};
                Axios.post('/users/store', userNuevo)
                    .then((res) =>{
                    console.log(res);

                    })

            },
            agregarFinca(){
                if(this.finca.nombre.trim() === '' && this.finca.direccion.trim() === ''&& this.finca.municipio.trim() === '' && this.finca.departamento.trim() === ''  ){
                    alert('Debes completar todos los campos antes de guardar');
                    return;
                }
                const fincaNuevo = this.finca;
                this.finca = {nombre:'',municipio:'',departamento:'',direccion: ''};
                Axios.post('/enviarfinca', fincaNuevo)
                    .then((res) =>{
                        const fincaServidor = res.data;
                        this.fincas.push(fincaServidor);

                    })
            },
            traerFincasdireccion(){
                let direccion;
                Axios.get(`/fincasUsuario/`)
                    .then((res) =>{
                        this.fincasusuario = res.data;
                        this.fincas2=res.data;
                        direccion=this.fincasusuario[0].direccion;


                    })



            },
            autosuggest(){



            }


        }

});
