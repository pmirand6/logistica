<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order\Order;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class ShippingLabels extends Mailable
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
        try {
            $orders = Order::where('roadMapCode', '=', $this->roadMapCode)->get();

            $pdf = App::make('dompdf.wrapper');

            $pdfContent = $pdf->loadView('emails.label.label', [
                'roadMapCode' => $this->roadMapCode,
                'orders' => $orders
            ])->setPaper('A4', 'portrait');


            return $this->from(env('MAIL_FROM_ADDRESS'))
                ->subject('Etiquetas de la hoja de ruta ' . $this->roadMapCode)
                ->view('emails.label.labelBodyMail',
                    ['roadMapCode' => $this->roadMapCode,
                        'orders' => $orders
                    ])
                ->attachData($pdfContent->output(), $this->roadMapCode . '.pdf');
        } catch (\Exception $e) {
            Log::error(__class__ . ": no se pudo enviar el mail de {$this->roadMapCode}");
            return response()->json([
                'error' => true,
                'message' => 'Error ' . __class__ . ' ' . $e->getMessage()
            ]);
        }
    }
}
