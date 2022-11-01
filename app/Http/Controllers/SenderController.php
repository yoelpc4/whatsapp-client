<?php

namespace App\Http\Controllers;

use App\Actions\Sender\GetSenders;
use App\Http\Requests\StoreSenderRequest;
use App\Http\Requests\UpdateSenderRequest;
use App\Models\Sender;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;

class SenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @param  GetSenders  $getSenders
     * @return Response
     */
    public function index(Request $request, GetSenders $getSenders): Response
    {
        $senders = $getSenders->execute($request->all());

        return Inertia::render('Senders/Index', [
            'senders' => $senders,
        ])->table(function (InertiaTable $table) {
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSenderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSenderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sender  $sender
     * @return \Illuminate\Http\Response
     */
    public function show(Sender $sender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sender  $sender
     * @return \Illuminate\Http\Response
     */
    public function edit(Sender $sender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSenderRequest  $request
     * @param  \App\Models\Sender  $sender
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSenderRequest $request, Sender $sender)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sender  $sender
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sender $sender)
    {
        //
    }
}
