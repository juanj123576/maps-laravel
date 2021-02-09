<template>
    <div>


        <div id="map2"></div>

    </div>
</template>


<script>
const { default: Axios } = require('axios');
export default {
    name:"Mapa2",

    props:{
        hols: Array[10],
    },
    data() {
        return {
            map2: null,

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
            this.map2 = new google.maps.Map(document.getElementById('map2'), {
                center: {lat: -12.1430911, lng: -77.0227697},
                zoom: 12
            });

        }


        ,traerFincas(){
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
#map2{
    width: 350px;
    height: 400px;
    position: relative;
    left: 400px;
    top:-460px;
}


</style>
