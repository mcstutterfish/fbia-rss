# FBIARss

Facebook Instant Articles RSS builder for Laravel 4


## Installation

Add `mcstutterfish/fbia-rss` to `composer.json`.

    "mcstutterfish/fbia-rss": "0.1.x"
    
Run `composer update` to pull down the latest version of FBIARss.

Now open up `app/config/app.php` and add the service provider to your `providers` array.

    'providers' => array(
        'FBIARss\FBIARssServiceProvider',
    )

Now add the alias.

    'aliases' => array(
        'FBIARss' => 'FBIARss\FBIARssFacade',
    )


## Usage

Returns the feed

	Route::get('/', function()
	{
		$feed = FBIARss::feed('2.0', 'UTF-8');
		$feed->channel(array('title' => 'Channel\'s title', 'description' => 'Channel\'s description', 'link' => 'http://www.test.com/'));
		for ($i=1; $i<=5; $i++){
			$feed->item(array('title' => 'Item '.$i, 'description|cdata' => 'Description '.$i, 'link' => 'http://www.test.com/article-'.$i));
		}

		return Response::make($feed, 200, array('Content-Type' => 'text/xml'));
	});

Save the feed

	Route::get('/', function()
	{
		$feed = FBIARss::feed('2.0', 'UTF-8');
		$feed->channel(array('title' => 'Channel\'s title', 'description' => 'Channel\'s description', 'link' => 'http://www.test.com/'));
		for ($i=1; $i<=5; $i++){
			$feed->item(array('title' => 'Item '.$i, 'description|cdata' => 'Description '.$i, 'link' => 'http://www.test.com/article-'.$i));
		}

		$feed->save('test.xml');
	});
