<?php

require_once('../config.php');
require_once('./tweet.php');
require '../vendor/autoload.php';


use Abraham\TwitterOAuth\TwitterOAuth;

//必要なキーを読み込む
$connection = new TwitterOAuth(
	CONSUMER_KEY,
	CONSUMER_SECRET,
	ACCESS_TOKEN,
	ACCESS_TOKEN_SECRET
);



$tweetmanager = new TweetManager($connection);
$keywords = ['リツイート', 'RT'];



$current_timeline = $tweetmanager->get_timeline(10);
$id_lists = $tweetmanager->fetch_tweet_id_containg_keywords($current_timeline, $keywords);


$result = $tweetmanager->retweet($id_lists);


if ($connection->getLastHttpCode() === 200) {
	echo 'Success! ' . $result . ' tweets has been retweeted' . "\n";
} else {
	echo 'Something went Wrong...' . "\n";
}
