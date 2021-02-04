# SparrowSms Notifications Channel for Laravel



This package makes it easy to send sms notification using [SparrowSms API](https://sparrowsms.com/services/sms-gateway-api/) with Laravel.

## Installation

You can install the package via composer:

```bash
composer require aankhijhyaal/laravel-sparrow
```

## Setting up your Credentials

Publish the configuration file

```php
php artisan vendor:publish --tag=laravel-sparrow
```

Configure your SparrowSms API Credentials:

```php
// config/sparrow.php
'url' => <endpoint of sparrow sms API>,
'token' => <token generated from sparrow sms website>,
'identity'=><provided by sparrow sms>
```


## Usage

You can now use the channel in your `via()` method inside the Notification class.

### Text Notification

```php
use Aankhijhyaal\LaraSparrow\SmsMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return ['sparrow'];
    }

    public function toSparrow($notifiable)
    {
        return (new SmsMessage())
                ->setContent("Your message.")
                ->setRecipient($notifiable->phone);
    }
}
```

## License

The MIT License ([MIT](https://opensource.org/licenses/MIT)).


