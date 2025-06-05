# PubSubHubbub PHP Subscriber

This PHP library implements a subscriber for PubSubHubbub (WebSub) with support for the `hub.secret` parameter for secure HMAC signature verification.

It was originally written by [Josh Fraser](http://joshfraser.com) and is currently maintained by [CureSaba](https://github.com/CureSaba).  
Released under the Apache 2.0 License.

**Official package:** [pubsubhubbub/subscriber](https://github.com/pubsubhubbub/php-subscriber)  
**Maintained fork:** [curesaba/php-subscriber](https://github.com/CureSaba/php-subscriber)

---

## Install

Update your `composer` require block:
```json
"require": { "curesaba/php-subscriber": "*" }
```

Or install via Composer:
```sh
composer require curesaba/php-subscriber
```

---

## Usage

```php
use \Pubsubhubbub\Subscriber\Subscriber;

$hub_url      = "http://pubsubhubbub.appspot.com";
$callback_url = "https://yourdomain.example/endpoint";
$secret       = "your-very-random-string"; // Used for HMAC verification

// create a new subscriber with secret (hub.secret)
$s = new Subscriber($hub_url, $callback_url, false, $secret);

$feed = "http://feeds.feedburner.com/onlineaspect";

// subscribe to a feed
$s->subscribe($feed);

// unsubscribe from a feed
$s->unsubscribe($feed);
```

### Parameters

- **$hub_url**: The PubSubHubbub (WebSub) hub endpoint.
- **$callback_url**: Your endpoint to receive notifications.
- **$credentials**: (Optional) HTTP Basic Auth credentials for the hub.
- **$secret**: (Optional but recommended) Secret string for verifying HMAC signatures (`hub.secret`).

---

## HMAC Signature Verification

When using `hub.secret`, notifications sent from the hub will include an `X-Hub-Signature` header.  
You should verify this in your callback endpoint:

```php
$body = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';
$expected = 'sha1=' . hash_hmac('sha1', $body, $secret);

if (hash_equals($expected, $signature)) {
    // Signature valid
} else {
    // Signature invalid
}
```

---

## License

Apache License 2.0  
