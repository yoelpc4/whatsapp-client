<?php

namespace App\Http\Controllers;

use App\Actions\Sender\CreateSender;
use App\Actions\Sender\DeleteSender;
use App\Actions\Sender\GetSenders;
use App\Actions\Sender\UpdateSender;
use App\Http\Requests\StoreSenderRequest;
use App\Http\Requests\UpdateSenderRequest;
use App\Http\Resources\SenderResource;
use App\Models\Sender;
use App\Services\WhatsappService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

class SenderController extends Controller
{
    private WhatsappService $whatsappService;

    /**
     * Create a new sender controller
     *
     * @param  WhatsappService  $whatsappService
     */
    public function __construct(WhatsappService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @param  GetSenders  $getSenders
     * @return Response
     */
    public function index(Request $request, GetSenders $getSenders): Response
    {
        $senders = $getSenders->execute($request->user(), $request->all());

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
     * Store a newly created resource in storage.
     *
     * @param  StoreSenderRequest  $request
     * @param  CreateSender  $createSender
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(StoreSenderRequest $request, CreateSender $createSender): RedirectResponse
    {
        $createSender->execute($request->user(), $request->validated());

        return back(SymfonyResponse::HTTP_SEE_OTHER)
            ->with('banner', 'Sender successfully created')
            ->with('bannerStyle', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Sender  $sender
     * @return SenderResource
     */
    public function show(Sender $sender): SenderResource
    {
        return new SenderResource($sender);
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
        $updateSender->execute($sender, $request->validated());

        return back(SymfonyResponse::HTTP_SEE_OTHER)
            ->with('banner', 'Sender successfully updated')
            ->with('bannerStyle', 'success');
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
        $deleteSender->execute($sender);

        return back(SymfonyResponse::HTTP_SEE_OTHER)
            ->with('banner', 'Sender successfully deleted')
            ->with('bannerStyle', 'success');
    }

    /**
     * Link sender device
     *
     * @param  Sender  $sender
     * @return JsonResponse
     */
    public function linkDevice(Sender $sender): JsonResponse
    {
        try {
            $response = $this->whatsappService->createSession($sender->phone);

            if (! isset($response['data']['qrCodeDataUrl'])) {
                return response()->json($response['message'], SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json([
                'qr_code_data_url' => $response['data']['qrCodeDataUrl'],
            ]);
        } catch (RequestException $e) {
            return response()->json($e->getMessage(), SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
