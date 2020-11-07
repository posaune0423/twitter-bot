<?php


class TweetManager
{
	public $oauth_instance;
	public $retweeted_list;

	public function __construct($oauth_instance)
	{
		$this->oauth_instance = $oauth_instance;
	}

	/**
	 *
	 * get tweet objects in your timeline by using twitter api
	 *
	 * @param int $count
	 * @return stdClass
	 */
	public function get_timeline($count = 10)
	{
		return $this->oauth_instance->get(
			"statuses/home_timeline",
			array(
				"count" => $count
			)
		);
	}

	/**
	 *
	 * fetch tweets containg given keywords and return id_lists
	 *
	 * @param stdClass $tweets
	 * @param array $keyword
	 * @return array
	 */
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

	/**
	 *
	 * retweet multiple tweets by given tweet_ids if the tweet has not been retweeted yet.
	 * and return the number of retweeted tweets at the time.
	 * @param array $tweet_ids
	 * @return int
	 */
	public function retweet($tweet_ids)
	{
		$count = 0;
		foreach ($tweet_ids as $tweet_id) {
			if (isset($this->retweeted_list[$tweet_id])) {
				// if the tweet is already retweeted
				continue;
			}

			$result = $this->oauth_instance->post("statuses/retweet/$tweet_id");

			if (!empty($result->errors)) {
				foreach ($result->errors as $error) {
					echo $error->message . "\n";
				}
			}

			// set rewteeted tweet to mamber variables
			$this->retweeted_list[$tweet_id] = true;
			$count++;
		}

		return $count;
	}
}
