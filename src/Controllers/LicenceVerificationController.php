<?php


namespace Hashcode\Larainstaller\Controllers;


use Hashcode\Larainstaller\Services\EnvatoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LicenceVerificationController
{
    protected $envatoService;

    public function __construct(EnvatoService $envatoService)
    {
        $this->envatoService = $envatoService;
    }

    public function licenseVerification(Request $request)
    {
        $file = storage_path('app/permissionChecked');
        touch($file);
        return view('larainstaller::license_verification');
    }

    public function licenseVerificationStore(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string',
            'envato_email' => 'required|string',
            'domain' => 'required|string',
        ]);

        try {
            $purchaseCode = $request->input('access_code');
            $domain = $request->input('domain');
            $buyerEmail = $request->input('envato_email');

            $data['purchase_code'] = $purchaseCode;
            $data['domain'] = $domain;
            $data['buyer_email'] = $buyerEmail;

            // Call the EnvatoService to register the license
            $response = $this->envatoService->registerLicense($data);

            // Handle the service response
            if ($response && isset($response['status']) && $response['status'] === 'success') {
                return redirect()->route('install.database_setup')->with('success', 'License verified successfully');
            }
            // Handle error responses from the EnvatoService
            return redirect()->back()->with('error', $response['message'] ?? 'Failed to verified your license. Please try again.');
        } catch (\Exception $e) {
            // Handle unexpected errors
            Log::error('Error registering license: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
