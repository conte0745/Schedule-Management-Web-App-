<template>

<div id="message" class="card">    
    <div class="h1 card-header">チャット</div>
    <div class="card-text">
    <a href="#buttom">一番下へ</a>
    
    <table class="table table-sm scroll">
    <tr v-for="message in messages">
        <td>
        <p class="name">{{ message.name }}</p>
        <p class="body">{{ message.message }}</p>
        <p class="time">{{ message.create }}</p>
        
        </td>
    </tr>
    </table>
    
    
    </div>
    <div class="border"><br></div>
    <div class="flexible">
        <textarea rows="2" cols=50% v-model="message" placeholder="入力してください"></textarea><br>
        <button type="button" @click="send()">送信</button>
    </div>
    <p v-model="message" id="buttom">文字数:{{ message.length }}</p>

</div>
</template>

<script>

export default {
    data : function() {
        return {
            message: '',
            messages: [],
        };
    },
   
    
    methods: { 
        send() {
            if(this.message!= '' || this.message != ' ' || this.message.length < 540){
                
                let url = '/calendar/ajax/chat';
                let params = { message: this.message };
                
                axios.post(url, params).then(res => {
                    
                    console.log(params);
                    
                    this.getMessages();
                 }).catch(function(error){
                   console.log(error);
                });
                
                this.message = '';
            }
        },
            
        push() {
            this.messages.push(this.message);
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