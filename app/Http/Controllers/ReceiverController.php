<?php

namespace App\Http\Controllers;

use App\Actions\Receiver\CreateReceiver;
use App\Actions\Receiver\DeleteReceiver;
use App\Actions\Receiver\GetReceivers;
use App\Actions\Receiver\UpdateReceiver;
use App\Http\Requests\StoreReceiverRequest;
use App\Http\Requests\UpdateReceiverRequest;
use App\Models\Receiver;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Throwable;

class ReceiverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @param  GetReceivers  $getReceivers
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request, GetReceivers $getReceivers): Response
    {
        $this->authorize('viewAny', Receiver::class);

        $receivers = $getReceivers->execute($request->user(), $request->all());

        return Inertia::render('Receivers/Index', [
            'receivers' => $receivers,
        ])->table(function (InertiaTable $table) {
            $table->column(key: 'index', label: '#')
                ->column(key: 'type', label: 'Type', sortable: true, searchable: true)
                ->column(key: 'name', label: 'Name', sortable: true, searchable: true)
                ->column(key: 'whatsapp_id', label: 'Whatsapp ID', sortable: true, searchable: true)
                ->column(key: 'created_at', label: 'Created at', sortable: true)
                ->column(key: 'actions', label: 'Actions')
                ->defaultSort('-created_at')
                ->withGlobalSearch()
                ->searchInput(key: 'type', label: 'Type')
                ->searchInput(key: 'name', label: 'Name')
                ->searchInput(key: 'whatsapp_id', label: 'Whatsapp ID');
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create', Receiver::class);

        return Inertia::render('Receivers/Create', [
            'types' => Receiver::getTypes(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreReceiverRequest  $request
     * @param  CreateReceiver  $createReceiver
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(StoreReceiverRequest $request, CreateReceiver $createReceiver): RedirectResponse
    {
        $this->authorize('create', Receiver::class);

        $createReceiver->execute($request->user(), $request->validated());

        return redirect()
            ->route('receivers.index')
            ->with('flash.banner', 'Receiver successfully created')
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Receiver  $receiver
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Receiver $receiver): Response
    {
        $this->authorize('view', $receiver);

        return Inertia::render('Receivers/Show', compact('receiver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Receiver  $receiver
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Receiver $receiver): Response
    {
        $this->authorize('update', $receiver);

        return Inertia::render('Receivers/Edit', [
            'receiver' => $receiver,
            'types'    => Receiver::getTypes(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateReceiverRequest  $request
     * @param  Receiver  $receiver
     * @param  UpdateReceiver  $updateReceiver
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(
        UpdateReceiverRequest $request,
        Receiver $receiver,
        UpdateReceiver $updateReceiver
    ): RedirectResponse {
        $this->authorize('update', $receiver);

        $updateReceiver->execute($receiver, $request->validated());

        return redirect()
            ->route('receivers.index')
            ->with('flash.banner', 'Receiver successfully updated')
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Receiver  $receiver
     * @param  DeleteReceiver  $deleteReceiver
     * @return RedirectResponse
     * @throws Throwable
     */
    public function destroy(Receiver $receiver, DeleteReceiver $deleteReceiver): RedirectResponse
    {
        $this->authorize('delete', $receiver);

        try {
            $deleteReceiver->execute($receiver);

            return redirect()
                ->route('receivers.index')
                ->with('flash.banner', 'Receiver successfully deleted')
                ->with('flash.bannerStyle', 'success');
        } catch (RequestException $e) {
            report($e);

            return redirect()
                ->route('receivers.index')
                ->with('flash.banner', $e->response->json('message'))
                ->with('flash.bannerStyle', 'danger');
        }
    }
}
