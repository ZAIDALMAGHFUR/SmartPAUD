<?php

namespace App\Http\Controllers\Admin\Master;

use App;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function register(Request $request)
    {
        // Generate unique keys
        $idRegister = Str::uuid()->toString();
        $clientKey = Str::random(32);
        $serverKey = Str::random(32);
        $secretKey = Str::random(32);

        // Store registration data
        $registration = App\Models\Master\RegistrationClient::create([
            'name' => $request->name,
            'id_register' => $idRegister,
            'client_key' => $clientKey,
            'server_key' => $serverKey,
            'secret_key' => $secretKey,
            'expired_at' => now()->addDays(30),
        ]);

        if ($registration) {
            $log = $this->logActivity('Register', $request, json_encode($registration));
            return $this->successCreatedResponse('Registration created successfully', $registration);
        } else {
            return $this->failedResponse('Registration failed to create');
        }
    }

    public function generateSignature($idRegister, $clientKey, $serverKey, $secretKey, $timestamp)
    {
        $data = $idRegister . $clientKey . $serverKey . $secretKey . $timestamp;
        // Replace 'your-secret-key' with the actual key for encoding/decoding
        return hash_hmac('sha256', $data, $secretKey);
    }

    public function verifySignature(Request $request)
    {
        $timestamp = $request->header('timestamp');
        $signature = $request->header('signature');
        $idRegister = $request->header('id_register');
        $clientKey = $request->header('client_key');
        $serverKey = $request->header('server_key');
        $secretKey = $request->header('secret_key');

        $expectedSignature = $this->generateSignature($idRegister, $clientKey, $serverKey, $secretKey, $timestamp);

        if ($signature !== $expectedSignature) {
            return $this->failedResponse('Invalid signature', 403);
        }

        return $this->successResponse('Valid signature');
    }
}
