<?php

namespace App\Http\Controllers;

use App\Actions\Sender\CreateSender;
use App\Actions\Sender\DeleteSender;
use App\Actions\Sender\GetSenders;
use App\Actions\Sender\LinkDevice;
use App\Actions\Sender\UpdateSender;
use App\Http\Requests\StoreSenderRequest;
use App\Http\Requests\UpdateSenderRequest;
use App\Models\Sender;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Throwable;

class SenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @param  GetSenders  $getSenders
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request, GetSenders $getSenders): Response
    {
        $this->authorize('viewAny', Sender::class);

        $senders = $getSenders->execute($request->all());

        return Inertia::render('Senders/Index', [
            'senders' => $senders,
            'can'     => [
                'create_sender' => $request->user()->can('create', Sender::class),
            ],
        ])->table(function (InertiaTable $table) {
            $table->column(key: 'index', label: '#')
                ->column(key: 'user.name', label: 'User', sortable: true, searchable: true)
                ->column(key: 'phone', label: 'Phone', sortable: true, searchable: true)
                ->column(key: 'created_at', label: 'Created at', sortable: true)
                ->column(key: 'actions', label: 'Actions')
                ->defaultSort('-created_at')
                ->withGlobalSearch()
                ->searchInput(key: 'user.name', label: 'User')
                ->searchInput(key: 'phone', label: 'Phone');
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
        $this->authorize('create', Sender::class);

        return Inertia::render('Senders/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreSenderRequest  $request
     * @param  CreateSender  $createSender
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(StoreSenderRequest $request, CreateSender $createSender): RedirectResponse
    {
        $this->authorize('create', Sender::class);

        $createSender->execute($request->user(), $request->validated());

        return redirect()
            ->route('senders.index')
            ->with('flash.banner', 'Sender successfully created')
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Sender  $sender
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Sender $sender): Response
    {
        $this->authorize('view', $sender);

        $sender->load('user:id,name');

        return Inertia::render('Senders/Show', compact('sender'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Sender  $sender
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Sender $sender): Response
    {
        $this->authorize('update', $sender);

        $sender->load('user:id,name');

        return Inertia::render('Senders/Edit', compact('sender'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSenderRequest  $request
     * @param  Sender  $sender
     * @param  UpdateSender  $updateSender
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(UpdateSenderRequest $request, Sender $sender, UpdateSender $updateSender): RedirectResponse
    {
        $this->authorize('update', $sender);

        $updateSender->execute($sender, $request->validated());

        return redirect()
            ->route('senders.index')
            ->with('flash.banner', 'Sender successfully updated')
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Sender  $sender
     * @param  DeleteSender  $deleteSender
     * @return RedirectResponse
     * @throws Throwable
     */
    public function destroy(Sender $sender, DeleteSender $deleteSender): RedirectResponse
    {
        $this->authorize('delete', $sender);

        try {
            $deleteSender->execute($sender);

            return redirect()
                ->route('senders.index')
                ->with('flash.banner', 'Sender successfully deleted')
                ->with('flash.bannerStyle', 'success');
        } catch (RequestException $e) {
            report($e);

            return redirect()
                ->route('senders.index')
                ->with('flash.banner', $e->response->json('message'))
                ->with('flash.bannerStyle', 'danger');
        }
    }

    /**
     * Link sender device
     *
     * @param  Sender  $sender
     * @param  LinkDevice  $linkDevice
     * @return Response|RedirectResponse
     * @throws AuthorizationException
     */
    public function linkDevice(Sender $sender, LinkDevice $linkDevice): Response|RedirectResponse
    {
        $this->authorize('update', $sender);

        try {
            $qrCodeDataUrl = $linkDevice->execute($sender);

            $sender->load('user:id,name');

            return Inertia::render('Senders/LinkDevice', compact('sender', 'qrCodeDataUrl'));
        } catch (RequestException $e) {
            report($e);

            return redirect()
                ->route('senders.index')
                ->with('flash.banner', $e->response->json('message'))
                ->with('flash.bannerStyle', 'danger');
        }
    }
}
