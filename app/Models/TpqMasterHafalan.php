<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TpqMasterHafalan extends Model
{
    use HasFactory;

    protected $table = 'tb_tpq_master_hafalan';

    protected $fillable = [
        'kategori',
        'nama',
        'keterangan',
    ];

    public function prestasi(): HasMany
    {
        return $this->hasMany(PrestasiSantri::class, 'tb_tpq_master_hafalan_id');
    }
}
