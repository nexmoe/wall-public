<template>
  <div id="nexmoe-content" class="message">
    <content-placeholders class="nexmoe-item" v-if="loading">
      <content-placeholders-heading :img="true" />
      <content-placeholders-img />
      <content-placeholders-text />
    </content-placeholders>
    <Item :item="item" v-if="!loading"></Item>
    <div class="nexmoe-comment">
      <div class="nexmoe-tab">
        <router-link tag="a" :to="'/message/'+item.mid">评论 {{ item.comment.count }}</router-link>
      </div>
      <ul v-for="comment in item.comment.data" :key="comment.time" v-if="loading">
        <li>
          <content-placeholders class="nexmoe-item">
            <content-placeholders-heading :img="true" />
            <content-placeholders-text :lines="1" />
          </content-placeholders>
          <ul>
            <li>
              <content-placeholders class="nexmoe-item">
                <content-placeholders-heading :img="true" />
                <content-placeholders-text :lines="1" />
              </content-placeholders>
            </li>
          </ul>
        </li>
      </ul>
      <Comment :comment="item.comment.data" v-show="!loading"></Comment>
    </div>
    <div class="nexmoe-reply">
      <el-button type="primary" @click="ereply()" icon="nexmoefont icon-comment" circle></el-button>
    </div>
  </div>
</template>

<script>
  import Comment from '@/components/Comment'
  import Item from '@/components/Item'

  export default {
    components: {
      Comment,
      Item
    },
    data() {
      return {
        loading: true,
        reply: '',
        item: {
          comment: {
            data: [{}, {}, {}]
          }
        }
      }
    },
    methods: {
      ereply(coid = 0, name = '本贴') {
        this.$prompt('你正在回复' + name, '请输入评论内容', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          inputPattern: /\S/,
          inputErrorMessage: '内容不可为空'
        }).then(({
          value
        }) => {
          this.axios.post('/api/controller/reply/', {
              mid: this.item.mid,
              coid: coid,
              text: value,
            })
            .then((res) => {
              if (res.data.state == 1) {
                this.$alert(res.data.info, '发布成功！', {
                  confirmButtonText: '确定',
                  type: 'success',
                }).then(() => {
                  location.reload()
                });
              } else {
                this.$alert(res.data.info, '发布失败！', {
                  confirmButtonText: '确定',
                  type: 'error'
                }).then(() => {
                  if (res.data.state == 2) {
                    this.$router.push('/login')
                  }
                });
              }
            })
            .catch(function (error) {
              console.log(error)
            });
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '取消输入'
          });
        });
      }
    },
    mounted () {
      this.axios.get("/api/view/message/" + this.$route.params.id)
        .then((res) => {
          this.item = res.data;
          this.loading = false;
        })
        .catch(function (error) {
          console.log(error)
        });
    },
  }

</script>

<style>
  .el-select-dropdown__item {
    font-size: 16px !important;
    line-height: 48px !important;
    height: 49px !important;
  }


  #nexmoe-content .nexmoe-comment {
    background-color: #fff;
  }

  #nexmoe-content .nexmoe-reply {
    position: fixed;
    width: 100%;
    padding: 20px;
    bottom: 0;
    text-align: right;
    box-sizing: border-box;
  }

  #nexmoe-content .nexmoe-reply .el-button {
        box-shadow: 0 2px 10px #ff7b8c;
  }

</style>
