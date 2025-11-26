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
        $url = url('survey/form?dept=' . $departmentCode);

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

    public function vcardform()
    {
    
        return view('qr.vcard');
    }

    public function generateVCard(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
        ]);

        $fullName = $request->input('full_name');
        $designation = $request->input('designation');
        $email = $request->input('email');
        $telephone = $request->input('telephone');


        // Create vCard content
        $vCard = "BEGIN:VCARD\n";
        $vCard .= "VERSION:3.0\n";
        $vCard .= "FN:" . e($fullName) . "\n";
        $vCard .= "ORG:Bases Conversion and Development Authority\n";
        if ($designation) {
            $vCard .= "TITLE:" . e($designation) . "\n";
        }
        if ($email) {
            $vCard .= "EMAIL;TYPE=INTERNET:" . e($email) . "\n";
        }
        if ($telephone) {
            $vCard .= "TEL;TYPE=WORK,VOICE:" . e($telephone) . "\n";
        }
        $vCard .= "ADR;TYPE=WORK:2F Bonifacio Technology Center 31st St. corner 2nd Ave. Bonifacio Global City 1634 Taguig City, Philippines\n";
        $vCard .= "END:VCARD";

         return view('qr.vcardgenerate', [
            'vCard'   => $vCard,
     
        ]);
    }

    public function show()
    {
        // Just show the form
        return view('qr.show');
    }

    public function generateshow(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $websiteUrl = $request->input('url');
        $qrCode = QrCode::size(400)->generate($websiteUrl);

        return view('qr.show', compact('qrCode'))->with('websiteUrl', e($websiteUrl));
    }

}