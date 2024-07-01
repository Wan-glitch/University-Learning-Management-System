<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\QrCode;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;

class QrCodeController extends Controller
{
    public function store(Request $request, $course_id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'duration' => 'required|integer',
        ]);

        // Parse the date and time, then add the duration
        $expiration = Carbon::parse($validated['date'] . ' ' . $validated['time'])->addMinutes($validated['duration']);

        // Create the QrCode instance with a placeholder for the code
        $qrCode = QrCode::create([
            'course_id' => $course_id,
            'expires_at' => $expiration,
            'code' => '' // Placeholder for the QR code SVG
        ]);

        // Generate the URL now that we have the QR code ID
        $url = route('attendance.manual', ['course_id' => $course_id, 'qr_code_id' => $qrCode->id]);

        // Generate QR code (assuming QRCodeGenerator is a valid class)
        $qrCodeSvg = QRCodeGenerator::size(300)->generate($url);

        // Update the QR code with the generated SVG
        $qrCode->code = $qrCodeSvg;
        $qrCode->save();

        // Log the QR code creation
        Log::info('QrCode Created: ' . $qrCode->toJson());

        // Return the response
        return response()->json([
            'success' => true,
            'expires_at' => $expiration->toDateTimeString(),
            'redirect_url' => route('qr-codes.view', ['course_id' => $course_id, 'qr_code_id' => $qrCode->id]),
            'qr_code_svg' => $qrCodeSvg
        ]);
    }

    public function show($course_id, $qr_code_id)
    {
        // Find the QR code by ID
        $qrCode = QrCode::find($qr_code_id);

        // Check if the QR code exists
        if (!$qrCode) {
            abort(404, 'QR code not found.');
        }

        // Return the QR code details
        return response()->json($qrCode);
    }
}
