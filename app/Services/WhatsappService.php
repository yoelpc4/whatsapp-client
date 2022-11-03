<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class WhatsappService
{
    private PendingRequest $http;

    /**
     * Create a new whatsapp service instance
     *
     */
    public function __construct()
    {
        $this->http = Http::retry(3, 100)->baseUrl(config('services.whatsapp.url'));
    }

    /**
     * Create a new session
     *
     * @param  string  $phone
     * @return Response
     * @throws RequestException
     */
    public function createSession(string $phone): Response
    {
        return $this->http->post('sessions', [
            'id' => $phone,
        ])->throw();
    }

    /**
     * Delete existing session
     *
     * @param  string  $phone
     * @return Response
     * @throws RequestException
     */
    public function deleteSession(string $phone): Response
    {
        return $this->http->delete("sessions/{$phone}")->throw();
    }
}
