<template>
  <div id="nexmoe-content">
    <div class="nexmoe-shortcut">
      <router-link tag="a" class="nexmoe-shortcut-item pink" :to="'/message/2403'">
        <div class="nexmoe-shortcut-icon">
          <i class="nexmoefont icon-smile"></i>
        </div>
        <div class="nexmoe-shortcut-name">意见反馈</div>
      </router-link>
      <a
        class="nexmoe-shortcut-item blue"
        target="_blank"
        href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=https://wall.chainwon.com/&title=%E5%A2%99&desc=%E8%BF%99%E9%87%8C%E6%98%AF%E5%A2%99%EF%BC%8C%E5%9C%A8%E8%BF%99%E9%87%8C%EF%BC%8C%E4%BD%A0%E5%8F%AF%E4%BB%A5%E8%87%AA%E5%8A%A8%E4%B8%8B%E5%8D%95%EF%BC%8C%E5%8F%AF%E4%BB%A5%E6%A0%B9%E6%8D%AE%E4%B8%8D%E5%90%8C%E5%88%86%E7%B1%BB%E5%8F%91%E5%8D%95%E3%80%82%E6%9C%80%E9%87%8D%E8%A6%81%E7%9A%84%E6%98%AF%EF%BC%8C%E4%B8%8B%E5%8D%95%E7%A7%92%E5%8F%91%E5%93%A6%EF%BC%81&summary=%E8%BF%99%E9%87%8C%E6%98%AF%E5%A2%99%EF%BC%8C%E5%9C%A8%E8%BF%99%E9%87%8C%EF%BC%8C%E4%BD%A0%E5%8F%AF%E4%BB%A5%E8%87%AA%E5%8A%A8%E4%B8%8B%E5%8D%95%EF%BC%8C%E5%8F%AF%E4%BB%A5%E6%A0%B9%E6%8D%AE%E4%B8%8D%E5%90%8C%E5%88%86%E7%B1%BB%E5%8F%91%E5%8D%95%E3%80%82%E6%9C%80%E9%87%8D%E8%A6%81%E7%9A%84%E6%98%AF%EF%BC%8C%E4%B8%8B%E5%8D%95%E7%A7%92%E5%8F%91%E5%93%A6%EF%BC%81&site=https://wall.chainwon.com/&pics=https://ws2.sinaimg.cn/large/007edEi9ly1g0gvwuc0gkj30cy0n441b.jpg"
      >
        <div class="nexmoe-shortcut-icon">
          <i class="nexmoefont icon-share"></i>
        </div>
        <div class="nexmoe-shortcut-name">分享墙</div>
      </a>
    </div>
    <div class="nexmoe-categorys">
      <router-link
        v-for="item in category"
        :key="item.time"
        tag="a"
        :to="'/category/'+item.cid"
      ># {{ item.name }}</router-link>
    </div>
    <div class="nexmoe-list">
      <content-placeholders class="nexmoe-item" v-if="loading">
        <content-placeholders-heading :img="true"/>
        <content-placeholders-img/>
        <content-placeholders-text/>
      </content-placeholders>
      <content-placeholders class="nexmoe-item" v-if="loading">
        <content-placeholders-heading :img="true"/>
        <content-placeholders-img/>
        <content-placeholders-text/>
      </content-placeholders>
      <content-placeholders class="nexmoe-item" v-if="loading">
        <content-placeholders-heading :img="true"/>
        <content-placeholders-img/>
        <content-placeholders-text/>
      </content-placeholders>
      <router-link
        tag="a"
        v-for="item in message"
        :key="item.time"
        :to="'/message/'+item.mid"
        v-if="!loading"
      >
        <Item :item="item" v-if="!loading"></Item>
      </router-link>
    </div>
  </div>
</template>

<script>
import Item from "@/components/Item";

export default {
  name: "Home",
  components: {
    Item
  },
  data() {
    return {
      loading: true,
      category: "",
      message: ""
    };
  },
  mounted: function() {
    this.axios
      .get("/api/view/category")
      .then(res => {
        this.category = res.data;
      })
      .catch(function(error) {
        console.log(error);
      });
    this.axios
      .get("/api/view/message")
      .then(res => {
        this.message = res.data;
        this.loading = false;
      })
      .catch(function(error) {
        console.log(error);
      });
  }
};
</script>

<style>
#nexmoe-content .nexmoe-shortcut {
  margin: 5px;
}

#nexmoe-content .nexmoe-shortcut::after {
  clear: both;
  display: table;
  content: " ";
}

#nexmoe-content .nexmoe-shortcut .nexmoe-shortcut-item {
  padding: 10px;
  color: #fff;
  border-radius: 4px;
  width: calc(50% - 10px);
  margin: 5px;
  float: left;
  box-sizing: border-box;
}

#nexmoe-content .nexmoe-shortcut .nexmoe-shortcut-item.pink {
  background: linear-gradient(to right, rgb(238, 156, 167), rgb(255, 221, 225));
}

#nexmoe-content .nexmoe-shortcut .nexmoe-shortcut-item.blue {
  background: linear-gradient(to right, rgb(28, 146, 210), rgb(212, 248, 255));
}

#nexmoe-content .nexmoe-shortcut .nexmoe-shortcut-icon {
  border-radius: 100%;
  margin-bottom: 5px;
  margin-left: -2px;
}

#nexmoe-content .nexmoe-shortcut .nexmoe-shortcut-icon i {
  font-size: 1.6em;
}

#nexmoe-content .nexmoe-categorys {
  padding-left: 10px;
}

#nexmoe-content .nexmoe-categorys a {
  background-color: #fff;
  border-radius: 4px;
  padding: 2px 6px;
  margin: 0 10px 10px 0;
  display: inline-block;
  color: #010101;
}
</style>
