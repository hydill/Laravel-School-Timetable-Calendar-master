<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\SchoolClass;
use App\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\ManageSiswa;
use App\KontenClass;
use Illuminate\Contracts\Validation\Validator;


class ManageClassController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Filter kelas hanya untuk guru yang login
        if ($user->is_teacher) {
            $schoolClasses = SchoolClass::whereHas('classLessons', function ($query) use ($user) {
                $query->where('teacher_id', $user->id);
            })->get();
        } else {
            // Jika bukan guru, ambil semua kelas atau sesuai peran lainnya
            $schoolClasses = SchoolClass::all();
        }
        // $schoolClasses = SchoolClass::all();

        return view('admin.manageClass.index', compact('schoolClasses'));
    }

    public function show($id)
    {
        // $class = SchoolClass::findOrFail($id); before change
        $class = SchoolClass::with(['classSiswa.manageSiswa'])->findOrFail($id);

        // Pastikan siswa ditemukan
        if (!$class) {
            abort(404, 'class not found');
        }
        $student = $class->load('classSiswa', 'classLessons', 'classManage');
        // dd($student);
        $lessons = Lesson::where('class_id', $id)->with('class')->get();
        // $lessons = Lesson::get();
        $check = false;
        $now = Carbon::now()->tz('Asia/Singapore');
        $lesson_times = $lessons->map(function ($lesson) use ($now) {
            $today = $now->dayOfWeekIso;
            $weekday = $lesson->weekday;
            $start_time = Carbon::createFromFormat('H:i', $lesson->start_time)
                ->format(config('panel.lesson_time_format'));
            $end_time = Carbon::createFromFormat('H:i', $lesson->end_time)
                ->format(config('panel.lesson_time_format'));
            if ($check = $now->between($start_time, $end_time) && ($today == $weekday)) {

                $check = true;
            };
            return [
                'check' => $check,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'teacher_id' => $lesson->teacher->name,
                'konten' => $lesson->konten,
                'id'    => $lesson->id,
                'mata_pelajaran'    => $lesson->mata_pelajaran
            ];
        });
        $noLessonFound = !$lesson_times->contains('check', true);
        // $konten = SchoolClass::with('classKontens')->findOrFail($id);


        return view('admin.manageClass.show', compact('class', 'student', 'noLessonFound', 'lesson_times', 'lessons'));
    }

    public function store___(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|integer',
            'about' => 'nullable|string',
            'lesson_id' => 'required|array',
            'lesson_id.*' => 'integer',
        ], [
            'lesson_id.required' => 'Tidak ada pelajaran berlangsung'
        ]);


        $siswa = Siswa::findOrFail($request->input('siswa_id'));
        $class_id = $siswa->class_id;

        $manage_siswa_data = [];
        foreach ($request->input('lesson_id') as $lesson_id) {
            $manage_siswa_data[] = [
                'siswa_id' => $siswa->id,
                'class_id' => $class_id,
                'lesson_id' => $lesson_id,
                'about' => $request->input('about'),
            ];
        }

        ManageSiswa::insert($manage_siswa_data);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }
    public function store(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|integer',
            'about' => 'nullable|string',
            'lesson_id' => 'required|array',
            'lesson_id.*' => 'integer',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'lesson_id.required' => 'Tidak ada pelajaran berlangsung'
        ]);

        $siswa = Siswa::findOrFail($request->input('siswa_id'));
        $class_id = $siswa->class_id;

        $photoPath = null;
        if ($request->hasFile('photo_path')) {
            $photo = $request->file('photo_path');
            $photoPath = $photo->store('public/photo_paths'); // simpan foto
        }

        foreach ($request->input('lesson_id') as $lesson_id) {
            ManageSiswa::create([
                'siswa_id' => $siswa->id,
                'class_id' => $class_id,
                'lesson_id' => $lesson_id,
                'about' => $request->input('about'),
                'photo_path' => $photoPath,
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }


    // public function getDailyReport(Request $request)
    // {
    //     $date = $request->input('date');
    //     $reports = ManageSiswa::whereDate('created_at', $date)
    //                 ->with('siswa') // Assuming siswa() relation returns the name
    //                 ->get(['siswa_id', 'about']);
        
    //     $reports = $reports->map(function ($report) {
    //         return [
    //             'named' => $report->siswa->named, // Assuming 'nama' is the name attribute in Siswa model
    //             'about' => $report->about,
    //         ];
    //     });

    //     return response()->json($reports);
    // }
}
