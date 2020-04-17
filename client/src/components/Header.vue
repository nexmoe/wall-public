<template>
  <div id="nexmoe-header">
    <div class="nexmoe-tab" v-if="$route.matched[0].path == ''">
      <router-link tag="a" to="/">最新</router-link>
      <!--<router-link tag="a" to="/time">时间块</router-link>-->
    </div>
    <div class="nexmoe-tab" v-if="$route.matched[0].path !== ''">
      <a v-on:click="$router.back(-1)"><i class="nexmoefont icon-arrowleft"></i> 返回</a>
    </div>
    <div class="nexmoe-notice">
      <router-link tag="a" to="/edit" v-if="$route.matched[0].path == ''">
        <el-button type="primary" icon="nexmoefont icon-plus" circle size="mini"></el-button>
      </router-link>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'HelloWorld',
    data() {
      return {
        item: {
          avatar: 'https://avatar.dawnlab.me/qq/776194970',
          name: '折影轻梦',
          qq: '776194970',
          category: '这是一个分类',
          article: '这是一段内容'
        }
      }
    }
  }

</script>

<style>
  body {
    padding-top: 46px;
  }

  #nexmoe-header {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 10;
    background-color: #fff;
  }

  #nexmoe-header .nexmoe-tab {
    float: left;
    width: calc(100% - 46px);
  }

  #nexmoe-header .nexmoe-notice {
    float: left;
    width: 46px;
    text-align: center;
    box-sizing: border-box;
    height: 46px;
    border-bottom: 1px solid #eee;
    padding: 6px;
  }

  #nexmoe-header .nexmoe-notice .el-button--mini.is-circle {
    box-shadow: 0 0 12px #ff7b8c;
  }

  #nexmoe-header .nexmoe-notice i {
    color: #fff;
  }

  a {
    cursor: pointer;
  }

</style>
