<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AppPasswordReset extends Model
{
    protected $table = 'app_password_resets';

    // PK UUID
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'email',
        'code_hash',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at'    => 'datetime',
    ];

    protected static function booted(): void
    {
        // Generar UUID automáticamente si no viene
        static::creating(function (self $model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (útiles para endpoints)
    |--------------------------------------------------------------------------
    */

    public function scopeNotUsed(Builder $q): Builder
    {
        return $q->whereNull('used_at');
    }

    public function scopeNotExpired(Builder $q): Builder
    {
        return $q->where('expires_at', '>', now());
    }

    public function scopeValid(Builder $q): Builder
    {
        return $q->notUsed()->notExpired();
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function markUsed(): void
    {
        $this->forceFill(['used_at' => now()])->save();
    }

    public function isExpired(): bool
    {
        return $this->expires_at instanceof Carbon
            ? $this->expires_at->isPast()
            : Carbon::parse($this->expires_at)->isPast();
    }

    public function isUsed(): bool
    {
        return !is_null($this->used_at);
    }
}
