<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'tb_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tb_hakakses_id',
        'akses_modul',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'akses_modul' => 'array',
        ];
    }

    /**
     * Get the hak akses associated with the user.
     */
    public function hakakses(): BelongsTo
    {
        return $this->belongsTo(HakAkses::class, 'tb_hakakses_id');
    }

    /**
     * Get the guru record associated with the user.
     */
    public function guru(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Guru::class, 'tb_user_id');
    }

    /**
     * Check if user has access to a specific module or submodule.
     */
    public function hasAccess(string $permission): bool
    {
        if ($this->hakakses && $this->hakakses->nama_hakakses === 'administrator') {
            return true;
        }

        $permissions = $this->akses_modul;
        if (!is_array($permissions)) {
            return false;
        }

        return in_array($permission, $permissions);
    }
}
