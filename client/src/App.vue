<template>
  <div id="app">
    <Header/>
    <keep-alive>
      <router-view v-if="$route.meta.keepAlive"/>
    </keep-alive>
    <router-view v-if="!$route.meta.keepAlive"></router-view>
    <Nav v-if="$route.matched[0].path !== '/message/:id' && $route.matched[0].path !== '/edit'"/>
  </div>
</template>

<script>
import Header from "@/components/Header";
import Nav from "@/components/Nav";

export default {
  name: "App",
  components: {
    Nav,
    Header
  }
};

import router from "./router";
router.beforeEach((to, from, next) => {
  if (to.meta.title) {
    var title = to.meta.title;
    document.title = title;
  }

  // 百度统计
  setTimeout(() => {
    var _hmt = _hmt || [];
    (function() {
      //每次执行前，先移除上次插入的代码
      document.getElementById("baidu_tj") &&
        document.getElementById("baidu_tj").remove();
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?41b04999ee3d67f2acc9ce741045e68d";
      hm.id = "baidu_tj";
      var s = document.getElementsByTagName("script")[0];
      s.parentNode.insertBefore(hm, s);
    })();
  }, 0);

  next();
});

// 进行 service-wroker 注册
if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register("/service-wroker.js")
      .then(registration => {
        console.log("SW registered: ", registration);
      })
      .catch(registrationError => {
        console.log("SW registration failed: ", registrationError);
      });
  });
}
</script>

<style>
body {
  margin: 0;
  background-color: #f1f1f1;
  -webkit-tap-highlight-color: transparent;
  box-sizing: border-box;
  min-height: calc(100vh - 102px);
}

@media screen and (min-width: 960px) {
  body,
  #nexmoe-nav,
  #nexmoe-header,
  .nexmoe-reply {
    width: 420px !important;
    margin: auto;
  }

  body {
    box-shadow: 0 0 30px #ababab;
  }
}

@media screen and (max-width: 960px) {
  .el-message-box__wrapper {
    top: unset !important;
    padding: 10px !important;
  }

  .el-message-box__wrapper:after {
    display: none !important;
  }

  .el-message-box {
    width: 100% !important;
  }
}

a {
  text-decoration: none;
}

.vue-content-placeholders-heading {
  margin: 10px;
  margin-top: 0;
  padding-top: 10px;
}

.vue-content-placeholders-heading__img {
  border-radius: 100%;
}

[class^="vue-content-placeholders-"] + .vue-content-placeholders-img {
  margin-top: 0px;
}

[class^="vue-content-placeholders-"] + .vue-content-placeholders-text {
  margin: 10px;
  padding-bottom: 1px;
}

.nexmoe-tab {
  height: 46px;
  width: 100%;
  border-bottom: 1px solid #eee;
  padding: 0 10px;
  box-sizing: border-box;
}

.nexmoe-tab a {
  padding: 0;
  box-sizing: border-box;
  line-height: 46px;
  position: relative;
  display: inline-block;
  margin-right: 10px;
  color: #000;
}

.nexmoe-tab a.router-link-exact-active {
  color: #ff7b8c;
}

.nexmoe-tab a.router-link-exact-active::after {
  color: #ff7b8c;
  content: "";
  background-color: #ff7b8c;
  width: 100%;
  height: 3px;
  position: absolute;
  bottom: 0;
  left: 0;
}

#nexmoe-content .nexmoe-item {
  background-color: #fff;
  margin-bottom: 10px;
  display: block;
  color: #010101;
}

#nexmoe-content .nexmoe-item::after {
  clear: both;
  display: table;
  content: " ";
}
</style>
