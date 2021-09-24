<template>

<div id="message" class="card main mb-5">    
    <div class="card-header">
        <span class="h1">チャット</span>
        <span class="text-muted" v-if="respons">thread</span>
        <span class="text-muted" v-else="respons">main-board</span>
    </div>
    
    <div class="card-text">
        <table class="table table-sm scroll">
            <tr v-for="message in messages">
                <td>
                    <span class="name">{{ message.name }}</span>
                    <span class="time text-muted">{{ message.created_at }}</span>
                    <p class="body">{{ message.body }}</p>
                    <span class="back btn btn-secondary btn-sm" @click="back()" v-if="respons">戻る</span>
                    <span class="reply btn btn-secondary btn-sm" @click="reply(message.id)" v-if="!respons">返信</span>
                    <span class="delete btn btn-secondary btn-sm" @click="del(message.id, message.init)" v-if="(message.init) && (!respons) && (auth == message.personal_id)">削除</span>
                    <span class="delete btn btn-secondary btn-sm" @click="del(message.id, message.init)" v-if="(!message.init) && (respons) && (auth == message.personal_id)">削除</span>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="input-text fixed-bottom">
        <div class="flexible w-100">
            <textarea class="textarea" rows="2" cols=100% v-model="message" placeholder="入力してください"></textarea><br>
            <button type="button" @click="send()" class="text-btn">送信</button>
        </div>
        <span v-model="message" id="buttom">文字数:{{ message.length }}</span>
        <span class="toTop text-muted btn btn-sm" @click="top()">一番上へ</span>
        <span class="next text-muted btn btn-sm" @click="next()" v-show="!isNull(nextPage)">もっと読み込む</span>
        <span class="prev" @click="prev()" v-show="!isNull(prevPage) && 0">前のページへ</span>
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
    props: {
        auth: {
            type : String,
        },
    },
    
    methods: { 
        reply(id) {
            
            let url = '/calendar/ajax/show/chat?id=' + id;
            this.uri = url;
            this.init = id;
            axios.get(url).then(res => {
                this.messages = res.data.data;
                this.respons = true;
                this.pageNate(res.data.next_page_url, res.data.prev_page_url);
                // console.log(res.data);            
            }).catch(function(error){
                console.log("fail");
            });
            
        },
        
        back() {
            this.respons = false;
            this.uri = '';
            
            this.getMessages();
            
        },
        del(id, n) {
            var con = 'このメッセージを削除しますか';
            if(n == 1)            
                con = 'スレッド下のメッセージもすべて削除されます\n削除しますか？';
            
            if(confirm(con)){
            
                let url = '/calendar/ajax/chat?id=' + id;
                axios.delete(url).then(res => {
                    this.getMessages();
                }).catch(function(error){
                    console.log("fail");
                });
            }
        },
        
        send() {
            if((0 < this.message.length) && (this.message.length < 540)){
                
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
            } else {
                //
            }
        },
        
        next() {
            let param = { id: this.init};
            axios.get(this.nextPage, param).then(res => {
                for(let i=0; i < res.data.data.length; i++)
                    this.messages.push(res.data.data[i]);
                this.pageNate(res.data.next_page_url, res.data.prev_page_url);
                // console.log(res.data);
            }).catch(function(error){
                console.log(error);
            });
            
        },
        
        prev() {
            let param = { id: this.init};
            axios.get(this.prevPage, param).then(res => {
                this.messages = res.data.data;
                this.pageNate(res.data.next_page_url, res.data.prev_page_url);
                //console.log(res.data);
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
                    //console.log(res.data);
                });
            } else {
                axios.get(this.uri).then(res => {
                    this.messages = res.data.data;
                    this.pageNate(res.data.next_page_url, res.data.prev_page_url);
                    //console.log(res.data);              
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
        
        top() {
            window.scroll({top: 0, behavior: 'smooth'});
        },
        
        listen() {
            Echo.channel('public-chat')
                .listen('MessageCreated', (e) => {
                    this.getMessages();
                });
        }
    },
    
    mounted() {
        this.getMessages();
        this.listen();
        
    },
};
</script>