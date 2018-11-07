<template>
  <div>
    <div v-html="html"></div>
  </div>
</template>

<script>
import Marked from 'marked'

export default {
  name: 'edit',
  created () {
    fetch('http://dms-vue-test.basement.jp/sp.php').then(response => response.text()).then((res) => {
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
</style>
