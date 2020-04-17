<template>
    <div class="nexmoe-setting">
      <ul>
        <li>作者名称：折影轻梦</li>
        <li>联系企鹅：776194970</li>
      </ul>
      <ul>
        <li>企鹅群聊：797996017</li>
      </ul>
      <ul>
        <li><a href="https://github.com/nexmoe/wall-public" target="_blank">开源地址：github.com/nexmoe/wall-public</a></li>
        <li>版权协议：MIT</li>
        <li v-if="version">当前版本：{{ version }}</li>
      </ul>
    </div>
</template>

<script>
  export default {
    name: 'HelloWorld',
    data() {
      return {
        version: window.version
      }
    }
  }

</script>

<style scoped>
  ul {
    display: block!important;
    height: auto!important;
    width: auto!important;
    opacity: 1!important;
    visibility: unset!important;
  }
</style>