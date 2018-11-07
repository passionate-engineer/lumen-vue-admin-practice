# lumen-vue-admin-practice

The admin practice pack for Lumen and VueJS.

## API

##  記事一覧

記事の一覧の取得を行う。

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
    "preview_uri": "http://xxxx/preview/1",
    "public_uri": "http://xxxx/public/eyJpdiI6IlRqRWlWVE1CSjZPWXA5NkJ1OFVZVmc9PSIsInZhbHVlIjoieTl5dlRwUjc1ZWRadGZSNEQxUHo1Zz09IiwibWFjIjoiZTM0ZWMzOWJlMWRiZWE5MzdhZjg2OGE3NThlZDFiN2VhNDBhOTc4ZWIxNWM2Mzg4YmNiMTk2ZTJhMDVmZGE5NiJ9",
    "created_at": "2018-01-01 00:00:00",
    "updated_at": "2018-01-01 00:00:00"
  }
]
```

##  記事詳細

記事の詳細の取得を行う。

GET: /api/articles/:id

### Request Parameters

#### URI Parameters

ID: 記事 ID

### 200 OK

```
{
    "id": 1,
    "title": "記事タイトル",
    "date_time": "2018-01-01 00:00:00",
    "public_status": false,
    "html": "<b>記事HTML</b>",
    "preview_uri": "http://xxxx/preview/1",
    "public_uri": "http://xxxx/public/eyJpdiI6IlRqRWlWVE1CSjZPWXA5NkJ1OFVZVmc9PSIsInZhbHVlIjoieTl5dlRwUjc1ZWRadGZSNEQxUHo1Zz09IiwibWFjIjoiZTM0ZWMzOWJlMWRiZWE5MzdhZjg2OGE3NThlZDFiN2VhNDBhOTc4ZWIxNWM2Mzg4YmNiMTk2ZTJhMDVmZGE5NiJ9",
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

##  記事投稿

記事の新規投稿を行う。

POST: /api/articles

### Request Parameter

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

##  記事編集

記事の編集を行う。

PUT: /api/articles/:id

### Request Parameters

#### URI Parameters

ID: 記事 ID

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

##  記事削除

記事の削除を行う。

DELETE: /api/articles/:id

### Request Parameters

#### URI Parameters

ID: 記事 ID

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
