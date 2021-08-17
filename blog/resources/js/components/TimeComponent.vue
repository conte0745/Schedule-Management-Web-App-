<template>
    <vue-timepicker format="hh:mm"
                    advanced-keyboard
                    name="calendar[start_time]"
                    placeholder="時間を入力してください"></vue-timepicker>
    
        
    
</template>

<script>
    import VueTimepicker from 'vue2-timepicker'
    import 'vue2-timepicker/dist/VueTimepicker.css'
    export default {
        components: {
            'vue-timepicker': VueTimepicker,
        },
        data: {
            
        }
    }
</script>