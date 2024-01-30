<template>
<div class="container">
  <div class="chat_container">
        <div class="chat_friend_info">
      <img :src="'/storage/profile_pics/' + penpal.avatar" alt="" style="width: 125px; height: 125px; border-radius: 100%;" class="friend_chat_avatar"><p class="chat_friend_name">{{ penpal.name }}</p>
      </div>
      <div class="dialog">
      <div v-for="chat_message in messages" v-if="messages.length != 0">
          <div v-if="chat_message.is_received_message" class="other_user">
              <img :src="'/storage/profile_pics/'+chat_message.messager_pfp" alt="" class="user_pfp_chat">
              <div class="text">
                  <div class="upper_line">
                      <p class="name_friend">{{ chat_message.messager_name }} {{ chat_message.messager_surname }}</p>
                      <p class="date_friend">{{ chat_message.time }}</p>
                  </div>
                  <p class="lower_line">
                      {{ chat_message.text }}
                  </p>
              </div>
          </div>
          <div v-else class="this_user">
            <img class="user_pfp_chat" :src="'/storage/profile_pics/' + chat_message.messager_pfp" alt="" >
                  <div class="text">
                    <div class="upper_line user_line">
                        <p class="name_user">{{ chat_message.messager_name }}</p>
                        <p class="date_user">{{ chat_message.time }}</p>
                    </div>
                        <p class="lower_line">
                        {{ chat_message.text }}
                    </p>
                    <div class="is_read_div">
                        <p @click="delete_message(chat_message.id)" class="is_read delete">Удалить</p>
                        <p class="is_read">{{ chat_message.is_read }}</p>
                    </div>
                  </div>

            </div>
      </div>
      <div class="empty" v-else>
          <p>Вы ещё не начали переписку</p>
      </div>
      </div>
  </div>
  <hr>
  <div class="buttom_form">
      <textarea v-model="chat_message" placeholder="Ваше сообщение здесь" name="" id="" cols="30" rows="10" class="chat_textarea"></textarea>
      <p class="message_err">{{ errors.message }}</p>
      <button  @click="send_message" class="send_msg_btn">Отправить</button>
  </div>
  </div>
</template>

<style>


.empty{
    font-size: 30px;
    margin: 120px auto;
    width: fit-content;
}

.chat_friend_info {
    display: flex;
    column-gap: 5%;
    margin-top: 3%;
    margin-left: 11%;
    margin-bottom: 2%;
}

.chat_friend_name {
    font-size: 40px;
    margin-top: 2%;
    margin-left: -3%;
}

hr {
    border: 3px solid black;
}

.dialog {
    height: 700px;
    text-overflow: ellipsis;
    overflow-x:hidden;
    overflow-y: scroll;
    padding-bottom: 2%;
}

.chat_textarea {
    width: 887px;
    height: 118px;
    border-radius: 12px;
    border: 2px solid black;
    padding: 1%;
    font-size: 24px;
    margin-left: 5%;
    margin-top: 2%;
}

.buttom_form {
    display: flex;
}

.send_msg_btn {
  width: 359px;
  height: 60px;
  border-radius: 12px;
  border: none;
  background-color: #C2E6B9;
  font-size: 24px;
  color: white;
  margin-left: auto;
  margin-right: auto;
  display: block;
  margin-top: 5%;
  cursor: pointer;
  margin-bottom: 4%;    
}

.this_user {
    display: flex;
    margin-top: 2%;
    position: relative;
    text-align: start;
    left: 70%;

}

.upper_line {
    display: flex;
    width: 400px;
    margin-top: 5%;
}


.upper_line p {
    font-size: 24px;
}

.name_user {
    margin-left: 5%;
    width: 80px;
    font-size: 28px !important;
}

.date_user {
    font-size: 14px !important;
    margin-top: 3%;
    margin-left: 20%;
}

.text {
    width: 500px;
}

.lower_line {
    width: 604px;
    margin-top: 6%;
    font-size: 22px;
    margin-left: 4%;
}

.user_pfp_chat {
    width: 80px;
    height: 80px;
    border-radius: 100%;
}

.other_user {
    display: flex;
    margin-top: 2%;
    margin-left: 15%;
}

.name_friend {
    font-size: 28px !important;
    margin-right: 15%;
    margin-left: 5%;
}

.date_friend {
    font-size: 14px !important;
    margin-top: 3%;
}

.is_read {
    font-size: 16px;
    margin-top: 4%;
    color: black;
}

.delete {
    text-decoration: underline;
}

.is_read_div {
    display: flex;
    column-gap: 5%;
}

@media (max-width: 350px) {
    hr {
        border: 2px solid black;
    }

    .chat_friend_info {
        margin-left: 15px;
    }

    .friend_chat_avatar {
        width: 40px !important;
        height: 40px !important;
    }

    .chat_friend_name {
        margin-top: 4%;
        font-size: 15px;
    }

    .chat_textarea {
        width: 232px;
        height: 36px;
        font-size: 6px;
        border: 1px solid black;
        padding: 2%;
    }

    .send_msg_btn {
        width: 98px;
        height: 16px;
        font-size: 8px;
        margin-top: 4%;
    }

    .empty {
        font-size: 10px;
    }

    .dialog {
        height: 380px;
    }

    .user_pfp_chat {
        height: 30px;
        width: 30px;
        border-radius: 100%;
        
    }

    .this_user {
        display: flex;
        margin-top: 6%;
        position: relative;
        text-align: start;
        left: 7%;
    }

    .other_user {
        margin-top: 6%;
        margin-left: 7%;
    }

    .lower_line {
        font-size: 8px;
        margin-right: 5%;
        width: 150px;
    }

    .date_user {
        margin-top: auto;
        margin-left: 5%;
    }

    .date_friend {
        margin-top: auto;
    }

    .upper_line p {
        font-size: 8px !important;
    }

    .is_read {
        font-size: 8px;
    }

    .name_user {
        margin-left: 2%;
        width: 20px;
    }

    .is_read_div {
        column-gap: 5%;
        margin-left: 5%;
    }


    .name_friend {
        margin-left: 2.5%;
        margin-right: 3%;
    }


    .text {
        margin-top: -2%;
        width: 200px;
    }

}
.buttom_form{
  overflow-x: hidden;

}
</style>


<script>
import axios from "axios"
export default {
  name: "Chat",
  data() {
    return {
      penpal_id: window.location.href.substring(window.location.href.lastIndexOf('/') + 1),
      chat_message: '',
      errors: {
          message: null
      },
      messages: null,
      penpal: null,
      invalid_user: false
    }
  },
  created() {
      console.log(this.penpal_id)
      this.$axios.get("http://127.0.0.1:8000/api/getmessages/"+this.penpal_id)
          .then((response) => {
              this.messages = response.data.data
          })
      setInterval(()=>{
          this.$axios.get("http://127.0.0.1:8000/api/getmessages/"+this.penpal_id)
          .then((response) => {
              if(this.messages != response.data.data){
                  this.messages = response.data.data
              }
          })
      }, 5000)
      this.$axios
            .post("http://127.0.0.1:8000/api/otheruserinfo",
                {
                    id: window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
                })
            .then((response) => {
                this.penpal = response.data;
                
            });
  },
    methods: {
        delete_message(id) {
            this.$axios.post("http://127.0.0.1:8000/api/deletemessage", {
                id: id 
            })
                .then((response) => {
                    this.chat_message = ''
                    this.$axios.get("http://127.0.0.1:8000/api/getmessages/" + this.penpal_id)
                        .then((response) => {
                            this.messages = response.data.data
                            console.log(response.data)
                        })
                })
        },
        send_message() {
          this.errors = {
              message: null
          }
          this.$axios.post("http://127.0.0.1:8000/api/sendmessage", {
            message: this.chat_message,
            receiver_id: this.penpal_id,
          })
          .then((response) => {
              this.chat_message = ''
              this.$axios.get("http://127.0.0.1:8000/api/getmessages/"+this.penpal_id)
          .then((response) => {
              this.messages = response.data.data
              console.log(response.data)
          })
          })
          .catch((err) => {
            console.log(err);
            if (err.response.data.errors.message) {
              this.errors.message = err.response.data.errors.message[0];
            }
          });
      },
      
  },
  beforeRouteEnter(to, from, next) {
      if(!window.Laravel.user){
          return next("/");
      }
      if(window.Laravel.user.id == window.location.href.substring(window.location.href.lastIndexOf('/') + 1)){
          return next("user/" + window.Laravel.user.id);
      }
      axios.get('http://127.0.0.1:8000/api/user/'+window.location.href.substring(window.location.href.lastIndexOf('/') + 1)).then(response => {
          console.log("!!")
          if (response.data == 'no_user_found' ) {
              return next("user/" + window.Laravel.user.id);
          }
          next();
      })
  
},
};
</script>

