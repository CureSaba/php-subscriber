<?php

// simple example for the PHP pubsubhubbub Subscriber
// as defined at http://code.google.com/p/pubsubhubbub/
// written by Josh Fraser | joshfraser.com | josh@eventvue.com
// written by CureSabs | saba.ad1357@gmail.com
// Released under Apache License 2.0

include("./src/Subscriber.php");

use \Pubsubhubbub\Subscriber\Subscriber;

$hub_url = "http://pubsubhubbub.appspot.com";
$callback_url = "put your own endpoint here";
$feed = "http://feeds.feedburner.com/onlineaspect";
$secret = "your-very-random-string";

// create a new subscriber with secret
$s = new Subscriber($hub_url, $callback_url, false, $secret);

// subscribe to a feed
$s->subscribe($feed);

// unsubscribe from a feed
$s->unsubscribe($feed);
