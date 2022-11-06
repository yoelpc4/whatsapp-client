<?php

namespace App\Http\Controllers;

use App\Actions\Sender\LinkDevice;
use App\Models\Sender;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class LinkDeviceController extends Controller
{
    /**
     * Link sender device
     *
     * @param  Sender  $sender
     * @param  LinkDevice  $linkDevice
     * @return Response|RedirectResponse
     * @throws AuthorizationException
     */
    public function __invoke(Sender $sender, LinkDevice $linkDevice): Response|RedirectResponse
    {
        $this->authorize('update', $sender);

        try {
            $qrCodeDataUrl = $linkDevice->execute($sender);

            $sender->load('user:id,name');

            return Inertia::render('Senders/LinkDevice', compact('sender', 'qrCodeDataUrl'));
        } catch (ConnectionException $e) {
            report($e);

            return redirect()
                ->route('senders.index')
                ->with('flash.banner', 'Unable to connect to the whatsapp service')
                ->with('flash.bannerStyle', 'danger');
        } catch (RequestException $e) {
            report($e);

            return redirect()
                ->route('senders.index')
                ->with('flash.banner', $e->response->json('message'))
                ->with('flash.bannerStyle', 'danger');
        }
    }
}
