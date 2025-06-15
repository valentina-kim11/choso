<?php

namespace App\Services;

use App\Models\AdminActionLog;


class AdminActionLogService
{
    public static function log(string $action, string $targetType, string $targetId, array $metadata = []): void
    {
        AdminActionLog::create([
            'admin_id' => auth()->id(),
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'description' => $metadata ? json_encode($metadata) : null,

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
