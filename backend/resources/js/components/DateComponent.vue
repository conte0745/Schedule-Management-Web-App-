<template>
    <datepicker
        :value="defaultdate"
        :format="this.DatePickerFormat"
        :name="name"
        :id="id"
        wrapper-class="inline-block"
        input-class="inline-block"
    >
    </datepicker>
</template>

<script>
import datepicker from "vuejs-datepicker";

export default {
    components: {
        datepicker
    },
    props: {
        name: {
            type: String,
            
        },
        defaultdate: {
            type: String,
        },
        id: {
            type: String,
        }
        
    },
    data: function() {
        return {
            DatePickerFormat: "yyyy/MM/dd",
        };
    }
};

</script>