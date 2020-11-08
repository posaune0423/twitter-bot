<?php


require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/oauthwrapper.php');


$oauthwrapper = new TwitterOauthWrapper(
	CONSUMER_KEY,
	CONSUMER_SECRET,
	ACCESS_TOKEN,
	ACCESS_TOKEN_SECRET
);

// you can configure these keywords by yourself.
// BUT only the word "RT" may not work well when a tweet someone retweeted streamed in your TL
$keywords = ['リツイート', 'をRT', 'RTで', '&RT'];


$current_timeline = $oauthwrapper->get_timeline();
$id_lists = $oauthwrapper->fetch_tweet_id_containing_keywords($current_timeline, $keywords);


$result = $oauthwrapper->retweet($id_lists);


if ($oauthwrapper->getLastHttpCode() === 200) {
	echo 'Success! ' . $result . ' tweets has been retweeted' . "\n";
} else {
	echo 'Something went Wrong...' . "\n";
	echo $oauthwrapper->extract_error_message($oauthwrapper->getLastBody());
}
