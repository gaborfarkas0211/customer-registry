<?php

namespace App\Models;

use App\Enums\ReceptionDay;
use App\Enums\ReceptionType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CustomerReceptionTime
 *
 * @property int $id
 * @property Carbon $start_date
 * @property Carbon|null $end_date
 * @property Carbon $event_end_date
 * @property ReceptionType $type
 * @property ReceptionDay $day
 * @property string $start_time
 * @property string $end_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Database\Factories\ReceptionTimeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceptionTime whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReceptionTime extends Model
{
    use HasFactory;

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'type' => ReceptionType::class,
        'day' => ReceptionDay::class,
    ];

    protected $fillable = [
        'start_date',
        'end_date',
        'type',
        'day',
        'start_time',
        'end_time',
    ];

    protected static function boot()
    {
        parent::boot();

        $setOneTimeAttributes = function (self $model) {
            if ($model->isOneTime()) {
                $model->end_date = $model->start_date;
                $model->day = ReceptionDay::getDay($model->start_date);
            }
        };

        static::creating($setOneTimeAttributes);
        static::updating($setOneTimeAttributes);
    }

    public function eventEndDate(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->end_date ?? config('reception_times.end_date')),
        );
    }

    public function isOneTime(): bool
    {
        return $this->type === ReceptionType::OneTime;
    }

    public function isTypeEvenWeek(): bool
    {
        return $this->type === ReceptionType::EvenWeek;
    }

    public function isTypeOddWeek(): bool
    {
        return $this->type === ReceptionType::OddWeek;
    }

    public function isTypeEveryWeek(): bool
    {
        return $this->type === ReceptionType::EveryWeek;
    }

}
