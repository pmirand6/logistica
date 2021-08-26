<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order\Order;
use Illuminate\Support\Facades\Log;


class RoadmapGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $roadMapCode;

    /**
     * Create a new message instance.
     *
     * @param $roadMapCode
     */
    public function __construct($roadMapCode)
    {
        $this->roadMapCode = $roadMapCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try{
            $orders = Order::where('roadMapCode', '=', $this->roadMapCode)->get();

            return $this->from(env('MAIL_FROM_ADDRESS'))
                        ->subject('Hoja de ruta día '.date('d/m/Y', strtotime($orders[0]->created_at)) )
                        ->view('emails.roadMap.generated',
                            ['roadMapCode' => $this->roadMapCode,
                                'orders' => $orders
                            ]);
        } catch (\Exception $e) {
            Log::error(__class__ . ": no se pudo enviar el mail de {$this->roadMapCode}");
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
