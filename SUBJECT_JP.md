# 課題

# 管理画面サンプル

http://dms-vue-test.basement.jp

# 概要

- 記事を管理するシステム
- 新規投稿、一覧表示、編集、削除、プレビュー、公開確認が行える
- API はすでに用意されており、適切なリクエストを行うことにより、記事を操作できる
- 管理画面は Vue CLI を利用して開発する (ルータは Vue Router を使用する)
- API は CrossOrigin が許可されているため、ローカルでの開発が可能である。PreFlight にも対応済み

## 一覧画面

- 表の項目をサンプルと揃える
- 新規を押した時には、/edit に遷移する
- 記事の編集を押した時には、/edit/:id に遷移する
- 一覧の取得に失敗した場合(ステータスコード 200 以外)、「記事一覧の取得に失敗しました。」と window.alert 表示する
- プレビューおよび、公開ページのリンクは別タブで開く
- 削除ボタンを押した時には、window.confirm により確認ダイアログを表示する
- 削除に失敗した場合(ステータスコード 204 以外)、「記事の削除に失敗しました。」と window.alert 表示する

## 新規画面 & 編集画面

- 編集項目をサンプルと揃える
- URL が/edit の時には、新規作成画面として振る舞う
- URL が/edit/:id の時には、ID に合わせ編集画面として振る舞う
- 新規投稿および編集完了時には、一覧に遷移する(一覧に遷移した時には、記事を再取得する)
- リロード時にも、正常に編集が行える
- form タグの submit を使用し、投稿日時、タイトル、本文を html5 の required により項目を必須にする
- タイトルは html5 の maxlength により 64 文字の制限を行う
- 新規投稿時の初期値は、投稿日時=現在日時、公開状態=非公開、とする
- 取得に失敗した場合(ステータスコード 200 以外)、「記事の取得に失敗しました。」と window.alert 表示する
- 投稿に失敗した場合(テータスコード 201 以外)、「記事の投稿に失敗しました。」と window.alert 表示する
- 編集に失敗した場合(テータスコード 204 以外)、「記事の編集に失敗しました。」と window.alert 表示する

## 提出

- 作成後は、node_modules を除いた状態のソースコードを zip にて提出していただく

# API

API URL: http://dms-vue-test.basement.jp/

## パラメータ

| パラメータ    | 説明文                                                     | 未指定時初期値       |
| ------------- | ---------------------------------------------------------- | -------------------- |
| id            | 記事の ID                                                  | Auto Increment       |
| date_time     | 表示上の投稿日時                                           | 現在日時             |
| title         | タイトル                                                   | 必須のため初期値なし |
| html          | 本文(HTML も投稿可)                                        | 空文字               |
| public_status | true の場合、public_uri にて記事を閲覧できるようになる     | false                |
| preview_uri   | プレビューの URI、public_status が false でも閲覧できる    |
| public_uri    | 公開ページの URI、public_status が true の時のみ閲覧できる |
| created_at    | 記事の作成日時                                             | 現在日時             |
| updated_at    | 記事の更新日時                                             | 現在日時             |

## 記事一覧

記事の一覧の取得を行う

### Request URI

GET: /api/articles

### 200 OK

```
[
  {
    "id": 1,
    "title": "記事タイトル",
    "date_time": "2018-01-01 00:00:00",
    "public_status": false,
    "preview_uri": "http://dms-vue-test.basement.jp/api/articles/preview/1",
    "public_uri": "http://dms-vue-test.basement.jp/api/articles/public/eyJpdiI6IlRqRWlWVE1CSjZPWXA5NkJ1OFVZVmc9PSIsInZhbHVlIjoieTl5dlRwUjc1ZWRadGZSNEQxUHo1Zz09IiwibWFjIjoiZTM0ZWMzOWJlMWRiZWE5MzdhZjg2OGE3NThlZDFiN2VhNDBhOTc4ZWIxNWM2Mzg4YmNiMTk2ZTJhMDVmZGE5NiJ9",
    "created_at": "2018-01-01 00:00:00",
    "updated_at": "2018-01-01 00:00:00"
  }
]
```

## 記事詳細

記事の詳細の取得を行う

### Request URI

GET: /api/articles/:id

### Request Parameters

#### URI Parameters

id: 記事 ID

### 200 OK

```
{
    "id": 1,
    "title": "記事タイトル",
    "date_time": "2018-01-01 00:00:00",
    "public_status": false,
    "html": "<b>記事HTML</b>",
    "preview_uri": "http://dms-vue-test.basement.jp/api/articles/preview/1",
    "public_uri": "http://dms-vue-test.basement.jp/api/articles/public/eyJpdiI6IlRqRWlWVE1CSjZPWXA5NkJ1OFVZVmc9PSIsInZhbHVlIjoieTl5dlRwUjc1ZWRadGZSNEQxUHo1Zz09IiwibWFjIjoiZTM0ZWMzOWJlMWRiZWE5MzdhZjg2OGE3NThlZDFiN2VhNDBhOTc4ZWIxNWM2Mzg4YmNiMTk2ZTJhMDVmZGE5NiJ9",
    "created_at": "2018-01-01 00:00:00",
    "updated_at": "2018-01-01 00:00:00"
}
```

### 404 Not Found

```
{
    "success": false,
    "errors": [
        "Not found"
    ]
}
```

## 記事投稿

記事の新規投稿を行う

### Request URI

POST: /api/articles

### Request Parameters

#### Headers

```
Content-Type: application/json
Accept: application/json
```

#### Body

```
{
   "date_time": "2018-01-01 00:00:00",
   "title": "記事タイトル",
   "html": "<b>記事HTML</b>",
   "public_status: "false"
}
```

### 201 Created

```
{
    "success": true
}
```

### 422 Unprocessable Entity

```
{
    "success": false,
    "errors": [
        "Save failure"
    ]
}
```

## 記事編集

記事の編集を行う

### Request URI

PUT: /api/articles/:id

### Request Parameters

#### URI Parameters

id: 記事 ID

#### Headers

```
Content-Type: application/json
Accept: application/json
```

#### Body

```
{
   "date_time": "2018-01-01 00:00:00",
   "title": "記事タイトル",
   "html": "<b>記事HTML</b>",
   "public_status: "false"
}
```

### 204 No Content

```
{
    "success": true
}
```

### 404 Not Found

```
{
    "success": false,
    "errors": [
        "Not Found"
    ]
}
```

### 422 Unprocessable Entity

```
{
    "success": false,
    "errors": [
        "Save failure"
    ]
}
```

## 記事削除

記事の削除を行う

### Request URI

DELETE: /api/articles/:id

### Request Parameters

#### URI Parameters

id: 記事 ID

#### Headers

```
Content-Type: application/json
Accept: application/json
```

### 204 No Content

```
{
    "success": true
}
```

### 404 Not Found

```
{
    "success": false,
    "errors": [
        "Not Found"
    ]
}
```

### 422 Unprocessable Entity

```
{
    "success": false,
    "errors": [
        "Delete failure"
    ]
}
```
