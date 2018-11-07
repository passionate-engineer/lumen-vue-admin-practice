<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Article;

class ArticlesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->apiURI = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api';
    }

    private function getFormatedDate($dateTime = 'now') {
      return date('Y-m-d H:i:s', strtotime($dateTime));
    }

    public function index()
    {
      // 全件取得
      $articles = Article::all();

      foreach($articles as $articleKey => $article) {
        // パラメータ加工
        $articles[$articleKey]->public_status = ($article->public_status === '1') ? true : false;
        $articles[$articleKey]->preview_uri = $this->apiURI . '/articles/preview/' . $articles[$articleKey]->id;
        $articles[$articleKey]->public_uri = $this->apiURI . '/articles/public/' . $articles[$articleKey]->id_hash;

        // パラメータ削除
        unset($articles[$articleKey]->id_hash);
        unset($articles[$articleKey]->html);
        unset($articles[$articleKey]->password);
      } 

      // 成功レスポンス
      return response($articles, 200);
    }

    public function create(Request $request)
    {
      // リクエスト取得
      $req = $request->all();

      // バリデーション
      $errors = Validator::make($req, [
        'title' => 'max:64',
        'date_time' => 'date',
        'html' => 'string',
        'public_status' => 'boolean',
      ])->errors()->all();

      if (count($errors)) {
        return response(['success' => false, 'errors' => $errors], 422);
      }

      // データ作成
      $article = new Article;

      // パラメータ代入
      $article->id_hash = Crypt::encryptString(rand());
      $article->date_time = ($req['date_time']) ? $this->getFormatedDate($req['date_time']) : $this->getFormatedDate();
      $article->title = $req['title'];
      $article->html = ($req['html']) ?  $req['html'] : '';
      $article->public_status = ($req['public_status'] === true);

      // DB保存
      if (!$article->save()) {
        return response(['success' => false, 'errors' => ['Save failure.']], 422);
      }

      // 成功レスポンス
      return response(['success' => true], 201);
    }

    public function show($id)
    {
      // データ取得
      $article = Article::where('id', $id)->first();
      if (!isset($article)) {
        return response(['success' => false, 'errors' => ['Not found.']], 404);
      }

      // パラメータ加工
      $article->public_status = ($article->public_status === '1') ? true : false;
      $article->preview_uri = $this->apiURI . '/articles/preview/' . $article->id;
      $article->public_uri = $this->apiURI . '/articles/public/' . $article->id_hash;

      // パラメータ削除
      unset($article->id_hash);
      unset($article->password);

      // 成功レスポンス
      return response($article, 200);
    }

    public function update($id, Request $request)
    {
      // リクエスト取得
      $req = $request->all();

      // バリデーション
      $errors = Validator::make($req, [
        'title' => 'max:64',
        'date_time' => 'date',
        'html' => 'string',
        'public_status' => 'boolean',
      ])->errors()->all();

      if (count($errors)) {
        return response(['success' => false, 'errors' => $errors], 422);
      }

      // データ取得
      $article = Article::where('id', $id)->first();
      if (!isset($article)) {
        return response(['success' => false, 'errors' => ['Not found.']], 404);
      }

      // パラメータ代入
      $article->date_time = $this->getFormatedDate($req['date_time']);
      $article->title = $req['title'];
      $article->html = $req['html'];
      $article->public_status = ($req['public_status'] === true);

      // DB保存
      if (!$article->save()) {
        return response(['success' => false, 'errors' => ['Save failure.']], 422);
      }

      // 成功レスポンス
      return response(['success' => true], 204);
    }

    public function delete($id)
    {
      // データ取得
      $article = Article::where('id', $id)->first();
      if (!isset($article)) {
        return response(['success' => false, 'errors' => ['Not found.']], 404);
      }

      // DB削除
      if (!$article->delete()) {
        return response(['success' => false, 'errors' => ['Save failure.']], 422);
      }

      // 成功レスポンス
      return response(['success' => true], 204);
    }

    public function preview($id)
    {
      // データ取得(HTML)
      $article = Article::where('id', $id)->first();
      if (!isset($article)) {
        return response('Not found.', 404, ['Content-Type' => 'text/html']);
      }

      // 成功レスポンス(HTML)
      return response($article->html, 200, ['Content-Type' => 'text/html']);
    }

    public function public($id_hash)
    {
      // データ取得(HTML)
      $article = Article::where('id_hash', $id_hash)->where('public_status', 1)->first();
      if (!isset($article)) {
        return response('Not found.', 404, ['Content-Type' => 'text/html']);
      }

      // 成功レスポンス(HTML)
      return response($article->html, 200, ['Content-Type' => 'text/html']);
    }
}
