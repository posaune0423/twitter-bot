# twitterOatuhWrapper

This is simple php script which allows you to search tweets containing given keywords like "RT", "follow & retweet" so that you can get a kind of prize 💵 or gift🎁


In my repository, I use a very useful php library [abraham/twitteroauth](https://github.com/abraham/twitteroauth) developed by [abraham](https://github.com/abraham).

At the same time this provides TwitterOauthWrapper class so that you can use oauth library easily.


## Prerequisites

This script works on [Heroku](https://dashboard.heroku.com/).
So, if you don't have Heroku Account yet, please signup [here](https://signup.heroku.com/login)

Also It is necessary to install Heroku CLI into your terminal.
if you haven't installed it yet, please run this command below.

```
$ brew tap heroku/brew && brew install heroku
```

In addition to above, you need to obtain user access token for using Twitter API.
please obtain them before getting started.
if you are not familier with twitter api, Check it out [Here](https://www.slickremix.com/docs/how-to-get-api-keys-and-tokens-for-twitter/)



## Installation & Getting started


1. First, you need to clone this repository to anywhere you want.
```
$ git clone https://github.com/posaune0423/twitterOauthWrapper.git

$ cd twitterOauthWrapper

$ vi config.php
```

then you should see like this
```
<?php

define('CONSUMER_KEY', 'your consumerkey');
define('CONSUMER_SECRET', 'your consumer secret key');
define('ACCESS_TOKEN', 'your access token');
define('ACCESS_TOKEN_SECRET', 'your secret access token');
```
please replace `your ~` statement with your actual API access token respectively.
and commit changes you made now

```
$ git add config.php

$ git commit -m "set API Key"
```


2. Then, login to heroku, and create heroku app.
```
$ heroku login

$ heroku create [your app name or blank]
```

3. Add your git local repository to heroku remote repositry.
```
$ git remote add heroku https://git.heroku.com/{yourapp name}.git

$ git remote -v
```

4. then push this repository to your heroku app created right now
```
$ git push heroku master
```

5. Test the script by running it in a one-off worker dyno just to see it work before scheduling it

```
$ heroku run php src/test.php
Running php src/test.php on ⬢ shielded-cove-80623... up, run.2427 (Free)
It Works !
```

6. Add the [Scheduler Add-on](https://devcenter.heroku.com/articles/scheduler)

```
$ heroku addons:add scheduler:standard
```

7. Open the scheduler configuration page
```
$ heroku addons:open scheduler
```

8. Add the script as a job. Same as one-off step above, but without the `heroku run` - Add job... - `$ php src/main.php`

9. View the scheduled job running in the logs

```
$ heroku logs
2020-11-08T04:21:29.339953+00:00 app[api]: Starting process with command `php src/main.php` by user scheduler@addons.heroku.com
2020-11-08T04:21:30.974962+00:00 heroku[scheduler.4261]: Starting process with command `php src/main.php`
2020-11-08T04:21:31.608102+00:00 heroku[scheduler.4261]: State changed from starting to up
2020-11-08T04:21:33.370411+00:00 app[scheduler.4261]: PHP Deprecated:  Array and string offset access syntax with curly braces is deprecated in /app/vendor/abraham/twitteroauth/src/SignatureMethod.php on line 61
2020-11-08T04:21:33.370445+00:00 app[scheduler.4261]: PHP Deprecated:  Array and string offset access syntax with curly braces is deprecated in /app/vendor/abraham/twitteroauth/src/SignatureMethod.php on line 61
2020-11-08T04:21:33.691640+00:00 app[scheduler.4261]: Success! 1 tweets has been retweeted
2020-11-08T04:21:33.752897+00:00 heroku[scheduler.4261]: Process exited with status 0
2020-11-08T04:21:33.793979+00:00 heroku[scheduler.4261]: State changed from up to complete

```
