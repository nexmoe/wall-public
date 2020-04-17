<template>
  <div>
    <ul v-for="comment in comment" :key="comment.time">
      <li>
        <div class="nexmoe-author">
          <div class="nexmoe-avatar"><img :src="comment.author.avatar"></div>
          <div class="nexmoe-name">{{ comment.author.name }} <span v-if="comment.parent!=='0'">回复</span> <a>{{ comment.parent.name }}</a></div>
          <div class="nexmoe-s"><span>{{ comment.time }}</span> <a @click="ereply(comment.coid,comment.author.name)">回复</a></div>
        </div>
        <div class="nexmoe-text">
          {{ comment.text }}
        </div>
        <Comment :comment="comment.children"></Comment>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    name:"Comment",
    props: ['comment'],
    data() {
      return {
      }
    },
    methods: {
      ereply(coid=0,name='本贴') {
        this.$prompt('你正在回复：' + name, '请输入评论内容', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          inputPattern: /\S/,
          inputErrorMessage: '内容不可为空'
        }).then(({ value }) => {
          this.axios.post("/api/controller/reply/", {
            mid: this.$route.params.id,
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
                if (res.data.state == 2){
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

  }

</script>

<style>
  #nexmoe-content .nexmoe-comment {
    background-color: #fff;
  }

  #nexmoe-content .nexmoe-comment .nexmoe-author {
    height: 42px;
    padding: 10px;
    padding-bottom: 0;
  }

  #nexmoe-content .nexmoe-comment .nexmoe-author .nexmoe-avatar {
    height: 100%;
    float: left;
  }

  #nexmoe-content .nexmoe-comment .nexmoe-author .nexmoe-avatar img {
    height: 100%;
    border-radius: 100%;
    background: #fff;
  }

  #nexmoe-content .nexmoe-comment .nexmoe-name,
  #nexmoe-content .nexmoe-comment .nexmoe-s {
    width: calc(100% - 56px);
    box-sizing: border-box;
    padding: 0 10px;
    float: left;
    margin-top: 0 !important;
    line-height: 21px;
    height: 21px;
  }
  
  #nexmoe-content .nexmoe-comment a {
    color: #ff7b8c;
  }

  #nexmoe-content .nexmoe-comment ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
  }

  #nexmoe-content .nexmoe-comment ul ul {
    padding-left: 52px;
  }

  #nexmoe-content .nexmoe-comment ul ul ul {
    padding-left: 0;
  }

  #nexmoe-content .nexmoe-comment ul li {
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
  }

  #nexmoe-content .nexmoe-comment ul ul li {
    padding-bottom: 0;
    border-bottom: none;
  }

  #nexmoe-content .nexmoe-comment ul .nexmoe-text {
    padding-left: 62px;
    text-align: left;
  }

</style>
