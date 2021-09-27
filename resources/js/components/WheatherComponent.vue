<template>
<div class="wheather" style="padding: 15px">
    <h1>wheather</h1>
    <input type="button" class="btn btn-primary" @click="getWheather()" value="get"/>
    {{ $data }}
</div>
    
</template>

<script>

export default {
    
    data: function() {
        return {
            dataSet: [],
            data: '',
            
        };
    },
    
    methods: {
        getWheather(){
            const options = {
              method: 'GET',
              url: 'https://community-open-weather-map.p.rapidapi.com/forecast',
              params: {q: 'Tokyo, jp', lang: 'ja'},
              headers: {
                'x-rapidapi-key': '7fb14c643emsh56cac74ee95a328p1f16c6jsn56b48b37243b',
                'x-rapidapi-host': 'community-open-weather-map.p.rapidapi.com'
              }
            }
            axios.request(options).then(function (response) {
                this.data = response.data.list;
            	console.log(response.data);
            	console.log(response);
            	
            }).catch(function (error) {
            	console.log(error);
            });
        }
    }

};

</script>