<?php


class TweetManager
{
	public $oauth_instance;

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
	 * fetch tweets which has not retweeted yet containg given keywords and return id_lists
	 *
	 *
	 * @param stdClass $tweets
	 * @param array $keyword
	 * @return array
	 */
	public function fetch_tweet_id_containing_keywords($tweets, $keywords)
	{
		$id_lists = [];

		foreach ($tweets as $tweet) {
			if ($tweet->retweeted) {
				// if the tweet has already been retweeted
				continue;
			}

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
	 * tweet the given content
	 *
	 * @param string $content
	 * @return
	 */
	public function tweet($content)
	{
		$result = $this->oauth_instance->post(
			"statuses/update",
			array("status" => $content)
		);

		return $result;
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
			$result = $this->oauth_instance->post("statuses/retweet/$tweet_id");

			if (!empty($result->errors)) {
				foreach ($result->errors as $error) {
					echo $error->message . "\n";
				}
			}

			$count++;
		}

		return $count;
	}
}
