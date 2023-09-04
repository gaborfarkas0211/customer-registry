<?php

namespace App\Models;

use App\Enums\EventType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $start_time
 * @property string $end_time
 * @property string $title
 * @property int|null $reception_time_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\ReceptionTime|null $receptionTime
 * @method static Builder|Event endTimeRange(string $startTime, string $endTime)
 * @method static \Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|Event startTimeRange(string $startTime, string $endTime)
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereEndTime($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereReceptionTimeId($value)
 * @method static Builder|Event whereStartTime($value)
 * @method static Builder|Event whereTitle($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'reception_time_id',
        'title',
    ];

    public function receptionTime(): BelongsTo
    {
        return $this->belongsTo(ReceptionTime::class);
    }

    public function hasReceptionTime(): bool
    {
        return $this->receptionTime()->exists();
    }

    public function getType(): EventType
    {
        if ($this->hasReceptionTime()) {
            return EventType::Background;
        }

        return EventType::Normal;
    }

    public static function scopeStartTimeRange(Builder $query, string $startTime, string $endTime): Builder
    {
        return $query->where('start_time', '>=', $startTime)
            ->where('start_time', '<', $endTime);
    }

    public static function scopeEndTimeRange(Builder $query, string $startTime, string $endTime): Builder
    {
        return $query->where('end_time', '>', $startTime)
            ->where('end_time', '<=', $endTime);
    }
}
