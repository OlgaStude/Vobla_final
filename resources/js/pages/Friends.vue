<template>
  <div class="container">
    <input type="text" v-model="search" @keyup="search_friend" class="friends_search" placeholder="Имя пользователя">
    <div class="friends_list_div">
    <div>
    <h1 class="friend_list_title">Список друзей</h1>
    <div v-for="friend in friends" class="friends_div">
      <a :href="$router.resolve({ name: 'userPage', params: { id: friend.friend_id } }).href"><img style="width: 125px; height: 125px; border-radius: 100%;" :src="'/storage/profile_pics/'+friend.friend_avatar" alt="" class="friend_avatar"></a>
      <a :href="$router.resolve({ name: 'userPage', params: { id: friend.friend_id } }).href"><p class="friend_name">{{ friend.friend_name }}</p></a>
    </div>
    </div>
    <div class="friends_requests_div">
    <h1 class="friends_requests_title">Заявки в друзья</h1>
    <div v-for="request in friend_requests" id="requests" class="friends_request_div">
      <a :href="$router.resolve({ name: 'userPage', params: { id: request.user_id } }).href"><img style="width: 125px; height: 125px; border-radius: 100%;" :src="'/storage/profile_pics/'+request.user_avatar" alt="" class="friend_request_avatar"></a>
      <div class="friends_request_div2">
      <p class="friends_request_name">{{ request.user_name }}</p>
      <p class="god_will">Хочет добавить вас в друзья</p>
      </div>
      <div class="friends_request_div3">
      <button @click="request_response(true, request.user_id)" class="request_accept_btn">Принять</button>
      <button @click="request_response(false, request.user_id)" class="request_decline_btn">Отклонить</button>
      </div>
    </div>
    </div>
    </div>
  </div>
</template>

<style>

.friends_search {
  width: 634px;
  height: 54px;
  border: 2px solid black;
  border-radius: 12px;
  font-size: 24px;
  color: black;
  padding: 1%;
  margin-left: 10%;
  margin-top: 3%;
}

.friends_list_div {
  display: grid;
  grid-template-columns: 1fr 1fr;
  margin-top: 2%;
  margin-left: 10%;
}

.friends_div {
  display: flex;
  margin-top: 4%;
  height: 160px;
}

.friend_name {
  margin-top: 40px;
  margin-left: 40px;
  color: black;
  font-size: 40px;
}

.friends_request_div {
  display: flex;
  margin-top: 4%;
  column-gap: 2%;
}

.friends_request_div2 {
  margin-top: 4%;
  margin-left: 5%;
}

.god_will {
  font-size: 20px
}

.friends_request_name {
  font-size: 40px;
}

.friends_request_div3 {
  margin-left: 2%;
}

.request_accept_btn {
  width: 263px;
  height: 50px;
  border: none;
  border-radius: 15px;
  font-size: 24px;
  background-color: #C2E6B9;
  color: white;
  margin-top: 5%;
  cursor: pointer;
}

.request_decline_btn {
  width: 263px;
  height: 50px;
  border: none;
  border-radius: 15px;
  font-size: 24px;
  background-color: #FAA5A5;
  color: white;
  margin-top: 5%;
  cursor: pointer;
}

@media (max-width: 320px) {
  
  .friend_avatar {
    width: 40px !important;
    height: 40px !important;
  }

  .friend_request_avatar {
    width: 40px !important;
    height: 40px !important;
  }

  .friend_name {
    font-size: 13px;
    position: relative;
    left: -30%;
    margin-top: 0;
    width: 70px;
    top: 2.5vh;
  }

  .friends_request_name {
    position: relative;
    margin-top: 1vh;
    font-size: 13px;
  }

  .friends_search {
    width: 153px;
    height: 16px;
    font-size: 8px;
    border: 1px solid black;
    border-radius: 5px;
  }

  .god_will {
    font-size: 7px;
    white-space: nowrap;
    margin-top: 2%;
  }

.request_accept_btn {
  margin-top: 10%;
}

  .request_accept_btn, .request_decline_btn {
    width: 98px;
    height: 16px;
    font-size: 8px;
  }
  
  .friends_request_div3 {
    position: relative;
    margin-top: 30%;
    right: 101%;
  }

  .friend_list_title, .friends_requests_title {
    white-space: nowrap;
  }

  .friends_list_div {
    grid-column-gap: 2%;
  }

  .friends_requests_div {
    margin-top: 1%;
    width: 100px;
  }

  .friends_div {
    margin-top: 2%;
    height: 50px;
  }
}

</style>

<script>
export default {
  name: "Dashboard",
  data() {
    return {
      friends: [],
      friend_requests: [],
      search: ''
    };
  },
  created() {
    this.$axios
      .get("http://127.0.0.1:8000/api/getfriends")
        .then((response) => {
        console.log(response.data)
        this.friends = response.data.data;
      });
      this.$axios
      .get("http://127.0.0.1:8000/api/friendsrequests")
        .then((response) => {
        console.log(response.data.data)
        this.friend_requests = response.data.data;
      });
  },
  methods: {
    search_friend(){
      this.$axios
      .get("http://127.0.0.1:8000/api/getfriends")
        .then((response) => {
        this.friends = [];
        response.data.data.forEach(friend => {
          if(friend.friend_name.toLowerCase().includes(this.search.toLowerCase())){
            this.friends.push(friend)
          }
        });
      });
    },
    request_response(user_response, id){
      this.$axios
      .post("http://127.0.0.1:8000/api/respondtorequest",
      {
          id: id,
          accepted: user_response
        })
        .then((response) => {
          this.$axios
      .get("http://127.0.0.1:8000/api/friendsrequests")
        .then((response) => {
        console.log(response.data.data)
          this.friend_requests = response.data.data;
        this.$axios
        .get("http://127.0.0.1:8000/api/getfriends")
        .then((response) => {
          this.friends = [];
          response.data.data.forEach(friend => {
            if (friend.friend_name.toLowerCase().includes(this.search.toLowerCase())) {
              this.friends.push(friend)
            }
          });
        });
      });
      });
    },
  },
};
</script>