<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = [];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAvatarAttribute() {
        if ($this->profile_pic) {
            return asset('storage/photos/' . $this->profile_pic);
        } else {
            return asset('default-avatar.png');
        }
    }

    public function getFullnameAttribute() {
        $middle = $this->middlename ? ' ' . strtoupper(substr($this->middlename, 0, 1)) . '.' : '';
        return $this->firstname . $middle . ' ' . $this->lastname;
    }

    public function getMiddleinitialAttribute() {
        return $this->middlename ? strtoupper(substr($this->middlename, 0, 1)) . '.' : '';
    }
}
