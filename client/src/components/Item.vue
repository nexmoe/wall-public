<template>

  <div class="nexmoe-item">
    <div class="nexmoe-author">
      <div class="nexmoe-avatar"><img :src="item.author.avatar"></div>
      <div class="nexmoe-name">{{ item.author.name }}</div>
      <div class="nexmoe-s">{{ item.time }}</div>
    </div>
    <div class="nexmoe-category">
      # {{ item.category }}
    </div>
    <Article :article="item.article"></Article>
  </div>
</template>

<script>
  import Article from '@/components/item/Article'

  export default {
    name: "Item",
    components: {
      Article
    },
    props: ['item'],
    data() {
      return {}
    },
    methods: {

    },

  }

</script>

<style>
  #nexmoe-content .nexmoe-item .nexmoe-author {
    padding: 10px;
    height: 56px;
  }

  #nexmoe-content .nexmoe-item .nexmoe-avatar {
    height: 100%;
    float: left;
  }

  #nexmoe-content .nexmoe-item .nexmoe-avatar img {
    height: 100%;
    border-radius: 100%;
    background: #fff;
  }

  #nexmoe-content .nexmoe-item .nexmoe-name {
    float: left;
    width: calc(100% - 56px);
    margin-top: 6px;
    box-sizing: border-box;
    padding: 0 10px;
  }

  #nexmoe-content .nexmoe-item .nexmoe-s {
    float: left;
    width: calc(100% - 56px);
    margin-top: 2px;
    box-sizing: border-box;
    padding: 0 10px;
    color: #656565;
  }

  #nexmoe-content .nexmoe-item .nexmoe-category {
    padding: 12px 10px;
    background-color: #f8f8f8;
  }

</style>
