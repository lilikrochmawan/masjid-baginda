<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Takmir extends Model
{
    use HasFactory;

    protected $table = 'tb_takmir';

    protected $fillable = [
        'tb_user_id',
        'nama',
        'jabatan',
        'parent_id',
        'no_hp',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tb_user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Takmir::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Takmir::class, 'parent_id');
    }

    public function rencanaKerja(): HasMany
    {
        return $this->hasMany(RencanaKerja::class, 'tb_takmir_id');
    }
}
