<template>
<div id="chat">
    <textarea v-model="message"></textarea>
    <br><br>
    <button type="button" @click="send()">送信</button>
    <pre>{{ $data }}</pre>
    <div v-for="m in messages">

    <!-- 登録された日時 -->
    <span v-text="m.created_at"></span>：&nbsp;

    <!-- メッセージ内容 -->
    <span v-text="m.text"></span>

</div>
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
                const url = '/calendar/ajax/chat';
                const params = { message: this.message };
                axios.post(url, params)
                .then((response) => {
                    // 成功したらメッセージをクリア
                    this.message = '';
                    console.log("success");

                })
                .catch(()=>{
                    console.log(params);
                });
            },
            getMessages() {
                const url = '/calendar/ajax/chat';
                axios.get(url)
                .then((response)=>{
                    this.messages = response.data;
                });
            },
            
        },
        mounted() {
            this.getMessages();
            
        }
    }
</script>