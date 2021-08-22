<template>
    <datepicker
        :value="defaultdate"
        :format="this.DatePickerFormat"
        :name="name"
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
        }
    },
    data: function() {
        return {
            DatePickerFormat: "yyyy/MM/dd",
            
        };
    }
};

</script>