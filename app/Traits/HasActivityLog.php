<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait HasActivityLog
{
    /**
     * Log an activity to the database.
     *
     * @param string $action CREATE, UPDATE, DELETE
     * @param string $model Model name (e.g., Report, Comment)
     * @param int|null $modelId ID of the affected model
     * @param string $description Human-readable description
     * @param array $payload Optional data about the change
     */
    public function logActivity($action, $model, $modelId, $description, $payload = [])
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'payload' => $payload,
        ]);
    }
}
