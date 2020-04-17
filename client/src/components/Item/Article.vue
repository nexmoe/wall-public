<template>
  <div class="nexmoe-article">
    <p v-for="item in article" :key="item.time">
      <span v-if="item.type == 'p'">{{ item.text }}</span>
      <img v-if="item.type == 'img'" :src="item.text">
      <iframe v-if="item.type == 'bilibili'" :src="'https://player.bilibili.com/player.html?aid='+item.text" width="100%"
        height="233px" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"> </iframe>
      <iframe v-if="item.type == 'music'" :src="'https://wall.chainwon.com/api/view/music?url='+item.text" width="100%"
        height="92px" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe>
    </p>
  </div>
</template>

<script>
  export default {
    name: "article",
    props: ['article'],
    data() {
      return {}
    },
    methods: {

    },

  }

</script>

<style>
  #nexmoe-content .nexmoe-article {
    padding: 1px 0;
  }

  #nexmoe-content .nexmoe-article p {
    margin: 10px;
  }

  #nexmoe-content .nexmoe-article p img {
    margin: 0 -10px;
    width: calc(100% + 20px);
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    display: block;
  }

</style>
