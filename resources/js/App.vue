<template>
  <div class="container">
    <div class="navbar">
    <div class="navbar-bav" v-if="isLogged">
      <div class="logo_div">
      <a href="/"><img src="/storage/img/logo.png"></a>
      <p>Вся стая рядом</p>
      </div>
        <div class="user_nav_div">
      <a href="/chats"><img src="/storage/img/chats.png"></a>
      <a href="/friends"><img src="/storage/img/friends.png"></a>
      <a href="/admin" v-if="is_admin == 1" class="admin_icon"><img src="/storage/img/admin.png" class="admin_icon_aaa"></a>
      <a href="#" @click="logout" class="logout_icon"><img src="/storage/img/logout.png" class="logout_icon_aaa"></a>
      <a :href="$router.resolve({ name: 'userPage', params: { id: user.id } }).href" class="user_avatar_a"><img :src="'/storage/profile_pics/' + user.avatar" class="user_avatar"></a>
        </div>
      </div>
    <div class="navbar-bav" v-else>
      <div class="logo_div">
      <a href="/"><img class="logo" src="/storage/img/logo.png"></a>
      <p>Вся стая рядом</p>
      </div>
      <div class="login_register_div">
      <a href="/login" class="login_nav">Авторизация</a>
      <a href="/registration">Регистрация</a>
      </div>

    </div>

    </div>
    <div class="navbar_gradient"></div>
    <router-view></router-view>
  </div>
</template>

<style>


a {
  text-decoration: none;
}

.navbar {
  
  height: 165px;
}

.navbar_gradient {
  height: 30px;
  background: linear-gradient(90deg, #F8F8FF 0%, #FFEDED 32.37%, #F1EFD4 66.67%, #DDF2B0 100%);
}

.login_register_div {
  text-align: end;
  position: relative;
  bottom: 3vh;
  margin-right: 225px;
}

.navbar-bav {
  position: relative;
  top: 3vh;
}

.login_register_div a {
  margin-right: 3%;
  font-size: 32px;
  color: black;
}

.logo_div {
  display: flex;
  font-size: 32px;
  margin-left: 225px;
  padding-top: 10px;
  top: 2vh;
}

.logo_div p {
  margin-left: 2%;
  width: 150px;
  text-align: center;
}

.user_avatar {
  width: 80px;
  height: 80px;
  border-radius: 100%;
  position: relative;
  top: 2vh;
}

.user_avatar_a {
  bottom: 3vh !important; 
  margin-right: 225px !important;
}

.admin_icon {
  bottom: 2.5vh !important;
}

.user_nav_div {
  text-align: end;
  position: relative;
  bottom: 5vh;
}

.user_nav_div a {
  margin-right: 6%;
  font-size: 32px;
  color: black;
  position: relative;
  bottom: 2vh;
}

.logout_icon {
  bottom: 3vh !important; 
}



@media (max-width: 320px) {

  .user_avatar_a {
    margin-right: 25px !important;
  }

.navbar {
  height: 69px;
}

.navbar_gradient {
  height: 10px;
}

.logo_div {
  margin-left: 20px;
}

.logo_div img {
  width: 25px;
  height: 25px;
  position: relative;
  bottom: 1vh;
}

.logo_div p {
  font-size: 10px;
  position: relative;
  width: 50px;
}

.login_register_div {
  bottom: 5vh;
}

.login_register_div a {
  font-size: 10px;
}


.user_nav_div img {
  width: 25px;
  height: 25px;
}

.logout_icon_aaa, .admin_icon_aaa {
  width: 18px !important;
  height: 18px !important;
}

.user_avatar {
  width: 30px !important;
  height: 30px !important;
}

}

</style>

<script>
export default {
  name: "App",
  data() {
    return {
      isLogged: false,
      user: [],
      is_admin: false
    };
  },
  created() {
    if (IsLogged) {
      this.isLogged = true;
      this.is_admin = window.Laravel.user.is_admin
      this.$axios
        .get("http://127.0.0.1:8000/api/userinfo")
        .then((response) => {
          this.user = response.data;
          console.log(this.user)

        });
    }
  },
  methods: {
    logout(e) {
      e.preventDefault();
      this.$axios.get("/sanctum/csrf-cookie").then((response) => {
        this.$axios
          .post("/api/logout")
          .then((response) => {
              window.location.href = "/";

          })
          .catch(function (error) {
            console.error(error);
          });
      });
    },
  },
};
</script>