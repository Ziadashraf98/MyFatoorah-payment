<?php

namespace App\Http\Controllers;

use App\Http\Services\FatoorahServices;
use App\Models\TransAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FatoorahController extends FatoorahServices
{
    // private $fatoorahServices;

    // public function __construct(FatoorahServices $fatoorahServices)
    // {
    //     $this->fatoorahServices = $fatoorahServices;
    // }

    public function payOrder()
    {
        $data = 
        [
            'CustomerName'       => Auth::user()->name,
            'CustomerEmail'      => Auth::user()->email,
            'CustomerMobile'     => Auth::user()->phone,
            'DisplayCurrencyIso' => 'SAR',
            'Language'           => 'en', //or 'ar'
            'NotificationOption' => 'Lnk', //'SMS', 'EML', 'Lnk' or 'ALL'
            'InvoiceValue'       => 100,
            'CallBackUrl'        => route('success'),
            'ErrorUrl'           => route('error'),
        ];

        
        $paymentData =  $this->sednPayment($data);
        
        TransAction::create([
            'user_id'=>Auth::id(),
            'invoice_id'=>$paymentData['Data']['InvoiceId'],
        ]);
        
        return $paymentData;
    }

    public function paymentCallBack(Request $request)
    {
        $data =
        [
            'Key'=>$request->paymentId,
            'KeyType'=>'paymentId',
        ];
        
        $paymentData = $this->getPaymentStatus($data);
        TransAction::where('invoice_id' , $paymentData['Data']['InvoiceId'])->update(['status'=>true]);
        return $paymentData;
    }
}