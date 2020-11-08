<?php

require(dirname(__FILE__) . '/../vendor/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;


class TwitterOauthWrapper extends TwitterOAuth
{
	/**
	 *
	 * get tweet objects in your timeline by using twitter api
	 *
	 * @param int $count
	 * @return object
	 */
	public function get_timeline($count = 10)
	{
		return $this->get("statuses/home_timeline", ["count" => $count]);
	}

	/**
	 *
	 * tweet the given content
	 *
	 * @param string $content
	 * @return object
	 */
	public function tweet($content)
	{
		$result = $this->post("statuses/update", ["status" => $content]);

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
			$result = $this->post("statuses/retweet/$tweet_id");

			if (!empty($result->errors)) {
				echo $this->extract_error_message($result) . "\n";
				continue;
			}

			$count++;
		}

		return $count;
	}

	/**
	*
	* follow people by given user_id
	*
	* @param $user_id
	* @return object
	*/
	public function follow($user_id)
	{
		return $this->post('friendships/create', ['user_id' => $user_id]);
	}

	/**
	*
	* get user data by given username
	*
	* @param string $username
	* @return object
	*/
	public function get_user_info($username)
	{
		return $this->get('users/show', ['screen_name'=> $username]);
	}

	/**
	 *
	 * fetch tweets which has not retweeted yet containg given keywords and return id_lists
	 *
	 *
	 * @param array|object $tweets
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
	 * extract error message from twitter api response
	 *
	 * @param object $response_body
	 * @return string
	 */
	public function extract_error_message($response_body)
	{
		return $response_body->errors[0]->message;
	}
}
