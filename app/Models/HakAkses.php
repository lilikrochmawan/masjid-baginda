<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HakAkses extends Model
{
    protected $table = 'tb_hakakses';

    protected $fillable = [
        'nama_hakakses',
        'deskripsi',
    ];

    /**
     * Get all users associated with this hak akses.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'tb_hakakses_id');
    }
}
