<?php

namespace App\Traits\ReChecking;

use Carbon\Carbon;
use App;

trait ReChecking
{
    public function reCheckingStatusKunjungan($pasienId, $ruanganId)
    {
        $pasienDiPeriksa = App\Models\Transtransaction\Registrasi\PasienDiPeriksa::where('pasien_id', $pasienId)
            ->where('ruangan_id', $ruanganId)
            ->where('statusenabled', true)
            ->first();

        return $pasienDiPeriksa ? 2 : 1;
    }



    public function reCheckingStatusPasien($pasienId, $ruanganId)
    {
        $pasienStatus = App\Models\Transtransaction\Registrasi\PasienDaftar::where('pasien_id', $pasienId)
            ->where('ruanganakhir_id', $ruanganId)
            ->where('statusenabled', true)
            ->first();

        return $pasienStatus ? 2 : 1;
    }
}
