<template>
    <div>


        <input id="input" type="text" placeholder="Origin" ref="origin" />

    </div>
</template>


<script>
const { default: Axios } = require('axios');
export default {
    name:"Mapa2",

    props:{

    },
    data() {
        return {

        };
    },
    created() {


    },
    mounted() {
        const autocomplete = new google.maps.places.Autocomplete(this.$refs["origin"]);

    },


    methods: {


    }
};
</script>


<style >
#input{
    width: 300px;
    height: 40px;
    position: relative;
    left: 40px;
    top:-100px;
}
.pac-container {
    z-index: 10000 !important;
}


</style>
