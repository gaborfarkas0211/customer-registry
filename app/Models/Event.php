<?php

namespace App\Models;

use App\Enums\EventType;
use App\Enums\ReceptionDay;
use App\Enums\ReceptionType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereReceptionTimeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
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
}