<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

public function pay($id, PaymentService $paymentService)
{
    $booking = Booking::findOrFail($id);

    $result = $paymentService->process($booking);

    $payment = Payment::create([
        'booking_id'=>$booking->id,
        'amount'=>$booking->ticket->price * $booking->quantity,
        'status'=>$result['status']
    ]);

    if($result['status']=='success'){
        $booking->update(['status'=>'confirmed']);
    }

    return response()->json($payment);
}

public function show($id)
{
    $payment = Payment::with('booking')->findOrFail($id);

    return response()->json($payment);
}

}