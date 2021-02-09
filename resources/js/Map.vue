<template>
    <div>

            <h3>{{hols}}</h3>
            <p v-text="direccion"></p>

        <div id="map"></div>

    </div>
</template>


<script>
const { default: Axios } = require('axios');
export default {
name:"Mapa",

    props:{
        hols: Array[10],
},
    data() {
        return {
            map: null,

            fincas:'',
            direccion:''
        };
    },
    created() {
    this.traerFincas();

    },
    mounted() {
        this.createMap();

    },


    methods: {
        createMap: function(){
            this.map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -12.1430911, lng: -77.0227697},
                zoom: 12
            });

        },
      traerFincas(){
            Axios.get('/fincas')
                .then((res) =>{
                    this.fincas = res.data;
                    this.direccion = this.fincas[0].direccion;
                    console.log( this.fincas[0].direccion);
                })
        }

    }
};
</script>


<style >
#map{
    width: 350px;
    height: 400px;
    position: relative;
    left: 40px;
    top:0px;
}

</style>
