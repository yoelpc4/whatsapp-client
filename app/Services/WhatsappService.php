<?php

namespace App\Services;

use App\Models\Receiver;
use App\Models\Sender;
use Illuminate\Http\Client\ConnectionException;
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
        $this->http = Http::retry(3, 100)
            ->baseUrl(config('services.whatsapp.url'))
            ->withBasicAuth(config('services.whatsapp.username'), config('services.whatsapp.password'));
    }

    /**
     * Create a new session
     *
     * @param  string  $phone
     * @return Response
     * @throws ConnectionException
     * @throws RequestException
     */
    public function createSession(string $phone): Response
    {
        return $this->http->post('sessions', [
            'id' => $phone,
        ])->throw();
    }

    /**
     * Find existing session
     *
     * @param  Sender  $sender
     * @return Response
     * @throws ConnectionException
     * @throws RequestException
     */
    public function findSession(Sender $sender): Response
    {
        return $this->http->get("sessions/{$sender->phone}")->throw();
    }

    /**
     * Delete existing session
     *
     * @param  Sender  $sender
     * @return Response
     * @throws ConnectionException
     * @throws RequestException
     */
    public function deleteSession(Sender $sender): Response
    {
        return $this->http->delete("sessions/{$sender->phone}")->throw();
    }

    /**
     * Get sender's persons
     *
     * @param  Sender  $sender
     * @return Response
     * @throws ConnectionException
     * @throws RequestException
     */
    public function getPersons(Sender $sender): Response
    {
        return $this->http
            ->withHeaders([
                'session' => $sender->phone,
            ])
            ->get('persons')
            ->throw();
    }

    /**
     * Get sender's groups
     *
     * @param  Sender  $sender
     * @return Response
     * @throws ConnectionException
     * @throws RequestException
     */
    public function getGroups(Sender $sender): Response
    {
        return $this->http
            ->withHeaders([
                'session' => $sender->phone,
            ])
            ->get('groups')
            ->throw();
    }

    /**
     * Send message to person
     *
     * @param  Sender  $sender
     * @param  Receiver  $receiver
     * @param  string  $text
     * @return Response
     * @throws ConnectionException
     * @throws RequestException
     */
    public function sendMessageToPerson(Sender $sender, Receiver $receiver, string $text): Response
    {
        return $this->http
            ->withHeaders([
                'session' => $sender->phone,
            ])
            ->post('persons/send-message', [
                'whatsappId' => $receiver->whatsapp_id,
                'text'       => $text,
            ])
            ->throw();
    }

    /**
     * Send message to group
     *
     * @param  Sender  $sender
     * @param  Receiver  $receiver
     * @param  string  $text
     * @return Response
     * @throws ConnectionException
     * @throws RequestException
     */
    public function sendMessageToGroup(Sender $sender, Receiver $receiver, string $text): Response
    {
        return $this->http
            ->withHeaders([
                'session' => $sender->phone,
            ])
            ->post('groups/send-message', [
                'whatsappId' => $receiver->whatsapp_id,
                'text'       => $text,
            ])
            ->throw();
    }
}
