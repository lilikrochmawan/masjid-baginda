<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TakmirBroadcast extends Model
{
    use HasFactory;

    protected $table = 'tb_takmir_broadcast';

    protected $fillable = [
        'judul',
        'isi_pengumuman',
        'target_type',
        'target_detail',
        'status',
        'total_sent',
        'created_by',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
