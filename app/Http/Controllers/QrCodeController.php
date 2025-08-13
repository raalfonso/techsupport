<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generate(Request $request)
    {
        $departmentCode = $request->get('code', 'DEFAULT123');

        $url = url('/survey?dept=' . $departmentCode);

        return view('qr.generate', compact('url'));
    }
}
