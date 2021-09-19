<template>

<div id="message" class="card">    
    <span class="h1 card-header">チャット</span>
    
    <div class="card-text mian mb-3">
        <table class="table table-sm scroll">
            <tr v-for="message in messages">
                <td>
                    <span class="name">{{ message.personal_id }}</span>
                    <span class="time text-muted">{{ message.updated_at }}</span>
                    <p class="body">{{ message.body }}</p>
                    <span class="delete text-muted" @click="del(message.id)">del</span>
                    <span class="back text-muted" @click="back()" v-if="respons">back</span>
                    <span class="reply text-muted" @click="reply(message.id)" v-else="respons">reply</span>
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
        <span v-model="message" id="buttom">文字数:{{ message.length }}</span>
        <span class="prev" @click="prev()" v-show="!isNull(prevPage)">前のページへ</span>
        <span class="next" @click="next()" v-show="!isNull(nextPage)">次のページへ</span>
        
    </div>
    
</div>
</template>

<script>

export default {
    data : function() {
        return {
            respons: false,
            nextPage: null,
            prevPage: null,
            uri: '_',
            init: '_',
            message: '',
            messages: [],

        };
    },
   
    
    methods: { 
        reply(id) {
            
            console.log("read reply");
            let url = '/calendar/ajax/show/chat?id=' + id;
            this.uri = url;
            this.init = id;
            axios.get(url).then(res => {
                this.messages = res.data.data;
                this.respons = true;
                this.pageNate(res.data.next_page_url, res.data.prev_page_url);
                console.log(res.data);            
            }).catch(function(error){
                console.log("fail");
            });
            
        },
        
        back() {
            this.respons = false;
            this.uri = '';
            
            this.getMessages();
            
        },
        del(id) {
            if((confirm('Do you want to delete?'))){
            
                let url = '/calendar/ajax/chat?id=' + id;
                axios.delete(url).then(res => {
                    this.getMessages();
                }).catch(function(error){
                    console.log("fail");
                });
            }
        },
        
        send() {
            if((this.message != '') || (this.message != ' ') || (this.message.length < 540)){
                
                let params = { message: this.message,
                                init: this.init
                            };
                let url = '/calendar/ajax/chat';
                
                if(this.respons){
                    url = '/calendar/ajax/chat/store';
                }
                
                axios.post(url, params).then(res => {
                    this.getMessages();
                }).catch(function(error){
                   console.log(error);
                });
               
                this.message = '';
            }
        },
        
        next() {
            let param = { id: this.init};
            axios.get(this.nextPage, param).then(res => {
                this.messages = res.data.data;
                this.pageNate(res.data.next_page_url, res.data.prev_page_url);
                console.log(res.data);
            }).catch(function(error){
                console.log(error);
            });
            
        },
        
        prev() {
            let param = { id: this.init};
            axios.get(this.prevPage, param).then(res => {
                this.messages = res.data.data;
                this.pageNate(res.data.next_page_url, res.data.prev_page_url);
                console.log(res.data);
            }).catch(function(error){
                console.log(error);
            });
        },

        pageNate (next, prev) {
            if(this.isNull(next))
                this.nextPage = null;
            else 
                this.nextPage = next + '&id=' + this.init;
            if(this.isNull(prev))
                this.prevPage = null;
            else
                this.prevPage = prev + '&id=' + this.init;
                
        },
        
        getMessages() {
            
            if(!this.respons){
                let url = '/calendar/ajax/chat';
                axios.get(url).then(res => {
                    this.messages = res.data.data;
                    this.pageNate(res.data.next_page_url, res.data.prev_page_url);
                    console.log(res.data);
                });
            } else {
                axios.get(this.uri).then(res => {
                    this.messages = res.data.data;
                    this.pageNate(res.data.next_page_url, res.data.prev_page_url);
                    console.log(res.data);              
                }).catch(function(error){
                    console.log("fail");
                });
            }
            
        },
    
        isNull(x) {
            if(x == null){
                return true;
            } else {
                return false;
            }
        },
    },
    
    mounted() {
        this.getMessages();
    },
};
</script>