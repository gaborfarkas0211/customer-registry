<?php

namespace App\Models;

use App\Enums\ReceptionDay;
use App\Enums\ReceptionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CustomerReceptionTime
 *
 * @property int $id
 * @property Carbon $start_date
 * @property Carbon|null $end_date
 * @property ReceptionType $type
 * @property ReceptionDay $day
 * @property string $start_time
 * @property string $end_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Database\Factories\CustomerReceptionTimeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerReceptionTime whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerReceptionTime extends Model
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

    public function isOneTime(): bool
    {
        return $this->type === ReceptionType::OneTime;
    }
}
