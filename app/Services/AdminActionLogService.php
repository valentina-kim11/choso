<?php

namespace App\Services;

use App\Models\AdminActionLog;
use Illuminate\Database\Eloquent\Model;

class AdminActionLogService
{
    public static function log(int $adminId, string $action, Model $subject, array $meta = []): void
    {
        AdminActionLog::create([
            'admin_id'    => $adminId,
            'action'      => $action,
            'target_type' => $subject->getMorphClass(),
            'target_id'   => $subject->getKey(),
            'metadata'    => $meta,
        ]);
    }
}
