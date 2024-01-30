<template>
<div class="container">
    <div class="login_div">
    <h1>Авторизация</h1>
    <form>
      <input
        type="text"
        id="login"
        v-model="login"
        required
        autofocus
        placeholder="Логин"
      />
      <p>{{ errors.login[0] }}</p>
      <input
        type="password"
        id="password"
        v-model="password"
        required
        autofocus
        placeholder="Пароль"
      />
      <p>{{ errors.password[0] }}</p>
      </form>
      <p class="login_error">{{ errors.error }}</p>

    <button class="login_btn" type="submit" @click="handleSubmit">Авторизация</button>
    
  </div>

  </div>
</template>



<style>

.login_div {
  text-align: center;
  background: linear-gradient(90deg, #F8F8FF 0.02%, rgba(255, 237, 237, 0.07) 32.25%, rgba(241, 239, 212, 0.12) 70.03%, #DDF2B0 99.59%) !important;
}

.login_div h1 {
  position: relative;
  top: 10vh;

}

.login_div form {
  margin-top: 5%;
}

.login_btn {
  width: 582px;
  height: 52px;
  border-radius: 15px;
  border: none;
  font-size: 24px;
  background-color: #FAA5A5;
  color: white;
  margin-top: 2%;
  cursor: pointer;
  margin-bottom: 25%;
}

.login_error {
  font-size: 20px;
  color: #36522A;
  margin-top: 0.5%;
}



.with_us_login a {
  color: #FAA5A5;
  text-decoration: underline;
}

@media (max-width: 320px) {

  .login_error {
    font-size: 6px;
  }

  .login_btn {
    width: 74px;
    height: 14px;
    font-size: 8px;
  }

  .login_div form {
    margin-top: 6%;
  }

  .login_div h1 {
    top: 3vh;
  }

  .login_btn {
    width: 153px;
    margin-bottom: 120%;
    border-radius: 4px;
  }

  .login_div input {
    border: none;
    border-bottom: 1px solid black;
  }

}

</style>

<script>
export default {
  name: "Login",
  data() {
    return {
      login: "",
      password: "",
      errors: {
        'password': [],
        'login': [],
        'error': null
      },
    };
  },
  created() {},
  methods: {
    handleSubmit(e) {
      e.preventDefault();
      this.errors = {
        'password': [],
        'login': [],
        'error': null
      },
      this.$axios.get("/sanctum/csrf-cookie").then((response) => {
        this.$axios
          .post("api/login", {
            login: this.login,
            password: this.password,
          })
          .then((response) => {
            console.log(response.data)
            if (response.data.status == 200) {
              window.location.href = "/user/" + response.data.user_id;
            } else {
              this.errors.error = response.data.message;
            }
          })
         .catch((err) => {
              if (err.response.data.errors.password) {
                this.errors.password = err.response.data.errors.password;
              }
              if (err.response.data.errors.login) {
                this.errors.login = err.response.data.errors.login;
              }

            });
      });
    },
  },
  beforeRouteEnter(to, from, next) {
    if (IsLogged) {
      return next("user/" + window.Laravel.user.id);
    }
    next();
  },
};
</script>