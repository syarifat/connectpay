<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $client;
    protected $token;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
        $this->client = new Client([
            'base_uri' => 'https://api.fonnte.com',
            'headers'  => ['Authorization' => $this->token],
            'verify'   => false, // Penting untuk localhost
        ]);
    }

    // Fungsi cek status device
    public function getDeviceStatus()
    {
        try {
            $response = $this->client->post('/device');
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return ['status' => false, 'reason' => $e->getMessage()];
        }
    }

    public function sendMessage($target, $message)
    {
        try {
            $response = $this->client->post('/send', [
                'form_params' => [
                    'target' => $target,
                    'message' => $message,
                    'countryCode' => '62',
                ]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Fonnte Send Error: ' . $e->getMessage());
            return ['status' => false, 'reason' => $e->getMessage()];
        }
    }

    // app/Services/FonnteService.php

    public function getQrCode()
    {
        try {
            $response = $this->client->post('/qr', [
                'form_params' => [
                    'type' => 'qr',
                    'whatsapp' => '628xxx', // GANTI dengan nomor device yang terdaftar di Fonnte
                ]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return ['status' => false, 'reason' => $e->getMessage()];
        }
    }
}