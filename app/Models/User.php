<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'surname',
        'email',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $guard_name ='api';

    public function roles(): HasManyThrough
    {
        return $this->hasManyThrough(Role::class, UserRole::class, 'user_id', 'id', 'id', 'role_id')
                    ->select(['roles.id','is_active','name','title','weight']);
    }

    protected function activeRole(): Attribute
    {
        return Attribute::make(
            get: fn() => optional($this->roles()->where('is_active', true)->first())->name,
        );
    }

    public function role(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    public function hasRole($roles): bool
    {
        $usersActiveRole = $this->roles()->where('is_active', true)->first();

        if($usersActiveRole && in_array($usersActiveRole->name,$roles))
            return true;

        return false;
    }

    public function fullName() : Attribute
    {
        return new Attribute (
            get: fn ($value, $attributes) => (!is_null($attributes['name']) or !is_null($attributes['surname'])) ? trim("{$this->name} {$this->surname}") : null
        );
    }
    
    /**
     * Scope a query to only include active records.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}
