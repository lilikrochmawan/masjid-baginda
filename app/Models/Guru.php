<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'tb_guru';

    protected $fillable = [
        'tb_user_id',
        'nip',
        'nama_guru',
        'no_hp',
        'alamat',
    ];

    /**
     * Get the user account associated with the teacher.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tb_user_id');
    }

    /**
     * Get the classes managed/taught by the teacher.
     */
    public function kelas(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'tb_kelas_guru', 'tb_guru_id', 'tb_kelas_id');
    }
}
