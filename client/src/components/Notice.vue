<template>
  <div class="nexmoe-notice">
    <ul class="nexmoe-list" v-if="loading">
      <content-placeholders>
        <content-placeholders-heading :img="true"/>
      </content-placeholders>
      <content-placeholders>
        <content-placeholders-heading :img="true"/>
      </content-placeholders>
      <content-placeholders>
        <content-placeholders-heading :img="true"/>
      </content-placeholders>
      <content-placeholders>
        <content-placeholders-heading :img="true"/>
      </content-placeholders>
      <content-placeholders>
        <content-placeholders-heading :img="true"/>
      </content-placeholders>
      <content-placeholders>
        <content-placeholders-heading :img="true"/>
      </content-placeholders>
      <content-placeholders>
        <content-placeholders-heading :img="true"/>
      </content-placeholders>
      <content-placeholders>
        <content-placeholders-heading :img="true"/>
      </content-placeholders>
      <content-placeholders>
        <content-placeholders-heading :img="true"/>
      </content-placeholders>
      <content-placeholders>
        <content-placeholders-heading :img="true"/>
      </content-placeholders>
    </ul>
    <ul class="nexmoe-list" v-if="!loading">
      <div class="nexmoe-list-title">通知列表</div>
      <router-link tag="a" :to="'/message/'+item.mid" v-for="item in notice" :key="item.time">
        <li class="nexmoe-list-item">
          <div class="nexmoe-list-item-avatar">
            <img src="https://avatar.dawnlab.me/qq/776194970">
          </div>
          <div class="nexmoe-list-item-content">
            <div class="nexmoe-list-item-title">{{ item.origin.author.name }} 回复了你</div>
            <div class="nexmoe-list-item-text">{{ item.origin.text }}</div>
          </div>
        </li>
      </router-link>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: true,
      notice: []
    };
  },
  mounted: function() {
    this.axios
      .get("/api/view/notice")
      .then(res => {
        this.notice = res.data;
        this.loading = false;
      })
      .catch(function(error) {
        console.log(error);
      });
  }
};
</script>
<style scoped>
.nexmoe-list {
  padding: 0;
  margin: 0;
  list-style: none;
  margin-top: 10px;
  background-color: #fff;
}

.nexmoe-list .nexmoe-list-title {
  padding: 10px;
}

.nexmoe-list::after,
.nexmoe-list .nexmoe-list-item::after {
  clear: both;
  display: table;
  content: " ";
}

.nexmoe-list .nexmoe-list-item {
  position: relative;
  padding: 10px;
  border-top: 1px solid #eee;
}

.nexmoe-list .nexmoe-list-item-avatar {
  float: left;
  width: 48px;
  height: 48px;
}

.nexmoe-list .nexmoe-list-item-avatar img {
  width: 100%;
  height: 100%;
  border-radius: 100%;
}

.nexmoe-list .nexmoe-list-item-content {
  float: left;
  margin-left: 10px;
}

.nexmoe-list .nexmoe-list-item-title {
  color: #000;
  line-height: 21px;
  margin-top: 3px;
}

.nexmoe-list .nexmoe-list-item-text {
  line-height: 21px;
  color: #666666;
}
</style>
