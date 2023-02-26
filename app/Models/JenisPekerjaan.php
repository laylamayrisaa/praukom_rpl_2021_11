<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPekerjaan extends Model {
    use HasFactory;

    // kasih tau tabel yang ada di databasenya
    protected $table = 'jenis_pekerjaan';

    // kasih tau primary key yang ada di tabel yang bersangkutan
    protected $primaryKey = 'id_jenis_pekerjaan';

    // set timestamps menjadi false, karena kalau pakai model otomatis dia memasukkan timestamps juga
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nama_jenis_pekerjaan'];

    public function pengalaman_user(): HasMany {
        return $this->hasMany(PengalamanKerja::class, 'id_jenis_pekerjaan', 'id_jenis_pekerjaan');
    }
}
