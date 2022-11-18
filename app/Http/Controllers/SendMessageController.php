<?php

namespace App\Http\Controllers;

use App\Actions\Receiver\SendMessage;
use App\Http\Requests\SendMessageRequest;
use App\Models\Receiver;
use App\Models\Sender;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

class SendMessageController extends Controller
{
    /**
     * Show the form for send message
     *
     * @param  Sender  $sender
     * @param  Receiver  $receiver
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Sender $sender, Receiver $receiver): Response
    {
        $this->authorize('view', [$receiver, $sender]);

        return Inertia::render('Senders/Receivers/SendMessage', [
            'sender'   => $sender,
            'receiver' => $receiver,
        ]);
    }

    /**
     * Send message to the receiver
     *
     * @param  SendMessageRequest  $request
     * @param  Sender  $sender
     * @param  Receiver  $receiver
     * @param  SendMessage  $sendMessage
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(
        SendMessageRequest $request,
        Sender $sender,
        Receiver $receiver,
        SendMessage $sendMessage
    ): RedirectResponse {
        $this->authorize('view', [$receiver, $sender]);

        try {
            $sendMessage->execute($sender, $receiver, $request->validated());

            return redirect()
                ->route('senders.show', $sender)
                ->with('flash.banner', 'Message successfully sent')
                ->with('flash.bannerStyle', 'success');
        } catch (ConnectionException $e) {
            report($e);

            return redirect()
                ->route('senders.show', $sender)
                ->with('flash.banner', 'Unable to connect to the whatsapp service')
                ->with('flash.bannerStyle', 'danger');
        } catch (RequestException $e) {
            report($e);

            if ($e->getCode() === SymfonyResponse::HTTP_UNAUTHORIZED) {
                return redirect()
                    ->route('senders.show', $sender)
                    ->with('flash.banner', "Please link the sender's device to continue")
                    ->with('flash.bannerStyle', 'danger');
            }

            $message = $e->response->json('message');

            if (is_array($message)) {
                $message = $message[0];
            }

            return redirect()
                ->route('senders.show', $sender)
                ->with('flash.banner', $message)
                ->with('flash.bannerStyle', 'danger');
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('senders.show', $sender)
                ->with('flash.banner', 'Failed to log message')
                ->with('flash.bannerStyle', 'danger');
        }
    }
}
