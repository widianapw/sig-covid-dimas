<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = "tb_pasien";
    protected $fillable = ['id_kabupaten', 'positif', 'dalam_perawatan', 'sembuh', 'meninggal','tanggal_data'];
}
