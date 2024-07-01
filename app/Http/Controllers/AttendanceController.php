<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Attendance;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Ensure this is imported
use App\Models\QrCode as QrCodeModel;


class AttendanceController extends Controller
{

    public function activateQR(Request $request, $courseId)
    {
        try {
            $course = Course::findOrFail($courseId);
            $expirationTime = Carbon::parse($request->date . ' ' . $request->time)->addMinutes($request->duration);

            $qrCodeModel = QrCodeModel::create([
                'course_id' => $courseId,
                'generated_at' => Carbon::now(),
                'expires_at' => $expirationTime,
            ]);

            $qrData = [
                'qr_code_id' => $qrCodeModel->id,
                'expires_at' => $expirationTime->toDateTimeString()
            ];

            // Generate QR code with URL
            $url = route('attendance.manual', ['course' => $courseId]);
            $qrCode = base64_encode(QrCode::format('png')->size(300)->generate($url));

            // Log the QR data being generated
            Log::info('Generating QR code with data:', $qrData);

            return response()->json([
                'success' => true,
                'qrCode' => $qrCode,
                'expires_at' => $expirationTime->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating QR code: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Error generating QR code: ' . $e->getMessage()
            ]);
        }
    }
    public function showQR($courseId)
    {
        $course = Course::findOrFail($courseId);
        $qrCodes = QrCodeModel::where('course_id', $courseId)->get();

        return view('courses.attendance', compact('course', 'qrCodes'));
    }


    public function manualAttendance($courseId)
    {
        $course = Course::findOrFail($courseId);

        return view('courses.manual-attendance', compact('course'));
    }

    public function storeManualAttendance(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        // Validate the request data
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        // Find the user by email
        $user = User::where('email', $validatedData['email'])->firstOrFail();

        // Check the password
        if (!Hash::check($validatedData['password'], $user->password)) {
            return redirect()->back()->withErrors(['password' => 'The provided password does not match our records.']);
        }

        // Check QR code validity
        $qrCode = QrCode::where('course_id', $courseId)
            ->where('generated_at', '<=', Carbon::now())
            ->where('expires_at', '>=', Carbon::now())
            ->first();

        if (!$qrCode) {
            return redirect()->back()->withErrors(['qr_code' => 'QR code is not valid or has expired.']);
        }

        // Create the attendance record
        Attendance::create([
            'course_id' => $course->id,
            'user_id' => $user->id,
            'attendance_date' => now()->toDateString(),
            'status' => 'present',
            'qr_code_id' => $qrCode->id, // Link attendance to the QR code
        ]);

        return redirect()->route('attendances.index', ['course' => $course->id])->with('success', 'Attendance recorded successfully.');
    }

    public function attendanceDetails($course_id, $qrCode_id)
    {
        $course = Course::findOrFail($course_id);
        $qrCode = QrCodeModel::with('attendances.user')->findOrFail($qrCode_id);

        return view('courses.attendance.attendance_details', compact('course', 'qrCode'));
    }

    public function showManualSignInForm($course_id)
    {
        return view('courses.attendance.manual_sign_in', compact('course_id'));
    }

    public function verifyManualAttendance(Request $request, Course $course)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Check if QR code is active
            $qrCode = QrCodeModel::where('course_id', $course->id)
                                  ->where('expires_at', '>=', now())
                                  ->orderBy('created_at', 'desc')
                                  ->first();

            if (!$qrCode) {
                return redirect()->back()->withErrors(['error' => 'No active QR code found.']);
            }

            Attendance::updateOrCreate([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'qr_code_id' => $qrCode->id,
            ], [
                'attendance_date' => now(),
                'status' => 'Present',
            ]);

            return redirect()->back()->with('success', 'Attendance recorded successfully.');
        }

        return redirect()->back()->withErrors(['error' => 'Invalid credentials.']);
    }

    public function deleteAttendance($attendanceId)
    {
        $attendance = Attendance::findOrFail($attendanceId);
        $attendance->delete();

        return back()->with('success', 'Attendance record deleted successfully.');
    }
    public function verify(Request $request, Course $course)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Check if QR code is active
            $qrCode = QrCodeModel::where('course_id', $course->id)
                                  ->where('expires_at', '>=', now())
                                  ->orderBy('created_at', 'desc')
                                  ->first();

            if (!$qrCode) {
                return redirect()->back()->withErrors(['error' => 'No active QR code found.']);
            }

            Attendance::updateOrCreate([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'qr_code_id' => $qrCode->id,
            ], [
                'attendance_date' => now(),
                'status' => 'Present',
            ]);

            return redirect()->back()->with('success', 'Attendance recorded successfully.');
        }

        return redirect()->back()->withErrors(['error' => 'Invalid credentials.']);
    }

}
