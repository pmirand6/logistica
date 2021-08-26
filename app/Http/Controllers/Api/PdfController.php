<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Support\Facades\App;

class PdfController extends Controller
{
    public function index()
    {
        //$orders = Order::where('roadMapCode', '=', $this->roadMapCode)->get();

        $pdf = App::make('dompdf.wrapper');

        $pdfContent = $pdf->loadView('emails.label.test2', [
            //'roadMapCode' => $this->roadMapCode,
            //'orders' => $orders
        ])->setPaper('A4', 'portrait');

        return $pdf->stream();
    }

}
