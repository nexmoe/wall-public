<template>
  <div id="nexmoe-content" class="edit">
    <div class="nexmoe-item">
      <div class="nexmoe-category">
        <el-select v-model="value" placeholder="请选择">
          <el-option v-for="item in category" :key="item.cid" :label="'# '+item.name" :value="item.cid">
          </el-option>
        </el-select>
      </div>
      <Article :article="article"></Article>
      <p v-loading="upload" v-if="upload" style="margin: 0;">
        <img style="width: 100%;" :src="uploadimg">
      </p>
    </div>
    <div class="nexmoe-item">
      <el-input type="textarea" placeholder="请输入内容" v-model="edit">
      </el-input>
      <div class="nexmoe-tool">
        <el-upload style="float: left;" :action="'/api/controller/picupload'" accept="image/*"
          :before-upload="beforePicUpload" :on-success="handlePicSuccess" :show-file-list="false" multiple>
          <el-button icon="el-icon-picture-outline" circle></el-button>
        </el-upload>
        <el-button style="float: right;" type="primary" @click="onSubmit">添加第 {{ this.count }} 条内容</el-button>
      </div>
    </div>
    <el-switch v-model="anonymous" active-value="true" inactive-value="false" active-text="匿名发布" style="margin:0 10px 10px 10px;"></el-switch>

    <el-button @click="send" style="width: 100%;">发布</el-button>
  </div>
</template>

<script>
import Article from '@/components/item/Article'
  export default {
    name: 'Edit',
    components: {
      Article
    },
    data() {
      return {
        edit: '',
        count: 1,
        category: '',
        anonymous: false,
        value: '2336',
        article: [],
        upload: false,
        uploadimg: '',
      }
    },
    created: function () {
      this.axios.get("/api/view/user")
        .then((res) => {
          if (res.data['state'] == 0) {
            this.$router.push('/login')
          }
        })
        .catch(function (error) {
          console.log(error)
        });
      this.axios.get("/api/view/category")
        .then((res) => {
          this.category = res.data;
        })
        .catch(function (error) {
          console.log(error)
        });
    },
    methods: {
      handlePicSuccess(res, file) {
        console.log(res)
        this.upload = false
        this.article.push({
          type: 'img',
          text: res.large
        })
        this.count++
      },
      beforePicUpload(file) {
        this.upload = true
        this.uploadimg = URL.createObjectURL(file)
      },
      send() {
        this.onSubmit()
        this.axios.post("/api/controller/edit/", {
            category: this.value,
            article: this.article,
            anonymous: this.anonymous,
          })
          .then((res) => {
            if (res.data.state == 1) {
              this.$alert(res.data.info, '发布成功！', {
                confirmButtonText: '确定',
                type: 'success',
              }).then(() => {
                this.$router.push('/')
                location.reload()
              });
            } else {
              this.$alert(res.data.info, '发布失败！', {
                confirmButtonText: '确定',
                type: 'error'
              });
            }
          })
          .catch(function (error) {
            console.log(error)
          });
      },
      onSubmit() {
        if (this.edit != '') {
          var bilibili = /^.*(ht|f)tp(s?)\:\/\/www\.bilibili\.com\/video\/av.*\s$/;
          var music163 = /^.*(ht|f)tp(s?)\:\/\/music\.163\.com\/song\/(.|\n)*$/;
          // var music163desk = /^.*(ht|f)tp(s?)\:\/\/music\.163\.com.*song?id=.*$/;
          var xiami = /^.*(ht|f)tp(s?)\:\/\/www\.xiami\.com\/song\/(.|\n)*$/;
          if (bilibili.test(this.edit)) {
            var av = this.edit.replace(/^.*(ht|f)tp(s?)\:\/\/www\.bilibili\.com\/video\/av([0-9]+).*(.|\n)$/, "$3");
            this.items = this.article.push({
              type: 'bilibili',
              text: av
            })
          } else if (music163.test(this.edit)) {
            var id = this.edit.replace(/^.*(ht|f)tp(s?)\:\/\/music\.163\.com\/song\/([0-9]+)(.|\n)*$/, "$3");
            this.items = this.article.push({
              type: 'music',
              text: 'https://music.163.com/song?id='+id
            })
          } else if (xiami.test(this.edit)) {
            var id = this.edit.replace(/^.*(ht|f)tp(s?)\:\/\/www\.xiami\.com\/song\/([0-9]+)(.|\n)*$/, "$3");
            this.items = this.article.push({
              type: 'music',
              text: 'https://www.xiami.com/song/'+id
            })
          }
          /* else if(music163desk.test(this.edit)) {
                      console.log(this.edit)
                      var id = this.edit.replace(/^.*(ht|f)tp(s?)\:\/\/music\.163\.com.*song?id=([0-9]+).*(.|\n)$/, "$3");
                      console.log(id)
                      this.items = this.article.push({
                        type: 'music163',
                        text: id
                      })
                    }*/
          else {
            this.items = this.article.push({
              type: 'p',
              text: this.edit
            })
          }
          this.edit = ''
          this.count++
        }
      }
    }
  }

</script>

<style>
  .edit .el-textarea__inner,
  .edit .el-button {
    border: none !important;
  }

  .edit .el-button {
    display: block !important;
    margin-left: auto !important;
    border-radius: 0 !important;
  }

  .el-select-dropdown__item {
    font-size: 16px !important;
    line-height: 48px !important;
    height: 49px !important;
  }

  #nexmoe-content .nexmoe-category {
    padding: 10px;
    background-color: #f8f8f8;
  }

  #nexmoe-content .nexmoe-category .el-select {
    width: 100%;
    margin: -5px 0;
  }

  #nexmoe-content .nexmoe-category .el-input__inner {
    background-color: transparent;
    border: none;
    padding: 5px;
    font-size: 16px;
  }

</style>
