<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Support\Facades\App;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LabelController extends Controller
{
    public function index()
    {
//        $pdf = App::make('dompdf.wrapper');
//
//        $orders = Order::where('roadMapCode', '=', 'HR-jop8y5a8')->get();
//
//        $pdfContent = $pdf->loadView('emails.label.label', [
//            'roadMapCode' => 'HR-jop8y5a8',
//            'orders' => $orders
//        ])->setPaper('A4', 'landscape');
//
//        return $pdf->stream();
    }

}
