<template>
  <div class="edit">
    <router-link to="/">一覧に戻る</router-link>
    <hr>
    <form @submit.prevent="submit">
      <p>投稿日時: <input type="datetime-local" v-model="article.date_time" required></p>
      <p>タイトル: <input type="text" v-model="article.title" required maxlength="64"></p>
      <p>本文: <textarea v-model="article.html" required ></textarea></p>
      <p>
      公開状態: 
        <input name="public_status" type="radio" id="public_status_true" :value="true" v-model="article.public_status"><label for="public_status_true">公開</label>
        <input name="public_status" type="radio" id="public_status_false" :value="false" v-model="article.public_status"><label for="public_status_false">非公開</label>
      </p>
      <p><input type="submit" :submit="submit" :value="(this.id) ? '編集' : '投稿'"></p>
    </form>
  </div>
</template>

<script>
Date.prototype.toDateInputValue = (function() {
  const local = new Date(this)
  local.setMinutes(this.getMinutes() - this.getTimezoneOffset())
  console.log(local.toJSON())
  return local.toJSON().slice(0,16)
})

export default {
  name: 'edit',
  created () {
    window.pageThis = this

    if(this.$route.params.id) {
      this.id = this.$route.params.id
      fetch(`http://dms-vue-test.basement.jp/api/articles/${this.id}`).then((response) => {
        if (response.status !== 200) {
          alert('記事の取得に失敗しました。')
          throw new Error('Error')
        }
        return response.json()
      }).then((result) => {
        console.log(result)
        this.article.date_time = result.date_time.replace(' ', 'T')
        this.article.title = result.title
        this.article.html = result.html
        this.article.public_status = result.public_status
      })
    }
  },
  data () {
    return {
      id: null,
      article: {
        title: '',
        date_time: (new Date()).toDateInputValue(),
        html: '',
        public_status: false
      }
    }
  },
  methods: {
    submit () {
      if (this.id) {
        fetch(`http://dms-vue-test.basement.jp/api/articles/${this.id}`, {
          method: 'PUT',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.article)
        }).then((response) => {
          if (response.status !== 204) {
            alert('編集に失敗しました。')
            throw new Error('Error')
          }
        }).then(() => {
          this.$router.push('/')
        })
      } else {
        fetch('http://dms-vue-test.basement.jp/api/articles', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.article)
        }).then((response) => {
          if (response.status !== 201) {
            alert('投稿に失敗しました。')
            throw new Error('Error')
          }
          return response.json()
        }).then((result) => {
          console.log(result)
          this.$router.push('/')
        })
      }
      return false
    }
  }
}
</script>

<style scoped>
textarea {
  width: 300px;
  height: 200px;
}
</style>
