<?php

namespace App\Http\Controllers;

use App\Actions\LogMessage\GetLogMessages;
use App\Actions\Receiver\CreateReceiver;
use App\Actions\Receiver\DeleteReceiver;
use App\Actions\Receiver\UpdateReceiver;
use App\Http\Requests\StoreReceiverRequest;
use App\Http\Requests\UpdateReceiverRequest;
use App\Models\LogMessage;
use App\Models\Receiver;
use App\Models\Sender;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Throwable;

class ReceiverController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  Sender  $sender
     * @return Response
     * @throws AuthorizationException
     */
    public function create(Sender $sender): Response
    {
        $this->authorize('create', [Receiver::class, $sender]);

        return Inertia::render('Senders/Receivers/Create', [
            'sender' => $sender,
            'types'  => Receiver::getTypes(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreReceiverRequest  $request
     * @param  Sender  $sender
     * @param  CreateReceiver  $createReceiver
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(
        StoreReceiverRequest $request,
        Sender $sender,
        CreateReceiver $createReceiver
    ): RedirectResponse {
        $this->authorize('create', [Receiver::class, $sender]);

        try {
            $createReceiver->execute($sender, $request->validated());

            return redirect()
                ->route('senders.show', $sender)
                ->with('flash.banner', 'Receiver successfully created')
                ->with('flash.bannerStyle', 'success');

        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('senders.show', $sender)
                ->with('flash.banner', 'Failed to create receiver')
                ->with('flash.bannerStyle', 'danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  Sender  $sender
     * @param  Receiver  $receiver
     * @param  GetLogMessages  $getLogMessages
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Request $request, Sender $sender, Receiver $receiver, GetLogMessages $getLogMessages): Response
    {
        $this->authorize('view', [$receiver, $sender]);

        $logMessages = $getLogMessages->execute($sender, $receiver, $request->all());

        return Inertia::render('Senders/Receivers/Show', compact('sender', 'receiver', 'logMessages'))
            ->table(function (InertiaTable $table) {
                $table->column(key: 'index', label: '#', canBeHidden: false)
                    ->column(key: 'message', label: 'Message', sortable: true, searchable: true)
                    ->column(key: 'status', label: 'Status', sortable: true)
                    ->column(key: 'created_at', label: 'Created at', sortable: true)
                    ->column(key: 'sent_at', label: 'Sent at', sortable: true)
                    ->column(key: 'failed_at', label: 'Failed at', sortable: true)
                    ->defaultSort('-created_at')
                    ->withGlobalSearch()
                    ->selectFilter('status', array_reduce(LogMessage::getStatuses(), function(array $filters, string $status) {
                        $filters[$status] = Str::title($status);

                        return $filters;
                    }, []), 'Status')
                    ->searchInput(key: 'message', label: 'Message');
            });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Sender  $sender
     * @param  Receiver  $receiver
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Sender $sender, Receiver $receiver): Response
    {
        $this->authorize('update', [$receiver, $sender]);

        return Inertia::render('Senders/Receivers/Edit', [
            'sender' => $sender,
            'receiver' => $receiver,
            'types' => Receiver::getTypes(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateReceiverRequest  $request
     * @param  Sender  $sender
     * @param  Receiver  $receiver
     * @param  UpdateReceiver  $updateReceiver
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(
        UpdateReceiverRequest $request,
        Sender $sender,
        Receiver $receiver,
        UpdateReceiver $updateReceiver
    ): RedirectResponse {
        $this->authorize('update', [$receiver, $sender]);

        try {
            $updateReceiver->execute($receiver, $request->validated());

            return redirect()
                ->route('senders.show', $sender)
                ->with('flash.banner', 'Receiver successfully updated')
                ->with('flash.bannerStyle', 'success');
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('senders.show', $sender)
                ->with('flash.banner', 'Failed to update receiver')
                ->with('flash.bannerStyle', 'danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Sender  $sender
     * @param  Receiver  $receiver
     * @param  DeleteReceiver  $deleteReceiver
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Sender $sender, Receiver $receiver, DeleteReceiver $deleteReceiver): RedirectResponse
    {
        $this->authorize('delete', [$receiver, $sender]);

        try {
            $deleteReceiver->execute($receiver);

            return redirect()
                ->route('senders.show', $sender)
                ->with('flash.banner', 'Receiver successfully deleted')
                ->with('flash.bannerStyle', 'success');
        } catch (RequestException $e) {
            report($e);

            return redirect()
                ->route('senders.show', $sender)
                ->with('flash.banner', $e->response->json('message'))
                ->with('flash.bannerStyle', 'danger');
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('senders.show', $sender)
                ->with('flash.banner', 'Failed to delete receiver')
                ->with('flash.bannerStyle', 'danger');
        }
    }
}
