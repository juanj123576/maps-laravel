<template>
    <div>

        <select id="comienzo" class="form-control" >
            <option v-for="finca in fincas" :value="finca.direccion" v-text="finca.direccion"></option>

        </select>

        <input style="top:-80px;display: none" placeholder="Search for a Place or an Address."  id="input"   ref="origin"  autofocus/>

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
            finca:'',
            marcador:'',

            directionsService:null,
             directionsRenderer:null,
            infoWindow:null,
            geocoder:null,
            address:'',
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
         this.map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 40.749933, lng: -73.98633 },
            zoom: 13,
        });
        const options = {
            componentRestrictions: { country: "co" },
            fields: ["formatted_address", "geometry", "name"],
            origin: this.map.getCenter(),
            strictBounds: false,
            types: ["geocode"],
        };
        this.directionsService = new google.maps.DirectionsService();
        this.directionsRenderer = new google.maps.DirectionsRenderer();
        this.geocoder = new google.maps.Geocoder();
        this.infoWindow=new google.maps.InfoWindow();
        this.marcador=  new google.maps.Marker({map:this.map});
        document.getElementById("comienzo")
            .addEventListener("change", this.onChangeHandler);

           const autocomplete = new google.maps.places.Autocomplete(this.$refs["origin"],options);
        const marker = new google.maps.Marker({
            map:this.map,
            anchorPoint: new google.maps.Point(0, -29),
        });
        autocomplete.addListener("place_changed", () => {

            marker.setVisible(false);
            const place = autocomplete.getPlace();
            console.log(place);
          //  this.finca.direccion=place.formatted_address;
            if (!place.geometry || !place.geometry.location) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert(
                    "No details available for input: '" + place.name + "'"
                );
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                this.map.fitBounds(place.geometry.viewport);
            } else {
                this.map.setCenter(place.geometry.location);
                this.map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

        });


    },


    methods: {

        traerFincas(){

                Axios.get('/fincas')
                    .then((res) =>{
                        if(res!=null){
                            this.fincas = res.data;
                            this.direccion = this.fincas[0].direccion;
                            console.log( this.fincas[0].direccion);
                        }

                    }).catch(e =>{
                        console.log(e)
                }

                )


        },

        createMap(){
            this.map =  new google.maps.Map(document.getElementById('map'), {
                center: {lat: -12.1430911, lng: -77.0227697},
                zoom: 12
            });
            this.directionsService = new google.maps.DirectionsService();
            this.directionsRenderer = new google.maps.DirectionsRenderer();
            this.geocoder = new google.maps.Geocoder();
            this.infoWindow=new google.maps.InfoWindow();
            document.getElementById("comienzo")
                    .addEventListener("change", this.onChangeHandler);
        },
        traerfinca(finca){
            this.finca=finca;
        },

        geocodificar(direccion){
            let _this=this;



            this.geocoder.geocode( { 'address': direccion}, function(results, status) {
                if (status == 'OK') {


                   _this.map.setCenter(results[0].geometry.location);
                    if(_this.marcador==null){
                        _this.marcador.setMap(_this.map);
                        _this.marcador.setPosition(results[0].geometry.location);
                    }else{
                        _this.marcador.setMap(null);
                        _this.marcador.setMap(_this.map);
                        _this.marcador.setPosition(results[0].geometry.location);
                    }



                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
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



        },



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
#input{
    position: relative;
    width: 150px;
    height: 20px;

    left: 40px;
    top:0px;
}
.pac-container {
    z-index: 10000 !important;
}

</style>
