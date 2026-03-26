<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role')->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function staffProfile()
    {
        return $this->hasOne(Staff::class, 'user_id');
    }

    /**
     * Whether the user has a permission granted through any assigned role.
     */
    public function hasPermission(string $name): bool
    {
        return $this->roles()->whereHas('permissions', function (Builder $query) use ($name) {
            $query->where('permissions.name', $name);
        })->exists();
    }

    /**
     * @param  list<string>  $names
     */
    public function hasAllPermissions(array $names): bool
    {
        foreach ($names as $name) {
            if (! $this->hasPermission($name)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param  list<string>  $names
     */
    public function hasAnyPermission(array $names): bool
    {
        return $this->roles()->whereHas('permissions', function (Builder $query) use ($names) {
            $query->whereIn('permissions.name', $names);
        })->exists();
    }
}
