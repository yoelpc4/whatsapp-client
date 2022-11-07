<?php

namespace App\Http\Controllers;

use App\Actions\Receiver\GetReceivers;
use App\Actions\Sender\CreateSender;
use App\Actions\Sender\DeleteSender;
use App\Actions\Sender\GetSenders;
use App\Http\Requests\StoreSenderRequest;
use App\Models\Sender;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\ConnectionException;
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

        $senders = $getSenders->execute($request->user(), $request->all());

        return Inertia::render('Senders/Index', compact('senders'))
            ->table(function (InertiaTable $table) {
                $table->column(key: 'index', label: '#')
                    ->column(key: 'name', label: 'Name', sortable: true, searchable: true)
                    ->column(key: 'phone', label: 'Phone', sortable: true, searchable: true)
                    ->column(key: 'created_at', label: 'Created at', sortable: true)
                    ->column(key: 'actions', label: 'Actions')
                    ->defaultSort('-created_at')
                    ->withGlobalSearch()
                    ->searchInput(key: 'name', label: 'Name')
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
     * @throws AuthorizationException
     */
    public function store(StoreSenderRequest $request, CreateSender $createSender): RedirectResponse
    {
        $this->authorize('create', Sender::class);

        try {
            $createSender->execute($request->user(), $request->validated());

            return redirect()
                ->route('senders.index')
                ->with('flash.banner', 'Sender successfully created')
                ->with('flash.bannerStyle', 'success');

        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('senders.index')
                ->with('flash.banner', 'Failed to create sender')
                ->with('flash.bannerStyle', 'danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  Sender  $sender
     * @param  GetReceivers  $getReceivers
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Request $request, Sender $sender, GetReceivers $getReceivers): Response
    {
        $this->authorize('view', $sender);

        $receivers = $getReceivers->execute($sender, $request->all());

//        dump($receivers->items()[0]);

        return Inertia::render('Senders/Show', compact('sender', 'receivers'))
            ->table(function (InertiaTable $table) {
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
     * Remove the specified resource from storage.
     *
     * @param  Sender  $sender
     * @param  DeleteSender  $deleteSender
     * @return RedirectResponse
     * @throws AuthorizationException
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
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('senders.index')
                ->with('flash.banner', 'Failed to delete sender')
                ->with('flash.bannerStyle', 'danger');
        }
    }
}
