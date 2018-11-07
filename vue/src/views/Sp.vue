<template>
  <div>
    <div class="markdown-body" v-html="html"></div>
  </div>
</template>

<script>
import Marked from 'marked'

export default {
  name: 'edit',
  created () {
    fetch('https://raw.githubusercontent.com/passionate-engineer/lumen-vue-admin-practice/master/SUBJECT_JP.md').then(response => response.text()).then((res) => {
      this.html = this.marked(res)
    })
  },
  data () {
    return {
      html: ''
    }
  },
  methods: {
    marked (value) {
      console.log(Marked(value))
      return Marked(value)
    }
  }
}
</script>

<style scoped>
.markdown-body {
  box-sizing: border-box;
  min-width: 200px;
  max-width: 980px;
  margin: 0 auto;
  padding: 45px;
}

@media (max-width: 767px) {
  .markdown-body {
    padding: 15px;
  }
}
</style>
