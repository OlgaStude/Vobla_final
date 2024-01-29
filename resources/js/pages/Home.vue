<template>
  <div class="container">
    <h1 class="last_posts">Последние публикации</h1>
    <div class="post_main_container">
      <div v-for="post of posts" class="inside_div">
        <div class="user_post_info">
          <a :href="$router.resolve({ name: 'userPage', params: { id: post.user_id } }).href"><img class="post_user_avatar_main" :src="'/storage/profile_pics/'+post.user_avatar"></a> 
          <a class="post_user_name" :href="$router.resolve({ name: 'userPage', params: { id: post.user_id } }).href"><p>{{ post.user_name }}</p></a>
          <p class="post_user_time">{{ post.time }}</p>
        </div>
        <dt class="dt_not_modify" v-html="post.body"></dt>
      </div>
    </div>

  </div>
</template>

<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

@font-face {
  font-family: text;
  src: url(../../../storage/app/public/fonts/FiraSansCondensed-Regular.ttf);
}

@font-face {
  font-family: title;
  src: url(../../../storage/app/public/fonts/FiraSansCondensed-SemiBold.ttf);
}

.user_post_info{
  display: flex;
}
.post_user_name, .post_user_time{
  margin-top: 10px;
}
.post_user_name{
  max-width: 80px;
  margin-left: 10px;
}
.post_user_avatar_main{
  width: 44px;
  height: 44px;
  border-radius: 30px;
}
.inside_div {
  width: 333px;
  margin: 0;
  display: grid;
  grid-template-rows: 1fr auto;
  margin-bottom: 24px;
  border: 0;
  break-inside: avoid;
  border-radius: 12px;
}
.inside_div:nth-child(1n){
  box-shadow: 0px -7px 11px 3px #FFEAEF
}
.inside_div:nth-child(2n){
  box-shadow: 0px -7px 11px 3px #FCEBE2
}
.inside_div:nth-child(3n){
  box-shadow: 0px -7px 11px 3px #F8F4CE
}
.inside_div:nth-child(4n){
  box-shadow: 0px -7px 11px 3px #E4F4B9
}
.inside_div:nth-child(5n){
  box-shadow: 0px -7px 11px 3px rgba(205, 180, 229, 0.25)
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

.inside_div dt img, iframe{
  width: calc(100% + 20px);
  margin-left: -22px; 
}

.inside_div a {
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

@media (max-width: 320px) {

  h1 {
    font-size: 15px;
  }

  .post_main_container {
    display: block;
    margin-left: 25%;
  }

  .post_div {
    width: 151px;
  }

  .post_user_avatar {
    width: 25px;
    height: 25px;
  }

  .post_user_name {
    font-size: 10px;
  }

  .post_user_time {
    top: 0.2vh;
    left: 1%;
    font-size: 10px;
  }

  dt {
    font-size: 6px;
    line-height: 10px;
  }
  iframe{
    height: 100px;
  }
  .user_post_info{
    column-gap: 0;
  }
  .post_user {
    width: 151px;
  }
  .post_user_avatar_main{
    width: 30px;
    height: 30px;
    margin-right: 2px;
  }

}

</style>

<script>
export default {
  name: "Home",
  data() {
    return {
      posts: []
    };
  },
  created() {
    if(IsLogged){
      this.$axios
      .get("http://127.0.0.1:8000/api/getpostsdash")
        .then((response) => {
          for (let i = 0; i < response.data.data.length; i++) {
            if(response.data.data[i] === null){
              response.data.data.splice(i,1)
            }
            
          }
          this.posts = response.data.data;
          console.log(this.posts)
      });
    } else{
      this.$axios
      .get("http://127.0.0.1:8000/api/getpostsall")
        .then((response) => {
          this.posts = response.data.data;
      });
    }
    
  },
  methods: {},
};
</script>