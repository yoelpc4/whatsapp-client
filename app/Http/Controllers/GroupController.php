<?php

namespace App\Http\Controllers;

use App\Actions\Receiver\GetGroups;
use App\Models\Sender;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class GroupController extends Controller
{
    /**
     * Get sender's groups
     *
     * @param  Sender  $sender
     * @param  GetGroups  $getGroups
     * @return JsonResponse
     */
    public function index(Sender $sender, GetGroups $getGroups): JsonResponse
    {
        try {
            $groups = $getGroups->execute($sender);

            return response()->json($groups);
        } catch (ConnectionException $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to connect to the whatsapp service',
            ], SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (RequestException $e) {
            report($e);

            return response()->json([
                'message' => $e->response->json('message'),
            ], $e->response->status());
        }
    }
}
