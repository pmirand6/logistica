<?php

namespace App\Listeners;

use App\Events\ShippingUpdated;
use App\Resources\Shipping\ShippingResource;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SendUpdatedStateToStore
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
     * @param ShippingUpdated $event
     * @return void
     * @throws GuzzleException
     */
    public function handle(ShippingUpdated $event)
    {
        $payload = [
            'shipping_status' => $event->shipping->status,
            'shipping_status_code' => $event->shipping->statusCode,
            'node' => $event->shipping->node()->get()->toArray(),
            'resource' => new ShippingResource($event->shipping)
        ];

        try {
            if (($event->shipping->statusCode != 'PRODUCT_ORDER_CONFIRMED') && ($event->shipping->statusCode != 'PENDING_PAYMENT') && ($event->shipping->statusCode != 'REJECTED_PAYMENT')) {
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

                Log::info('SendUpdatedStateToStore Listener', [
                    'host' => $this->request->getSchemeAndHttpHost(),
                    'type' => 'human',
                    'payload' => $payload,
                    'response' => json_decode($response),
                ]);
            }

            Log::alert("The {$event->shipping->shippingCode} with status: {$event->shipping->statusCode} must not inform to Tienda");


        } catch (\Exception $e) {
            Log::error('error SendUpdatedStateToStore Listener', [
                'host' => $this->request->getSchemeAndHttpHost(),
                'type' => 'human',
                'payload' => $payload,
                'error' => $e->getMessage(),
                'date' => Carbon::now()
            ]);
        }
    }
}
