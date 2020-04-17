<template>
  <div id="nexmoe-nav">
    <ul class="nexmoe-nav">
      <li>
        <router-link tag="a" to="/"><i class="nexmoefont icon-home"></i><i @click="refresh" class="nexmoefont icon-md-refresh-circle"></i></router-link>
      </li>
      <li>
        <el-badge :value="count">
          <router-link tag="a" to="/notice">
            <i class="nexmoefont icon-bell"></i>
            <i class="nexmoefont icon-bell-fill"></i>
          </router-link>
        </el-badge>
      </li>
      <li>
        <router-link tag="a" to="/setting/home"><i class="nexmoefont icon-people"></i><i class="nexmoefont icon-people-fill"></i></router-link>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        count: ''
      }
    },
    created: function () {
      this.axios.get("/api/view/notice/true")
        .then((res) => {
          this.count = res.data;
          console.log(res.data)
        })
        .catch(function (error) {
          console.log(error)
        });
    },
    methods: {
      refresh() {
        location.reload()
      }
    },
    watch: {

    }
  }

</script>

<style>
  body {
    padding-bottom: 56px;
  }

  #nexmoe-nav {
    position: fixed;
    bottom: 0;
    width: 100%;
  }

  #nexmoe-nav .nexmoe-nav {
    z-index: 9;
    position: relative;
    height: 56px;
    display: flex;
    border-top: 1px solid #ececec;
    margin: 0;
    padding: 0;
    list-style: none;
    background-color: #fff;
    width: 100%;
  }

  #nexmoe-nav .nexmoe-nav li {
    max-width: none;
    flex: 1;
    text-align: center;
    line-height: 56px;
    color: #adadad;
  }

  #nexmoe-nav .nexmoe-nav li .el-badge {
    vertical-align: unset;
  }

  #nexmoe-nav .nexmoe-nav li .el-badge__content.is-fixed {
    top: 15px;
  }

  #nexmoe-nav .nexmoe-nav a {
    display: block;
    color: #adadad;
    background-color: #fff;
  }

  #nexmoe-nav .nexmoe-nav a i {
    font-size: 28px;
  }

  #nexmoe-nav .nexmoe-nav a.router-link-exact-active {
    color: #ff7b8c;
  }

  #nexmoe-nav .nexmoe-nav a.router-link-exact-active i:first-child,
  #nexmoe-nav .nexmoe-nav a i:last-child {
    display: none;
  }

  #nexmoe-nav .nexmoe-nav a i:first-child,
  #nexmoe-nav .nexmoe-nav a.router-link-exact-active i:last-child {
    display: block;
  }

  #nexmoe-nav .nexmoe-nav a.router-link-exact-active i:last-child {
    display: block;
    animation: zoom .2s ease-out;
    animation-iteration-count: 1;
  }

  @keyframes zoom {
    from {
      transform: scale(.7);
    }

    to {
      transform: scale(1);
    }
  }

  #nexmoe-nav .nexmoe-nav .nexmoe-plus {
    transition: all .35s;
    background-color: #ff7b8c;
    color: #fff;
    width: 64px;
    border-radius: 100%;
    height: 64px;
    line-height: 64px;
    position: absolute;
    border: 5px solid #fff;
    bottom: 0;
    left: calc(50% - 32px);
    box-shadow: 0 -4px 7px rgba(161, 177, 204, .2);
    cursor: pointer;
  }

  #nexmoe-nav .nexmoe-nav .nexmoe-plus .icon-menu {
    transition: all .35s;
    width: 24px;
    height: 3px;
    left: 20px;
    position: absolute;
    border-radius: 6px;
    background-color: #fff;
  }

  #nexmoe-nav .nexmoe-nav .nexmoe-plus .icon-menu:nth-child(3n+1) {
    top: 30.5px;
    transform: rotate(90deg);
  }

  #nexmoe-nav .nexmoe-nav .nexmoe-plus .icon-menu:nth-child(3n+2) {
    top: 30.5px;
  }

  #nexmoe-nav .nexmoe-nav .nexmoe-plus.active .icon-menu:nth-child(3n+1) {
    transform: rotate(315deg);
  }

  #nexmoe-nav .nexmoe-nav .nexmoe-plus.active .icon-menu:nth-child(3n+2) {
    transform: rotate(225deg);
  }

</style>
