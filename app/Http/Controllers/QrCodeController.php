<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generate($departmentCode)
    {
        $url = url('/survey-form?dept=' . $departmentCode);

        $department = Department::where('id', $departmentCode)->first();
        // Generate the QR code
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }       
        return view('qr.generate', [
            'url'   => $url,
            'title' => $department->title
        ]);
    }
}
