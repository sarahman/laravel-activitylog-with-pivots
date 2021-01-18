# Laravel Activity Log with Pivots

This package highly depends on the `spatie/laravel-activitylog` and `fico7489/laravel-pivot` composer packages. This package deals with all kinds of `Eloquent` events based logging as well as the `Pivot` models events.

## Installation

1. Install package with composer:
```bash
composer require sarahman/laravel-activitylog-with-pivots
```
With this statement, the highest available package version for your current laravel/lumen version will be installed.

2. Follow the [documentation](https://docs.spatie.be/laravel-activitylog.) of the `spatie/laravel-activitylog` to install with skipping the `composer` package installation command.

3. Use `Sarahman\Database\Support\Traits\LogsActivityWithPivots` trait in your base model or only in particular models.

```php
use Sarahman\Database\Support\Traits\LogsActivityWithPivots;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use LogsActivityWithPivots;
    ...
    ...
}
```

and that's it; enjoy!

## New Eloquent Events

You can check all the Eloquent events here: (https://laravel.com/docs/master/eloquent#events)

The following Pivot based events functionality is customized:

```
pivotAttached, pivotDetached, pivotUpdated
```

The activity log is also stored while these pivot events will be occurred. You may check the other Pivot events [here](https://github.com/fico7489/laravel-pivot#new-eloquent-events).

## Licence

MIT

## Support

If you are having general issues with this package, feel free to contact me through Gmail.

If you believe you have found an issue, please report it using the GitHub issue tracker, or better yet, fork the repository and submit a pull request.

If you're using this package, I'd love to hear your thoughts. Thanks!
