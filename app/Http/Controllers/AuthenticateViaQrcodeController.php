<?php

namespace App\Http\Controllers;

use App\Events\QrcodeScannerEvent;
use Illuminate\Http\Request;

class AuthenticateViaQrcodeController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->qrcode_value) {
            event(new QrcodeScannerEvent($request->qrcode_value, $request->user()->id));
        }

        return to_route('dashboard');
    }
}
