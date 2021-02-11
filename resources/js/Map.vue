<template>
    <div>

            <h3 id="final">{{hols}}</h3>

        <select id="comienzo" class="form-control" >
            <option v-for="finca in fincas" :value="finca.direccion" v-text="finca.direccion"></option>

        </select>
        <div id="map"></div>

    </div>
</template>


<script>
const { default: Axios } = require('axios');
export default {
name:"Mapa",

    props:{
        hols: String,
        estadoMapa: {
            type: Boolean,
            default: false
        }
},
    data() {
        return {
            map: null,

            fincas:'',
            direccion:'',
            fincas2:'',

            directionsService:null,
             directionsRenderer:null,
            infoWindow:null,
            geocoder:null,
            posicion : { lat: 0, lng: 0 }
        };
    },
    created() {
    if(this.estadoMapa===false){
        this.traerFincas();

        console.log("hola2");
    }else{

        console.log("hola1");
    }


    }

    ,

    mounted() {

        this.createMap();


    },


    methods: {

        traerFincas(){

                Axios.get('/fincas')
                    .then((res) =>{
                        this.fincas = res.data;
                        this.direccion = this.fincas[0].direccion;
                        console.log( this.fincas[0].direccion);


                    })


        },
        traerFincasdireccion() {

            Axios.get(`/fincasUsuario/`)
                .then((res) => {

                    this.fincas2 = res.data;



                })
        },
        createMap(){

         this.map =  new google.maps.Map(document.getElementById('map'), {
                center: {lat: -12.1430911, lng: -77.0227697},
                zoom: 12
            });


        console.log("holaaaaaaaaaaaaaaaaaaaaaaa");
            this.directionsService = new google.maps.DirectionsService();
            this.directionsRenderer = new google.maps.DirectionsRenderer();
            this.geocoder = new google.maps.Geocoder();
            this.infoWindow=new google.maps.InfoWindow();

                document.getElementById("comienzo")
                    .addEventListener("change", this.onChangeHandler);




        },
        geocodificar(direccion){
            let _this=this;
            this.geocoder.geocode( { 'address': direccion}, function(results, status) {
                if (status == 'OK') {


                   _this.map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map:_this.map,
                        position: results[0].geometry.location
                    });


                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });




        },
        añadirmarcador(){


            let marker = new google.maps.Marker({
                map: this.map,
                position: posicion
            });
        },

        onChangeHandler:function () {



            this.calculateAndDisplayRoute(this.directionsService, this.directionsRenderer);
        },
        calculateAndDisplayRoute: function (directionsService, directionsRenderer) {

        directionsRenderer.setMap(null);
        this.infoWindow.close();
    directionsService.route(
        {
            origin: {
                query: document.getElementById("comienzo").value,
            },
            destination: {
                query: this.hols,
            },
            travelMode: google.maps.TravelMode.DRIVING,
        },
        (response, status) => {
            if (status === "OK") {
                directionsRenderer.setDirections(response);
                directionsRenderer.setMap(this.map);
                console.log(response.routes[0].legs[0].duration.text);
                const posicion = { lat: 0, lng: 0 };
                posicion.lat=response.routes[0].legs[0].end_location.lat();
                posicion.lng=response.routes[0].legs[0].end_location.lng();



                let duracion=response.routes[0].legs[0].duration.text;
                let distancia=response.routes[0].legs[0].distance.text;
                let datos="Tiempo:"+" "+ duracion +" "
                    + "Distancia:"+" "+distancia;
                const contentString =
                    '<div id="content">' +

                    "</div>"  +
                    '<div id="bodyContent">' +
                    '<i class="fa fa-car" aria-hidden="true"></i>'+

                    "</div>"+datos;
                ;





                this.infoWindow.setContent(contentString);
                this.infoWindow.open(this.map);
                this.infoWindow.setPosition(posicion);

            } else {
                window.alert("Directions request failed due to " + status);
            }
        }
    );
},


        calcularAutomatico(direccion){




            this.directionsRenderer.setMap(null);
            this.infoWindow.close();

                this.directionsService.route(
                    {
                        origin: {
                            query: this.direccion,
                        },
                        destination: {
                            query: direccion,
                        },
                        travelMode: google.maps.TravelMode.DRIVING,
                    },
                    (response, status) => {
                        if (status === "OK") {
                            this.directionsRenderer.setDirections(response);
                            this.directionsRenderer.setMap(this.map);
                            const posicion = { lat: 0, lng: 0 };
                            posicion.lat=response.routes[0].legs[0].end_location.lat();
                            posicion.lng=response.routes[0].legs[0].end_location.lng();



                            let duracion=response.routes[0].legs[0].duration.text;
                            let distancia=response.routes[0].legs[0].distance.text;
                            let datos="Tiempo:"+" "+ duracion +" "
                                + "Distancia:"+" "+distancia;
                            const contentString =
                                '<div id="content">' +

                                "</div>"  +
                                '<div id="bodyContent">' +
                                '<i class="fa fa-car" aria-hidden="true"></i>'+

                                "</div>"+datos;
                            ;





                        this.infoWindow.setContent(contentString);
                            this.infoWindow.open(this.map);
                            this.infoWindow.setPosition(posicion);
                        } else {
                            window.alert("Directions request failed due to " + status);
                        }
                    }
                );



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
