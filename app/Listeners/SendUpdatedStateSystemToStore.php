<?php

namespace App\Listeners;

use App\Events\ShippingUpdatedBySystem;
use App\Resources\Shipping\ShippingResource;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SendUpdatedStateSystemToStore
{
    private $request;
    private $client;

    /**
     * Create the event listener.
     *
     * @param Request $request
     * @param Client $client
     */
    public function __construct(Request $request, Client $client)
    {
        $this->request = $request;
        $this->client = $client;
    }

    /**
     * Handle the event.
     *
     * @param ShippingUpdatedBySystem $event
     * @return void
     * @throws GuzzleException
     */
    public function handle(ShippingUpdatedBySystem $event)
    {
        $payload = [
            'shipping_status' => $event->shipping->status,
            'shipping_status_code' => $event->shipping->statusCode,
            'node' => $event->shipping->node()->get()->toArray(),
            'resource' => new ShippingResource($event->shipping)
        ];

        try {
            $response = $this->client->request(
                'PUT',
                env('GATEWAY_TIENDA') . "purchases/" . $event->shipping->shippingCode,
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'authorization' => $this->request->bearerToken()
                    ],
                    'json' => $payload
                ]
            )->getBody()->getContents();

            Log::info('SendUpdatedStateSystemToStore Listener', [
                'host' => $this->request->getSchemeAndHttpHost(),
                'type' => 'system',
                'payload' => $payload,
                'response' => json_decode($response)
            ]);

        } catch (\Exception $e) {
            Log::error('error SendUpdatedStateSystemToStore Listener', [
                'host' => $this->request->getSchemeAndHttpHost(),
                'type' => 'human',
                'payload' => $payload,
                'error' => $e->getMessage(),
                'date' => Carbon::now()
            ]);
        }
    }
}
