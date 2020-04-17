<template>
  <div id="nexmoe-content">
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
        :to="'/message/'+item.mid"
        v-if="!loading"
        v-for="item in message"
        :key="item.time"
      >
        <Item :item="item" v-if="!loading"></Item>
      </router-link>
    </div>
  </div>
</template>

<script>
import Item from "@/components/Item";
export default {
  name: "Category",
  components: {
    Item
  },
  data() {
    return {
      loading: true,
      category: "",
      message: [{}, {}, {}]
    };
  },
  mounted: function() {
    this.axios
      .get("/api/view/category/" + this.$route.params.id)
      .then(res => {
        this.message = res.data.message;
        this.loading = false;
      })
      .catch(function(error) {
        console.log(error);
      });
  }
};
</script>

<style>
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
