<template>

<div id="message" class="card">    
    <div class="h1 card-header">チャット</div>
    <div class="card-text">
    
    <table class="table table-sm scroll">
    <tr v-for="message in messages">
        <td>
        <span class="name">{{ message.personal_id }}</span>
        <span class="time text-muted">{{ message.updated_at }}</span>
        <p class="body">{{ message.body }}</p>
        <span class="delete text-muted" @click="del(message.id)">del</span>
        <a href="/calendar/chat/" class="text-muted back">back</a>
        </td>
        
    </tr>
    </table>
    
    
    </div>
    <div class="border"><br></div>
    
    <div class="input-text fixed-bottom">
        <div class="flexible max-width">
            <textarea rows="2" cols=50% v-model="message" placeholder="入力してください"></textarea><br>
            <button type="button" @click="send()">送信</button>
        </div>
        <p v-model="message" id="buttom">文字数:{{ message.length }}</p>
    </div>
    {{ $data }}
    
    
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
        
        
        
        del(id) {
            if((confirm('Do you want to delete?'))){
            
                let url = '/calendar/ajax/chat/show?id=' + id;
                axios.delete(url).then(res => {
                    this.getMessages();
                }).catch(function(error){
                    console.log("fail");
                });
            }
        },
        
        send() {
            if(this.message!= '' || this.message != ' ' || this.message.length < 540){
                
                let url = '/calendar/ajax/chat/show';
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
            let url = '/calendar/ajax/chat/show';
            axios.get(url).then(res => {
                this.messages = res.data.data;
                console.log(res.data.data)
                
            });
        },
    },
    
    mounted() {
        this.getMessages();
    }
}
</script>