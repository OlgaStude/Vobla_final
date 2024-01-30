<template>
    <div class="container">
    <div class="user_info">
    <div class="user_info_upper">
    <img :src="'/storage/profile_pics/'+page_owner.avatar" class="owner_img" style="width: 125px; height: 125px; border-radius: 100%;">
    <p class="user_info_name_text">{{ page_owner.name }}</p>
        <div  v-if="user.users_id == page_owner.users_id" class="info_buttons">
        <a href="/updateinfo"><button class="profile_update_btn">Редактировать</button>
        </a>
        <br>
        <button @click="deleteUser()" class="profile_delete_btn">Удалить профиль</button>
      </div>
      <button v-else-if="!is_a_friend && user != []" @click="send_request" class="add_friend_profile_btn">Добавить в друзья</button>
    
      <div v-else-if="user != []" class="info_buttons">
        <a :href="$router.resolve({ name: 'Chat', params: { id: page_owner.user_id } }).href"><button class="write_friend_profile_btn">Написать</button></a>
        <br>
        <button @click="deleteFriend" class="delete_friend_profile_btn">Удалить из друзей</button>
      </div>
    </div>
        <div>
          <p class="info_category_chosen">Выбранные категории</p> 
          <div class="info_category_div">
            <div v-for="user_category in page_owner.categories" class="info_category">
              <p>{{ user_category.name }}</p>
            </div>
          </div> 
        </div>
        <button @click="open_form" class="post_write_btn">Написать пост</button>
    </div>
    

    

  <div v-if="user.users_id == page_owner.users_id && form_is_on" id="create_posts_div">
        <h1>Создание поста</h1>
        <div class="post_create_div">
    <div>
    <div class="div_border" placeholder="Веедите текст поста" @keyup="image_delete($event)" @paste="link_ut($event)" id="img-from-local-storage" contenteditable="true">
      Введите текст поста
    </div>
    <p>{{ errors.body }}</p>
    <p>{{ success_message }}</p>
    <!-- <iframe src="https://www.youtube.com/embed/27szVGikYH4??showinfo=0&controls=0&modestbranding=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen width="560" height="315"
      ></iframe> -->
      <p>{{ errors.image }}</p>
      <label class="custom-file-upload input-file_new">
        <input @change="save_img" class="file_upload post_write_img"  type="file" id="bannerImg" ref="img">
        <span id="file_selected">{{ file_name }}</span>
      </label>
    <div class="post_write_btns_div">
    <button @click="makePost" class="post_write_btn">Создать пост</button>
    <button @click="close_form" class="post_close_btn">Закрыть</button>
    </div>
  </div>
          <div class="category_div_post">
          <p class="post_create_category_choose">Выберите категории</p>
          <div class="register_category_div post">
            <div v-for="i in index" class="register_category_div2">
            <input class="post_write_img" type="checkbox" :value="categories[i - 1].name" name="category" :id="'box_' + i">
            <label :for="'box_' + i">{{ categories[i - 1].name }}</label> 
        </div>
        </div>
        <p>{{ errors.category_name }}</p>
        </div>
    </div>
  </div>
  <div v-else-if="user.users_id == page_owner.users_id" class="post_control_div">
  <h1>Публикации</h1>
  </div>

<!-- Нежная экосистемма !не трогать! -->
<div class="post_main_container">
  <div class="post_user post_div_user" v-for="post of posts">
    <div class="post_user_container">

      <div class="post_user_info user_post_info">
        <img class="post_user_avatar" :src="'/storage/profile_pics/' + post.user_avatar" >
        <p class="post_user_name">{{ post.user_name }}</p>
        <p class="post_user_time">{{ post.time }}</p>
      </div>

      <div class="save_change_btn update_post_category_div">
        <div v-for="i in index" class="update_post_category_div2">
          <input v-if="post.categories.filter(e => e.name === categories[i - 1].name).length > 0" checked type="checkbox" :value="categories[i - 1].name" name="category_update" :id="'box_update_' + i">
          <input v-else type="checkbox" :value="categories[i - 1].name" name="category_update" :id="'box_update_' + i">
          <label :for="'box_update_' + i">{{ categories[i - 1].name }}</label>
        </div>
    </div>
      <dt class="dt_modify dt_modify_user" @paste="link_ut" @keyup="image_delete_modify($event)" contenteditable="true" v-html="old_body"></dt>
      <dt class="dt_not_modify dt_not_modify_user" v-html="post.body"></dt>

    </div>
    <div>
      <div class="save_change_btn">
        <p>{{ errors.modify_image }}</p>
        <p>{{ errors.modify_body }}</p>
        <p>{{ errors.modify_category_name }}</p>
      </div>
      <label v-if="user.users_id == page_owner.users_id" class="custom-file-upload input-file_modify save_change_btn">
        <input @change="save_img_modify($event, post.imgs)" class="file_upload"  type="file" id="modifyImg" ref="img_modify">
        <span id="file_selected">{{ file_name_modify }}</span>
      </label>
      <button v-if="user.users_id == page_owner.users_id" class="save_change_btn save_change_btn2" @click="save_change($event, post.id)">Сохранить редактирование</button>
      <button v-if="user.users_id == page_owner.users_id" class="modify_btn" @click="modify_post($event, post.imgs, post.category_name)">Редактировать пост</button>
      <button v-if="user.users_id == page_owner.users_id" class="save_change_btn cancel_change_btn" @click="cancel_modify($event)" >Отменить редактирование</button>
      <button v-if="user.users_id == page_owner.users_id" @click="delete_post($event, post.id)" class="delete_post_btn">Удалить пост</button>
    </div>
  </div>
  </div>
  </div>
</template>

<style>
.container{
  overflow-x: hidden;

}
.file_upload{
    display: none;
}

.input-file_new{
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
    padding-top: 7px;
    cursor: pointer;
    margin-top: 5%;
    margin-bottom: 4px;
    box-sizing: border-box;
    background-color: #fff;
    overflow: hidden;
}
.input-file_modify{
    display: none;
    width: 333px;
    height: 54px;
    border: 2px solid black;
    border-radius: 50px;
    background-color: #D9D9D9 0%;
    font-size: 24px;
    font-family: 'text';
    color: black;
    display: block;
    text-align: center;
    padding-top: 7px;
    cursor: pointer;
    margin-top: 3%;
    margin-bottom: 4px;
    box-sizing: border-box;
    background-color: #fff;
    overflow: hidden;
}

.post_user_name{
  width: 80px;
}
.post_div_user{
  width: 100%;
  margin-bottom: 20px;
  height: fit-content;
  break-inside: avoid;

}
.div_border{
  border: 1px solid black;
  border-radius: 12px;
  padding: 20px;
  height: 100px;
}
.div_border img{
  width: 100%;
}
.save_change_btn{
  display: none;
}
.dt_modify{
  display: none;
}

.last_posts{
  font-size: 48px;
  margin-top: 56px;
  margin-left: 225px;
  margin-bottom: 46px;
}

.user_post_info{
  display: flex;
  align-items: center;
  column-gap: 16px;
  margin-bottom: 22px;
}
.post_user_name{
  font-size: 20px;
}
.post_user_time{
  font-size: 14px;
  color: #828282;
}
.post_user_avatar_main{
  width: 44px;
  height: 44px;
  border-radius: 30px;
}
.post_user_container {
  width: 333px;
  margin: 0;
  display: grid;
  grid-template-rows: 1fr auto;
  margin-bottom: 24px;
  border: 0;
  break-inside: avoid;
  border-radius: 12px;
}
.post_user_container:nth-child(1n){
  box-shadow: 0px -7px 11px 3px #FFEAEF
}
.post_user_container:nth-child(2n){
  box-shadow: 0px -7px 11px 3px #FCEBE2
}
.post_user_container:nth-child(3n){
  box-shadow: 0px -7px 11px 3px #F8F4CE
}
.post_user_container:nth-child(4n){
  box-shadow: 0px -7px 11px 3px #E4F4B9
}
.post_user_container:nth-child(5n){
  box-shadow: 0px -7px 11px 3px rgba(205, 180, 229, 0.25)
}

.dt_modify{
  padding: 30px;
}
.dt_modify img, iframe{
  width: calc(100% + 30px);
  margin-left: 20px; 
}

dt{
  border-radius: 12px;
  padding-left: 21px;
  padding-bottom: 10px;
}
.user_post_info{
  padding-top: 23px;
  padding-left: 21px;

}

.post_user_container dt img, iframe{
  width: calc(100% + 20px);
  margin-left: -22px; 
}

.post_user_container a {
  color: black;
  text-decoration: none;
}

.post_main_container {
  margin: auto;
  margin-bottom: 30px;
  padding-top: 20px;
  width: 1470px;
  column-count: 4;
  column-gap: 10px;
}


.info_category_div {
  margin-top: -1%;
  display: flex;
  margin-right: 15%;
  font-size: 32px;
  text-overflow: ellipsis;
  overflow-x: scroll;
  width: 400px;
}

.post {
  margin-left: -1%;
  text-align: start;
}

.info_category_div::-webkit-scrollbar {
            height: 2px;
        }
        .info_category_div::-webkit-scrollbar-track {
        background: #e8e8e8; 
        }
        .info_category_div::-webkit-scrollbar-thumb {
        background: #1D1A0F; 
        }


.info_category_chosen {
  margin-top: 2%;
  font-size: 24px;
}

.info_category {
  margin-left: 5%;
}

.profile_update_btn {
  
  width: 267px;
  height: 54px;
  border-radius: 15px;
  font-size: 24px;
  font-family: text;
  background-color: #C2E6B9;
  color: white;
  border: none;
  cursor: pointer;
}

.profile_delete_btn {
  width: 214px;
  height: 54px;
  border-radius: 15px;
  font-size: 24px;
  font-family: text;
  background-color: #FAA5A5;
  color: white;
  border: none;
  cursor: pointer; 
}

.info_buttons {
  width: 1200px;
  margin-left: 2%;
  margin-top: 1.5%;
  column-gap: 25%;
  display: flex;
}

.post_control_div {
  text-align: start;
  margin-left: 2%;
}

.post_control_div h1 {
  margin-top: 5%;
}

.post_write_btn {
  width: 267px;
  height: 54px;
  border-radius: 12px;
  font-size: 24px;
  font-family: text;
  background-color: #C2E6B9;
  color: white;
  border: none;
  cursor: pointer;
  margin-top: 2%;  
}

.category_div_post {
  margin-top: 1%;
  margin-left: 5%;
}

.post_create_div {
  display: flex;
}

.div_border {
  width: 697px;
  height: fit-content;
  border-radius: 50px;
  text-align: start;
  font-size: 24px;
  margin-top: 5%;
}

#create_posts_div {
  margin-left: 2%;
  margin-top: 4%;
}

.post_write_img {
  margin-top: 2%;
  width: 508px;
  height: 54px;
  border-radius: 50px;
  border: 2px solid black;
  background-color: #D9D9D9 0;
}

.post_close_btn {
  width: 328px;
  height: 50px;
  border-radius: 15px;
  font-size: 24px;
  font-family: text;
  background-color: #FAA5A5;
  color: white;
  border: none;
  cursor: pointer; 
  margin-top: 2%;
  margin-left: 2%;
}

.add_friend_profile_btn, .write_friend_profile_btn {
  width: 328px;
  height: 50px;
  border-radius: 15px;
  font-size: 24px;
  font-family: text;
  background-color: #C2E6B9;
  color: white;
  border: none;
  cursor: pointer;
  margin-top: 2%;   
}

.delete_friend_profile_btn {
  width: 214px;
  height: 54px;
  border-radius: 15px;
  font-size: 24px;
  font-family: text;
  color: white;
  background-color: #FAA5A5;
  border: none;
  cursor: pointer; 
}

.add_friend_profile_btn {
  margin-left: 42%;
}

.post_create_category_choose {
  margin-top: 1%;
  font-size: 24px;
}

.modify_btn, .save_change_btn2 {
  width: 328px;
  height: 50px;
  border-radius: 15px;
  border: none;
  background-color: #C2E6B9;
  color: white;
  font-size: 24px;
  margin-top: 4%;
}
.post_user_avatar{
    height: 60px;
    width: 60px;
    margin-right: 10px;
    border-radius: 100%;
  }

.delete_post_btn, .cancel_change_btn {
  width: 328px;
  height: 50px;
  border-radius: 15px;
  border: none;
  background-color: #FAA5A5;
  color: white;
  font-size: 24px;
  margin-top: 4%;
}

.change_img_btn {
  width: 431px;
  height: 56px;
  border-radius: 50px;
  border: 2px solid black;
  font-size: 24px;
}

.update_post_category_div {
  justify-content: center;
  margin-left: 25%;
  margin-top: 1%;
  width: 250px;
  text-overflow: ellipsis;
  overflow-x: scroll;
  padding-left: 10%;
  padding-bottom: 1%;
}

.update_post_category_div::-webkit-scrollbar {
            height: 2px;
        }
        .update_post_category_div::-webkit-scrollbar-track {
        background: #e8e8e8; 
        }
        .update_post_category_div::-webkit-scrollbar-thumb {
        background: #1D1A0F; 
        }

.update_post_category_div2 {
  margin-left: 8%;
}

.update_post_category_div2 input {
  width: 25px;
  height: 25px;
  border: 2px solid black;
  margin-left: 50%;
  transform: translateX(-50%);
}

.update_post_category_div2 label {
  font-size: 20px;
  font-family: text;
  
}

@media (max-width: 320px) {
  .post_main_container {
    margin: auto;
    margin-bottom: 30px;
    padding-top: 20px;
    width: 320px;
    columns: 1;
    column-gap: 10px;
  }
  .post_main_container button{
    width: 320px;
    height: 30px;
    margin-left: 0;
    font-size: 16px;
  }
  iframe{
    height: 100px;
  }

  .info_buttons {
    column-gap: 2%;
  }

  .user_info {
    width: 243px;
    height: 143px;
    margin-left: 10%;
    margin-top: 4%;
    column-gap: 10px;
  }
  .user_info_div {
    width: 43px;
    height: 143px;
    margin-left: 1%;
    margin-top: 4%;
  }

  .owner_img {
    height: 50px !important;
    width: 50px !important;
  }

  .post_control_div {
    text-align: center;
    margin-top: 15%;
  }

  .info_div1 {
    margin-top: 25%;
    margin-left: 5%;
  }

  .info_div2 {
    margin-top: 15%;
    margin-left: 5%;
  }

  .user_info_name_title, .user_info_login_title {
    font-size: 8px;
  }

  .user_info_name_text, .user_info_login_text {
    font-size: 10px;
  }

  .info_category_chosen {
    font-size: 8px;
    margin-bottom: 4%;
    margin-top: 15%;
    margin-left: 5%;
    width: 100px;
  }

  .info_category_div {
    margin-left: 2%;
    margin-top: 5%;
    width: 120px;
  }

  .info_category p {
    font-size: 10px;
  }

  .post_create_div{
    flex-direction: column;

  }


  .profile_update_btn, .profile_delete_btn {
    width: 98px;
    height: 16px;
    font-size: 8px;
    border-radius: 4px
  }

  .profile_delete_btn {
    width: 75px;
    margin-top: 2.5%;
  }

  .post_create_category_choose {
    margin-right: 5%;
    font-size: 8px;
  }

  .div_border {
    width: 192px;
    height: 80px;
    font-size: 8px;
    border-radius: 20px;
    padding: 3%;
    margin-left: 20%;
  }

  .post_write_btn, .post_close_btn {
    width: 98px;
    height: 16px;
    font-size: 8px;
  }

  .post_write_btn {
    margin-left: 2%;
  }

  #create_posts_div {
    text-align: center;
  }

  #create_posts_div p { 
    font-size: 8px;
    margin-right: 5%;
  }

  .post_close_btn {
    margin-left: 0.1%;
  }

  .post_write_btns_div {
    width: 100%;
    text-align: center;
    display: flex;
    column-gap: 2%;
    margin-left: 15%;
  }

  .post {
    margin-top: 4%;
    margin-left: 24%;
    width: 150px;
  }

  .add_friend_profile_btn, .delete_friend_profile_btn, .write_friend_profile_btn {
    width: 98px;
    height: 16px;
    font-size: 8px;
  }

  .add_friend_profile_btn {
    margin-left: 33%;
  }

  .post_user_name{
    width: 30px;
  }
  .post_user_time{
    display: none;
  }
  .user_post_info{
    column-gap: -10px;
  }
  .post_user {
    width: 151px;
  }
  .post_user_avatar{
    height: 20px;
    width: 20px;
    margin-right: 10px;
    border-radius: 100%;
  }

  .modify_btn, .delete_post_btn, .save_change_btn2, .cancel_change_btn {
    width: 125px;
    height: 16px;
    font-size: 8px;
    margin-left: 12%;
    border-radius: 4px;
  }

  .input-file_new{
    width: 100%;
    height: 16px;
    border: 1px solid black;
    border-radius: 50px;
    font-size: 8px;
    padding-top: 3px;
    cursor: pointer;
    margin: 10px auto;
    margin-bottom: 4px;
  }

  .input-file_modify{
    width: 320px;
    height: 30px;
    border: 1px solid black;
    border-radius: 50px;
    font-size: 16px;
    padding-top: 3px;
    cursor: pointer;
    margin: 0;
    margin-bottom: 4px;
  }

  .update_post_category_div {
  justify-content: center;
  margin-top: 1%;
  width: 150px;
  height: 37px;
  text-overflow: ellipsis;
  overflow-x: scroll;
  padding-left: 2%;
  padding-bottom: 1%;
}

.update_post_category_div::-webkit-scrollbar {
            height: 1px;
        }
        .update_post_category_div::-webkit-scrollbar-track {
        background: #e8e8e8; 
        }
        .update_post_category_div::-webkit-scrollbar-thumb {
        background: #1D1A0F; 
        }

.update_post_category_div2 {
  margin-left: 8%;
}

.update_post_category_div2 input {
  width: 8px;
  height: 8px;
  border: 2px solid black;
  margin-left: 45%;
  transform: translateX(-50%);
}

.update_post_category_div2 label {
  font-size: 8px;
  font-family: text;
  position: relative;
  bottom: 2vh;
}

.dt_modify{
  padding: 40px;

}
dt.dt_not_modify_user, dt.dt_modify_user{
  width: 100%;
  line-height: 15px;
  margin-bottom: 0;
}

.div_border {
  height: fit-content;
}

}

</style>

<script>
export default {
  name: "Dashboard",
  data() {
    return {
      imgs: [],
      img_names: [],
      modify_imgs: [],
      modify_imgs_names: [],
      modify_new_imgs: [],
      categories: [],
      posts: [],
      friend_requests: [],
      index: 0,
      categories_make: [],
      category_make_update: [],
      old_body: '',
      is_in_update: false,
      errors: {
        image: null,
        body: null,
        category_name: null,
        modify_category_name: null,
        modify_image: null,
        modify_body: null,
      },
      success_message: '',
      user: [],
      page_owner: [],
      is_a_friend: false,
      form_is_on: false,
      login: '',
      file_name: 'Выберите изображение',
      file_name_modify: 'Выберите изображение',
    };
  },
  created() {
    this.$axios
      .get("http://127.0.0.1:8000/api/categories")
        .then((response) => {
        console.log(response.data)
        this.categories = response.data.data;
        this.index = this.categories.length
      });
      this.$axios
      .post("http://127.0.0.1:8000/api/getpostsuserpage",
      {
          id: window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
        })
        .then((response) => {
        console.log(response.data.data)
        this.posts = response.data.data
      });
      localStorage.setItem('image', '');
      this.$axios
      .get("http://127.0.0.1:8000/api/userinfo")
      .then((response) => {
        this.user = response.data;

      });
      this.$axios
      .post("http://127.0.0.1:8000/api/otheruserinfo",
      {
          id: window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
        })
      .then((response) => {
        this.page_owner = response.data;
        this.page_owner.categories.forEach((category, i) => {
          if (!category.users) {
            this.page_owner.categories.splice(i, 1)
          }
        });
        if (!this.page_owner.categories[this.page_owner.categories.length - 1].users) {
          this.page_owner.categories.splice(this.page_owner.categories.length - 1)
        }
        if (!this.page_owner.categories[0].users) {
          this.page_owner.categories.splice(0, 1)
        }
      });
      this.$axios
      .post("http://127.0.0.1:8000/api/friendcheck",
      {
          id: window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
        })
      .then((response) => {
        this.is_a_friend = response.data;

      });
    if (IsLogged) {
        this.login = window.Laravel.user.login
      }
  },
  methods: {
    deleteUser() {
      this.$axios
        .post("http://127.0.0.1:8000/api/deleteuser")
        .then((response) => {
           window.location.href = "/"
        });
    },
    open_form(){
      this.form_is_on = true
    },
    close_form(){
      this.form_is_on = false
      this.file_name = 'Выберите изображение'      
    },
    deleteFriend(){
      this.$axios
      .post("http://127.0.0.1:8000/api/deletefriend",
      {
          id: this.page_owner.id
        })
        .then((response) => {
        this.is_a_friend = false;
        console.log(response.data)
      });
    },
    send_request(){
      this.$axios
      .post("http://127.0.0.1:8000/api/sendrequest",
      {
          id: this.page_owner.id
        })
        .then((response) => {
      });
    },
    
    save_img(){
      this.errors.image = ''
      this.file_name = this.$refs.img.files[0].name


      if(this.$refs.img.files[0].name.includes('.jpg') || this.$refs.img.files[0].name.includes('.jpeg') || this.$refs.img.files[0].name.includes('.png')){
      if(this.imgs.length < 5){

      const image = this.$refs.img.files[0];
      this.img_index++;
      this.imgs.push(image)
      let reader = new FileReader();

      reader.addEventListener('load', () => {
        
        localStorage.setItem('image', reader.result);
        });

      if (image) {
        reader.readAsDataURL(image);
      }
      let newImage = document.createElement(
        'img',
      );
      const br = document.createElement(
        'br',
      );
      
      setTimeout(() => {
        newImage.src = localStorage.getItem('image');

      document.getElementById('img-from-local-storage').append(br)
      document.getElementById('img-from-local-storage').append(newImage)
      this.img_names.push(document.getElementById('img-from-local-storage').children[document.getElementById('img-from-local-storage').children.length - 1].src)
      localStorage.setItem('image', '');
        }, "1000");
          
      }else{
      this.errors.image = 'Превышен лимит фотографий в посте'
        }
      } else {
        this.errors.image = 'Не верный формат изображения'
      }
    },
    image_delete(e){
      this.img_names.forEach((name, i) => {
        if(!document.getElementById('img-from-local-storage').innerHTML.includes(name.slice(0, 300))){
          this.imgs.splice(i,1)
          this.img_names.splice(i,1)
        }
      
      });
      console.log(this.img_names)
    },
    link_ut(e){
      if((e.clipboardData).getData("text").includes('www.')){
        e.preventDefault()
        e.target.innerHTML
        let paste = (e.clipboardData).getData("text");
        paste = paste.replace('/watch?v=', '/embed/');
        if(paste.includes('&')){
          paste = paste.replace(paste.slice(paste.indexOf('&')), '')
        }
        const selection = window.getSelection();
        if (!selection.rangeCount) return;
        selection.deleteFromDocument();
        let iframe = document.createElement('iframe');
        iframe.src = paste
        selection.getRangeAt(0).insertNode(iframe);
        selection.collapseToEnd();
      }
    },
    onChangeCategory(e) {
      if (e.target.value != 'Выберите категорию') {
        this.category_name = e.target.value 
      } else {
        this.category_name = ''
      }
    },
    onChangeCategoryUpdate(e) {
        this.category_name_update = e.target.value 
    },
    makePost(e){
      e.preventDefault()
      let ele = document.getElementsByName("category");
      for (var i = 0; i < ele.length; i++) {
        if (ele[i].checked) {
          this.categories_make.push(ele[i].value)
        }
      }
      this.success_message = ''
      this.errors = {
        body: null,
        category_name: null
      }
      let body = document.getElementById('img-from-local-storage').innerHTML
     console.log(body)
      this.$axios.post("http://127.0.0.1:8000/api/makepost",
        {
          body: body,
          categories: this.categories_make,
          imgs: this.imgs
        },
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
      )
        .then((response) => {
          console.log(response.data)
          document.getElementById('img-from-local-storage').innerHTML = 'Введите текст поста'
          this.success_message = 'Пост был создан'
          for (var i = 0; i < ele.length; i++) {
          if (ele[i].checked) {
            ele[i].checked = false
          }
        }
         this.$axios
            .post("http://127.0.0.1:8000/api/getpostsuserpage",
              {
                id: window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
              })
            .then((response) => {
              console.log(response.data.data)
              this.posts = response.data.data
            });
        })
        .catch((err) => {
          console.log(err.response.data)
          if (err.response.data.errors.body) {
            this.errors.body = err.response.data.errors.body[0];
             
          }
          if (err.response.data.errors.categories) {
            this.errors.category_name = err.response.data.errors.categories[0];
          }

        });
    },
    delete_post(e, id){
      e.preventDefault()
      this.success_message_change = ''
      this.$axios.post("http://127.0.0.1:8000/api/deletepost",
        {
          id: id
        }
      )
        .then((response) => {
          this.$axios
      .post("http://127.0.0.1:8000/api/getpostsuserpage",
      {
          id: window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
        })
        .then((response) => {
        console.log(response.data.data)
          this.posts = response.data.data
        this.cancel_modify()
      });
        })
      
    },
    modify_post(e, imgs, category_name){
      document.querySelectorAll('.save_change_btn').forEach(el => {
        el.style.display = 'none'
      })
      document.querySelectorAll('.dt_modify').forEach(el => {
        el.style.display = 'none'
      })
      document.querySelectorAll('.modify_btn').forEach(el => {
        el.style.display = 'inline-block'
      })
      document.querySelectorAll('.dt_not_modify').forEach(el => {
        el.style.display = 'block'
      })
      this.errors.modify_image = ''
      this.errors.modify_body = ''
      this.errors.modify_category_name = ''
      this.category_make_update = []
      this.modify_imgs = imgs
      this.modify_new_imgs = []
      this.file_name = 'Выберите изображение'
      this.old_body = e.target.parentElement.previousElementSibling.children[3].innerHTML
      e.target.style.display = 'none'
      e.target.nextElementSibling.style.display = 'inline-block'
      e.target.previousElementSibling.style.display = 'inline-block'
      e.target.previousElementSibling.previousElementSibling.style.display = 'inline-block'
      e.target.previousElementSibling.previousElementSibling.previousElementSibling.style.display = 'inline-block'
      e.target.parentElement.previousElementSibling.children[1].style.display = 'flex'
      e.target.parentElement.previousElementSibling.children[2].style.display = 'block'
      e.target.parentElement.previousElementSibling.children[3].style.display = 'none'

    },
    cancel_modify(e){
      document.querySelectorAll('.save_change_btn').forEach(el => {
        el.style.display = 'none'
      })
      document.querySelectorAll('.dt_modify').forEach(el => {
        el.style.display = 'none'
      })
      document.querySelectorAll('.modify_btn').forEach(el => {
        el.style.display = 'inline-block'
      })
      document.querySelectorAll('.dt_not_modify').forEach(el => {
        el.style.display = 'block'
      })
      this.errors.modify_image = ''
      this.modify_imgs = []
      this.modify_new_imgs = []
      this.category_name_update = ''
      this.old_body = ''
    },
    image_delete_modify(e){
      this.modify_imgs.forEach((name, i) => {
        if(!e.target.innerHTML.includes(name)){
          this.modify_imgs.splice(i,1)
        }
      });
      this.modify_imgs_names.forEach((name, i) => {
        if(!e.target.innerHTML.includes(name)){
          this.modify_imgs_names.splice(i,1)
        }
      });
      console.log(this.modify_imgs)
      console.log(this.modify_imgs_names)
    },
    save_img_modify(e, imgs) {
      this.errors.modify_image = ''
      if(e.target.files[0].name.includes('.jpg') || e.target.files[0].name.includes('.jpeg') || e.target.files[0].name.includes('.png')){
      if(this.modify_new_imgs.length + this.modify_imgs.length < 5){

        this.file_name_modify = e.target.files[0].name
        const image = e.target.files[0];
        this.modify_new_imgs.push(image)
        let reader = new FileReader();

        reader.addEventListener('load', () => {

          localStorage.setItem('new_image', reader.result);
        });

        if (image) {
          reader.readAsDataURL(image);
        }
        let newImage = document.createElement(
          'img',
        );
        const br = document.createElement(
          'br',
        );
        const p = document.createElement(
          'p',
        );
        p.innerHTML = ' '

        setTimeout(() => {
          newImage.src = localStorage.getItem('new_image');

          e.target.parentElement.parentElement.previousElementSibling.children[2].append(br)
          e.target.parentElement.parentElement.previousElementSibling.children[2].append(newImage)
          e.target.parentElement.parentElement.previousElementSibling.children[2].append(br)
          this.modify_imgs_names.push(e.target.parentElement.parentElement.previousElementSibling.children[2].children[e.target.parentElement.parentElement.previousElementSibling.children[2].children.length - 2].src)
          localStorage.setItem('new_image', '');
        }, "1000");

        }else{
          this.errors.modify_image = 'Превышен лимит фотографий в посте'
        }
      } else {
          this.errors.modify_image = 'Не верный формат изображения'

        }
    },
    save_change(e, id){
      e.preventDefault()
      this.errors.modify_image = ''
      this.errors.modify_body = ''
      this.errors.modify_category_name = ''
        console.log(this.modify_new_imgs)
      let ele = e.target.parentElement.previousElementSibling.children[1].children;
      for (var i = 0; i < ele.length; i++) {
        if (ele[i].children[0].checked) {
          this.category_make_update.push(ele[i].children[0].value)
        }
      }
      this.$axios.post("http://127.0.0.1:8000/api/updatepost",
        {
          body: e.target.parentElement.previousElementSibling.children[2].innerHTML,
          categories: this.category_make_update,
          imgs: this.modify_new_imgs,
          old_imgs: this.modify_imgs,
          id: id
        },
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
      )
        .then((response) => {
          console.log(response.data)
          this.$axios
      .post("http://127.0.0.1:8000/api/getpostsuserpage",
      {
          id: window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
        })
        .then((response) => {
        console.log(response.data.data)
        this.posts = response.data.data
      });
      this.cancel_modify()
        })
        .catch((err) => {
        console.log(err.response.data.errors)
          if (err.response.data.errors.body) {
            this.errors.modify_body = err.response.data.errors.body[0];
          }
          if (err.response.data.errors.categories) {
            this.errors.modify_category_name = err.response.data.errors.categories[0];
          }

        });
    }

    
  },

  
};
</script>