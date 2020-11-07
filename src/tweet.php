<?php


class TweetManager
{
	public $oauth_instance;

	public function __construct($oauth_instance)
	{
		$this->oauth_instance = $oauth_instance;
	}

	public function get_timeline($count = 3)
	{
		return $this->oauth_instance->get(
			"statuses/home_timeline",
			array(
				"count" => $count
			)
		);
	}

	public function fetch_tweet_id_containg_keywords($tweets, $keywords)
	{
		$id_lists = [];

		foreach ($tweets as $tweet) {
			foreach ($keywords as $keyword) {
				if (strpos($tweet->text, $keyword) !== false) {
					// if tweet contains any keyword
					$id_lists[] = $tweet->id;
					break;
				}
			}
		}

		return $id_lists;
	}

	public function retweet($tweet_ids)
	{
		$count = 0;
		foreach ($tweet_ids as $tweet_id) {
			if (isset($_SESSION['retweeted'][$tweet_id])) {
				// if the tweet is already retweeted
				continue;
			}

			$result = $this->oauth_instance->post("statuses/retweet/$tweet_id");

			if (!empty($result->errors)) {
				foreach ($result->errors as $error) {
					echo $error->message . "\n";
				}
			}

			// set tweet_id to session
			$_SESSION['retweeted'][$tweet_id] = true;
			$count++;
		}

		return $count;
	}
}
