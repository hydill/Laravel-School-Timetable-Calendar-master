<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\ManageSiswa;
use App\Services\CalendarService;

class ReportController extends Controller
{
    public function dailyReport($date)
    {
        $reports = ManageSiswa::whereDate('created_at', $date)
            ->with('siswa')
            ->get();

        if ($reports->isEmpty()) {
            return response()->json(['message' => 'No reports found for this date'], 404);
        }

        return response()->json($reports);
    }
}
