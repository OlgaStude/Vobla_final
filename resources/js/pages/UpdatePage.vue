<template>
  <div class="container">
    <div class="update_user_div">
    <div>
    <h1>Редактирование профиля</h1>
    <p class="category_update_choose">Выберите категории</p>
    <div class="update_user_category_div">
    <div v-for="i in index" class="update_user_category_div2">
      <input @click="removeCategory($event)" v-if="categories[i - 1].users" checked type="checkbox" :value="categories[i - 1].name" name="category" :id="'box_' + i">
      <input @click="addCategory($event)" v-else type="checkbox" :value="categories[i - 1].name" name="category" :id="'box_' + i">
      <label :for="'box_' + i">{{ categories[i - 1].name }}</label> 
    </div>
    </div>
    <p class="update_user_success">{{ category_success }}</p>
    <label class="custom-file-upload input-file_update">
      <input @change="show_name()" class="file_upload update_user_input"  type="file" id="avatar" ref="avatar">
      <span id="file_selected">{{ file_name }}</span>
    </label>
    <p class="update_user_error">{{ errors.avatar[0] }}</p>
    <input type="text" v-model="user.name" class="update_user_input">
    <p class="update_user_error">{{ errors.name }}</p>
    <input type="text" v-model="personal.login" class="update_user_input">
    <p class="update_user_error">{{ errors.login[0] }}</p>
    <p class="update_user_success">{{ update_success }}</p>
    <button @click="update($event)" class="update_user_btn">Редактировать</button>
    </div>
    <div>
    <h1>Изменение пароля</h1>
    <input type="password" v-model="password_old" class="update_user_input" placeholder="Старый пароль">
    <p class="update_user_error">{{ errors.password_old }}</p>
    <input type="password" v-model="password_new" class="update_user_input" placeholder="Новый пароль">
    <p class="update_user_error">{{ errors.password_new[0] }}</p>
      <p class="update_user_success">{{ password_success }}</p>
    <button @click="changepassword($event)" class="update_user_btn">Изменить пароль</button>
  </div>
  </div>
  </div>
</template>

<style>

.file_upload{
    display: none;
}

.input-file_update{
    width: 508px;
    height: 54px;
    border: 2px solid black;
    border-radius: 50px;
    background-color: #D9D9D9 0%;
    font-size: 24px;
    font-family: 'text';
    color: black;
    display: block;
    text-align: center;
    padding-top: 9px;
    cursor: pointer;
    margin-top: 3%;
    margin-bottom: 4px;
    margin: auto;
    box-sizing: border-box;
    background-color: #fff;
    overflow: hidden;
}

.update_user_div {
  display: grid;
  grid-template-columns: 1fr 1fr;
  text-align: center;
}

.update_user_div {
  margin-top: 4%;
}

.update_user_category_div {
  display: flex;
  margin-left: 20%;
  margin-top: 5%;
  width: 540px;
  text-overflow: ellipsis;
  overflow-x: scroll;
  padding-bottom: 1%;
  margin-bottom: 5%;
}

.category_update_choose {
  font-size: 32px;
  margin-top: 5%;
  text-align: start;
  margin-left: 23%;
}

.update_user_category_div::-webkit-scrollbar {
            height: 2px;
        }
        .update_user_category_div::-webkit-scrollbar-track {
        background: #e8e8e8; 
        }
        .update_user_category_div::-webkit-scrollbar-thumb {
        background: #1D1A0F; 
        }

.update_user_category_div2 {
  display: flex;
  margin-left: 5%;
}

.update_user_category_div2 input {
  width: 25px;
  height: 25px;
  border: 2px solid black;
}

.update_user_category_div2 label {
  font-size: 24px;
  font-family: text;

}

.update_user_input {
  width: 508px;
  height: 54px;
  border: none !important;
  border-bottom: 2px solid black !important;
  border-radius: none;
  font-size: 24px;
  color: black;
  padding: 1%;
  margin-top: 5%;  
}

.update_user_btn {
  width: 508px;
  height: 52px;
  border: none;
  border-radius: 12px;
  background-color: #C2E6B9;
  font-size: 24px;
  color: white;
  margin-top: 5%;
  margin-bottom: 4%;
  cursor: pointer;
}

.update_user_error {
  font-size: 20px;
  color: #D22626;
  text-align: start;
  margin-left: 25%;
  margin-top: 2%;  
}

.update_user_success {
  font-size: 24px;
  color: black;
  margin-top: 5%;   
}

@media (max-width: 320px) {
  .category_update_choose {
    font-size: 8px;
  }


  .update_user_category_div {
    height: 40px;
    width: 100px;
    margin-left: 36%;
  }

  .update_user_category_div2 input {
  width: 8px;
  height: 8px;
  border: 1px solid black;
}

.update_user_category_div2 label {
  font-size: 8px;
  margin-left: 1%;
  font-family: text;
  position: relative;
  top: -2vh;
}

.update_user_input {
  width: 153px;
  height: 16px;
  border: 1px solid black;
  font-size: 8px;
}

.update_user_btn {
  width: 100px;
  height: 14px;
  font-size: 8px;
}

.update_user_error {
  font-size: 6px;
  margin-left: 28%;
  margin-top: 1%;
}

.update_user_success {
  font-size: 8px;
  margin-top: 2%;
  margin-bottom: 2%;
}

.input-file_update{
    width: 153px;
    height: 16px;
    border: 1px solid black;
    border-radius: 50px;
    font-size: 8px;
    padding-top: 3px;
    cursor: pointer;
    margin-top: 3%;
    margin-bottom: 4px;
}

}

</style>


<script>

export default {
  name: "Dashboard",
  data() {
    return {
      user: [],
      categories: [],
      index: 0,
      personal: window.Laravel.user,
      login: window.Laravel.user.login,
      password_old: '',
      password_new: '',
      password_success: '',
      category_success: '',
      update_success: '',
      errors: {
        name: null,
        avatar: [],
        login: [],
        password_old: null,
        password_new: [],
      },
      file_name: 'Фото профиля (необязательно)'
    };
  },
  created() {
    this.$axios
      .get("http://127.0.0.1:8000/api/userinfo")
      .then((response) => {
        this.user = response.data;

      });
      this.$axios
      .get("http://127.0.0.1:8000/api/categories")
        .then((response) => {
        console.log(response.data)
        this.categories = response.data.data;
        this.index = this.categories.length
      });
  },
  methods: {
    show_name() {
      this.file_name = this.$refs.avatar.files[0].name
    },
    update(e) {
      e.preventDefault()
      this.errors = {
        name: null,
        avatar: [],
        login: [],
        password_old: null,
        password_new: [],
      }
      this.update_success = ''
      if (!/^([A-Za-zА-Яа-я \-\_]+)$/.test(this.user.name)) {
        this.errors.name = 'В имени могут быть только буквы, дефис и пробелы'
      };
      let sendlogin = ''
      if (this.personal.login == this.login) {
        sendlogin = 'nonewlogin'
      } else {
        sendlogin = this.personal.login
      }
      this.$axios.post("http://127.0.0.1:8000/api/updateuser",
        {
          name: this.user.name,
          avatar: this.$refs.avatar.files[0],
          login: sendlogin,
        },
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      )
        .then((response) => {
          this.update_success = 'Данные обновлены'
          console.log(response.data);
          this.$axios
            .get("http://127.0.0.1:8000/api/userinfo")
            .then((response) => {
              this.user = response.data;
            });
        })
        .catch((err) => {
          if (err.response.data.errors.avatar) {
            this.errors.avatar = err.response.data.errors.avatar;
          }
          if (err.response.data.errors.login) {
            this.errors.login = err.response.data.errors.login;
          }

        });
    },
    changepassword(e) {
      e.preventDefault()
      this.errors = {
        name: null,
        avatar: [],
        login: [],
        password_old: null,
        password_new: [],
      }
      this.$axios.post("http://127.0.0.1:8000/api/changepassword",
        {
          password: this.password_old,
          new_password: this.password_new
        },
      )
        .then((response) => {
          console.log(response.data)
          if (response.data.status == 400) {
            this.errors.password_old = response.data.message
            this.personal.login = this.login
          } else {
            this.password_new = ''
            this.password_old = ''
            this.password_success = 'Пароль был обновлён'
          }
        })
        .catch((err) => {
           if (err.response.data.errors.new_password) {
            this.errors.password_new = err.response.data.errors.new_password;
          }

        });
    },
    addCategory(e) {
      this.category_success = ''
       this.$axios.post("http://127.0.0.1:8000/api/useraddcategory",
        {
          name: e.target.value,
        },
      )
         .then((response) => {
          this.$axios
            .get("http://127.0.0.1:8000/api/categories")
            .then((response) => {
              console.log(response.data)
              this.categories = response.data.data;
              this.index = this.categories.length
            });
         this.category_success = 'категория была добавлена в ваши категории'
        })
        .catch((err) => {
          

        });
    },
    removeCategory(e) {
      this.category_success = ''
      alert()
      this.$axios.post("http://127.0.0.1:8000/api/userremovecategory",
        {
          name: e.target.value,
        },
      )
        .then((response) => {
          this.categories = []
          this.$axios
            .get("http://127.0.0.1:8000/api/categories")
            .then((response) => {
              this.categories = response.data.data;
              this.index = this.categories.length
            });
          this.category_success = 'категория была убрана из ваших категорий'
        })
        .catch((err) => {


        });
    }
  },
};
</script>

