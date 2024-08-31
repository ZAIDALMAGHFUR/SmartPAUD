<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Master\RegistrationClient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RegistrationClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $idRegister = Str::uuid()->toString();
            $clientKey = Str::random(32);
            $serverKey = Str::random(32);
            $secretKey = Str::random(32);

            RegistrationClient::create([
                'name' => 'Client ' . $i,
                'id_register' => $idRegister,
                'client_key' => $clientKey,
                'server_key' => $serverKey,
                'secret_key' => $secretKey,
                'expired_at' => now()->addDays(30),
            ]);
        }
    }
}
