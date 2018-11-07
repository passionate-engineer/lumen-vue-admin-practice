<template>
  <div class="home">
    <button @click="$router.push('edit')">新規作成</button>
    <hr>
    <table border="1">
      <tr>
        <th>ID</th>
        <th>投稿日時</th>
        <th>タイトル</th>
        <th>公開状態</th>
        <th>作成日時</th>
        <th>更新日時</th>
        <th>編集</th>
        <th>削除</th>
        <th>プレビュー</th>
        <th>公開</th>
      </tr>
      <tr v-for="(article, articleKey) in articles" :key="articleKey">
        <td>{{article.id}}</td>
        <td>{{article.date_time}}</td>
        <td>{{article.title}}</td>
        <td>{{(article.public_status) ? '公開中' : '非公開中'}}</td>
        <td>{{article.created_at}}</td>
        <td>{{article.updated_at}}</td>
        <td><button @click="$router.push(`edit/${article.id}`)">編集</button></td>
        <td><button @click="deleteArticle(article.id, article.title)">削除</button></td>
        <td><a target="_blank" :href="article.preview_uri">プレビュー</a></td>
        <td><a target="_blank" :href="article.public_uri">公開</a></td>
      </tr>
    </table>
  </div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'

export default {
  name: 'home',
  components: {
  },
  created () {
    window.pageThis = this
    this.getArticles()
  },
  data () {
    return {
      articles: []
    }
  },
  methods: {
    getDateFormat (dateTime) {
      return dateTime.replace('T', ' ')
    },
    getArticles () {
      fetch('http://dms-vue-test.basement.jp/api/articles').then(res => res.json()).then((result) => {
        this.articles = result
      })
    },
    deleteArticle (id, title) {
      if (!window.confirm(`${title}を削除しますか？`)) return
      fetch(`http://dms-vue-test.basement.jp/api/articles/${id}`, {
        method: 'DELETE',
        headers: {
          'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
      }).then((response) => {
        if (response.status !== 204) {
          alert('削除に失敗しました。')
          throw new Error('Error')
        }
      }).then(() => {
        this.getArticles()
      })
    }
  }
}
</script>
