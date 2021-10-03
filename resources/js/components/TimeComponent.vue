<template>
    <vue-timepicker format="HH:mm"
                    advanced-keyboard
                    :name="name"
                    placeholder="時刻の入力"
                    hour-label="時"
                    minute-label="分"
                    :value="defaulttime"
                    auto-scroll
                    close-on-complete>
    </vue-timepicker>
    
</template>

<script>
    import VueTimepicker from 'vue2-timepicker'
    import 'vue2-timepicker/dist/VueTimepicker.css'
    export default {
        components: {
            'vue-timepicker': VueTimepicker,
        },
        props: {
            name:{
                type: String,
                required: true
            },
            defaulttime:{
                type: String,
            }
        },
    
        data: function() {
            return {
                
            };
        },
        
    };
    
</script>