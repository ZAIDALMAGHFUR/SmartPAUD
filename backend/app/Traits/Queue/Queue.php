<?php

namespace App\Traits\Queue;

use Carbon\Carbon;
use App;

trait Queue
{
    public function QueueDokter($IdDokter)
    {
        $getQueueDokter = App\Models\Transtransaction\Registrasi\PasienDiPeriksa::where('dokter_id', $IdDokter)
            ->where('statusenabled', true)
            ->count();
        return $getQueueDokter == 0 ? 1 : $getQueueDokter;
    }
}
