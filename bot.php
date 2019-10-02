<?php

require_once(__DIR__ . '/config.php');

require 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

//必要なキーを読み込む
$connection = new TwitterOAuth(
  CONSUMER_KEY,
  CONSUMER_SECRET,
  ACCESS_TOKEN,
  ACCESS_TOKEN_SECRET);

//キーワードを含むツイートを検索
$content = $connection->get("search/tweets",
  array(
    'q' => 'フォローしリツイート OR フォロー＆リツイート OR フォロー＆RT',
    'count' => '10',
    'lang' => 'ja',
    'lacale' => 'ja',
    'result_type' => 'recent',
    'include_entities' => 'false'
  )
);

  $id_list = [];

//取得したツイートのIDを配列に格納
  foreach($content->statuses as $tweet) {
    $id = $tweet->id;
    array_push($id_list, $id);
  }

//配列からIDを取得しリツイート
  foreach($id_list as $key){
    $retweets = $connection->post("statuses/retweet/$key");
    // var_dump($retweets);
  }



if ($connection->getLastHttpCode() === 200) {
    echo "Success!" . PHP_EOL;
} else {
    echo "Error!" . PHP_EOL;
}
