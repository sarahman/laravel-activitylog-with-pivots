<?php

namespace Sarahman\Database\Support\Traits;

use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\Traits\LogsActivity;

trait LogsActivityWithPivots
{
    use LogsActivity, PivotEventTrait;

    protected static function bootLogsActivity()
    {
        return;
    }

    protected static function bootLogsActivityWithPivots()
    {
        static::eventsToBeRecorded()->each(function ($eventName) {
            return static::$eventName(function (Model $model) use ($eventName) {
                if (!$model->shouldLogEvent($eventName)) {
                    return;
                }

                $description = $model->getDescriptionForEvent($eventName);

                $logName = $model->getLogNameToUse($eventName);

                if ($description == '') {
                    return;
                }

                $logger = app(ActivityLogger::class)
                    ->useLog($logName)
                    ->performedOn($model)
                    ->withProperties($model->attributeValuesToBeLogged($eventName));

                if (method_exists($model, 'tapActivity')) {
                    $logger->tap([$model, 'tapActivity'], $eventName);
                }

                $logger->log($description);
            });
        });

        collect(['pivotAttached', 'pivotDetached', 'pivotUpdated'])->each(function ($eventName) {
            return static::$eventName(function (Model $model, $relationName, $pivotIds, $pivotIdsAttributes) use ($eventName) {
                $logger = app(ActivityLogger::class)->useLog($model->getLogNameToUse($eventName));

                foreach ($pivotIds as $pivotId) {
                    $properties = [
                        'relationName' => $relationName,
                        'pivot_id' => $pivotId,
                        'pivotData' => empty($pivotIdsAttributes[$pivotId]) ? [] : $pivotIdsAttributes[$pivotId],
                    ];

                    $logger->performedOn($model)->withProperties($properties);

                    if (method_exists($model, 'tapActivity')) {
                        $logger->tap([$model, 'tapActivity'], $eventName);
                    }

                    $logger->log($model->getDescriptionForEvent($eventName));
                }
            });
        });
    }
}
