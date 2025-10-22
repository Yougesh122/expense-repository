<?php

namespace Modules\Expense\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Expense extends Model
{
    public $incrementing = false;
    protected $keyType = 'string'; // UUID

    protected $fillable = [
        'id',
        'title',
        'amount',
        'category',
        'expense_date',
        'notes'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }


        /**
     * @return Attribute
     */
    protected function expenseDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => !empty($value) ? Carbon::parse($value)->format(config('app.default_date_format_php')) : null,
            set: fn($value) => Carbon::createFromFormat(config('app.default_date_format_php'), $value)->format('Y-m-d'),
        );
    }
}
