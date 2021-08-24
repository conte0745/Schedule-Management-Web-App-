
<template>
<div id="chat">
    <textarea v-model="message"></textarea>
    <br><br>
    <button type="button" @click="send()">送信</button>
    <span v-for="message in messages">{{ message }}</span>
    <pre>{{ $data }}</pre>

    
</div>
</template>

<script>

    export default {
        data : function() {
            return {
                message: '',
                messages: [],
            }
        },
        
        methods: { 
            send() {
                let url = 'https://nameless-woodland-04388.herokuapp.com/calendar/ajax/chat';
                let params = { message: this.message };
                axios.post(url, params).then(res => {
                   this.getMessages();
                 }).catch(function(error){
                   console.log(error);
                });
            },
            
            push() {
                this.messages.push(this.message);
                this.message = '';
            },
            getMessages() {
                let url = '/calendar/ajax/chat';
                axios.get(url).then(res => {
                    this.messages = res.data;
                });
            },
            
        },
        mounted() {
            this.getMessages();
            
        }
    }
</script>