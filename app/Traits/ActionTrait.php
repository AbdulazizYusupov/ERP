<?php

namespace App\Traits;

use App\Models\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait ActionTrait
{
    public static function bootActionTrait()
    {
        static::created(function (Model $model) {
            $model->logHistory('created', $model->toArray());
        });

        static::updated(function (Model $model) {
            $model->logHistory('updated', [
                'old' => $model->getOriginal(),
                'new' => $model->getChanges(),
            ]);
        });

        static::deleted(function (Model $model) {
            $model->logHistory('deleted', $model->toArray());
        });
    }

    protected function logHistory(string $action, array $data)
    {
        Action::create([
            'actionable_type' => static::class,
            'actionable_id' => $this->id,
            'action' => $action,
            'data' => json_encode($data),
            'user_id' => Auth::id(),
        ]);
    }

    public function actionHistories()
    {
        return $this->morphMany(Action::class, 'actionable');
    }
}
