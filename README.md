# PHP PubSubHubbub (WebSub) Subscriber

This PHP library implements a subscriber for PubSubHubbub (WebSub) with support for the `hub.secret` parameter for secure HMAC signature verification and flexible configuration options including `verify_token`.

Originally written by [Josh Fraser](http://joshfraser.com) and currently maintained by [CureSaba](https://github.com/CureSaba).  
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
$verify_token = "your-verify-token"; // Used to validate intent verification requests

// create a new subscriber with flexible options (all parameters optional except hub_url and callback_url)
$s = new Subscriber(
    $hub_url,
    $callback_url,
    false,           // credentials (optional)
    $secret,         // hub.secret (optional)
    'async',         // verify mode (optional, default 'async')
    $verify_token,   // verify_token (optional)
    3600             // lease_seconds (optional)
);

$feed = "http://feeds.feedburner.com/onlineaspect";

// subscribe to a feed
$s->subscribe($feed);

// unsubscribe from a feed
$s->unsubscribe($feed);

// You can also set properties after construction:
$s->setVerifyToken('another-token')->setLeaseSeconds(7200);
```

### Parameters

- **$hub_url**: The PubSubHubbub (WebSub) hub endpoint. (Required)
- **$callback_url**: Your endpoint to receive notifications. (Required)
- **$credentials**: (Optional) HTTP Basic Auth credentials for the hub.
- **$secret**: (Optional but recommended) Secret string for verifying HMAC signatures (`hub.secret`).
- **$verify**: (Optional) Verification mode `"async"` or `"sync"`. Default: `"async"`.
- **$verify_token**: (Optional) Token for intent verification.
- **$lease_seconds**: (Optional) Subscription lease duration in seconds.

#### Property Setters

All parameters (except `$google_key`) can also be set or changed after instantiation using the following setter methods:
- `setHubUrl($hub_url)`
- `setCallbackUrl($callback_url)`
- `setCredentials($credentials)`
- `setSecret($secret)`
- `setVerify($verify)`
- `setVerifyToken($verify_token)`
- `setLeaseSeconds($lease_seconds)`

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
