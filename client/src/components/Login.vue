<template>
  <div class="nexmoe-login">
    <el-card shadow="never">
      <el-input v-model="input" placeholder="请输入QQ号登录"></el-input>
      <br><br>
      <el-alert title="请输入QQ号登录" type="warning" show-icon :closable="false"></el-alert>
      <br>
      <el-button @click="onSubmit" style="width: 100%;">登录</el-button>
    </el-card>

  </div>
</template>

<script>
  export default {
    data() {
      return {
        input: ''
      }
    },
    methods: {
      onSubmit() {
        this.axios.post('/api/controller/cookie/',{
            qq: this.input,
        })
        .then((res) => {
            if(res.data.state == 1){
                this.$router.push('/setting/home')
            }
        })
        .catch(function (error) {
            console.log(error)
        });
      }
    }
  }

</script>
<style>
  .nexmoe-login {
    padding: 10px;
    text-align: right;
  }

</style>
