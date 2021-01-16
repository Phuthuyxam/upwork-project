<?php


namespace App\Modules\Post\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use OwenIt\Auditing\Contracts\Audit;
use OwenIt\Auditing\Contracts\Auditable;

class PostMeta extends Model implements Auditable
{
    protected $table = 'post_meta';
    protected $fillable = ['post_id','meta_key','meta_value','created_at','updated_at'];

    public function audits(): MorphMany
    {
        // TODO: Implement audits() method.
    }

    public function setAuditEvent(string $event): Auditable
    {
        // TODO: Implement setAuditEvent() method.
    }

    public function getAuditEvent()
    {
        // TODO: Implement getAuditEvent() method.
    }

    public function getAuditEvents(): array
    {
        // TODO: Implement getAuditEvents() method.
    }

    public function readyForAuditing(): bool
    {
        // TODO: Implement readyForAuditing() method.
    }

    public function toAudit(): array
    {
        // TODO: Implement toAudit() method.
    }

    public function getAuditInclude(): array
    {
        // TODO: Implement getAuditInclude() method.
    }

    public function getAuditExclude(): array
    {
        // TODO: Implement getAuditExclude() method.
    }

    public function getAuditStrict(): bool
    {
        // TODO: Implement getAuditStrict() method.
    }

    public function getAuditTimestamps(): bool
    {
        // TODO: Implement getAuditTimestamps() method.
    }

    public function getAuditDriver()
    {
        // TODO: Implement getAuditDriver() method.
    }

    public function getAuditThreshold(): int
    {
        // TODO: Implement getAuditThreshold() method.
    }

    public function getAttributeModifiers(): array
    {
        // TODO: Implement getAttributeModifiers() method.
    }

    public function transformAudit(array $data): array
    {
        // TODO: Implement transformAudit() method.
    }

    public function generateTags(): array
    {
        // TODO: Implement generateTags() method.
    }

    public function transitionTo(Audit $audit, bool $old = false): Auditable
    {
        // TODO: Implement transitionTo() method.
    }
}
