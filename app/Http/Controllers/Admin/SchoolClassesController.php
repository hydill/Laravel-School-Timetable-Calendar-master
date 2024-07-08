<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySchoolClassRequest;
use App\Http\Requests\StoreSchoolClassRequest;
use App\Http\Requests\UpdateSchoolClassRequest;
use App\Lesson;
use App\ManageSiswa;
use App\Message;
use App\SchoolClass;
use App\Siswa;
use App\User;
use Carbon\Carbon;
use Gate;
use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;

class SchoolClassesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('school_class_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolClasses = SchoolClass::all();

        return view('admin.schoolClasses.index', compact('schoolClasses'));
    }

    public function create()
    {
        abort_if(Gate::denies('school_class_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.schoolClasses.create');
    }

    public function store(StoreSchoolClassRequest $request)
    {
        $schoolClass = SchoolClass::create($request->all());

        return redirect()->route('admin.school-classes.index')->with('success', 'Berhasil Menambahkan Kelas');
    }

    public function edit(SchoolClass $schoolClass)
    {
        abort_if(Gate::denies('school_class_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.schoolClasses.edit', compact('schoolClass'));
    }

    public function update(UpdateSchoolClassRequest $request, SchoolClass $schoolClass)
    {
        $schoolClass->update($request->all());

        return redirect()->route('admin.school-classes.index')->with('success', 'Kelas Diperbarui');
    }

    public function show(SchoolClass $schoolClass, Lesson $lessonedit)
    {
        abort_if(Gate::denies('school_class_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teachers = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');


        $schoolClass->load('classLessons', 'classSiswa', 'classKontens');
        // tab detail kelas
        Carbon::setLocale('id');
        $lessons = Lesson::where('class_id', $schoolClass->id)->with('class')->get();
        // $lessons = Lesson::get();
        $check = false;
        $now = Carbon::now()->tz('Asia/Singapore');

        $today = $now->translatedFormat('l, d F Y');
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
                'class_id' => $lesson->class->id,
                'manage_siswa' => ManageSiswa::where('lesson_id', $lesson->id)->get(),

            ];
        });
        $noLessonFound = !$lesson_times->contains('check', true);

        $message = Message::with('siswa.manageSiswa')->get();

        $timeOfDay = '';

        // Menentukan keterangan waktu berdasarkan jam
        if ($now->hour >= 5 && $now->hour < 10) {
            $timeOfDay = 'Pagi';
        } elseif ($now->hour >= 10 && $now->hour < 17) {
            $timeOfDay = 'Siang';
        } else {
            $timeOfDay = 'Malam';
        }


        // $messageStudent = Message::where('lesson_id', $lesson_times->id)->with('siswa')->get();

        // tab detail kelas
        return view('admin.schoolClasses.show', compact('schoolClass', 'lesson_times', 'noLessonFound', 'today', 'message', 'classes', 'teachers', 'timeOfDay'));
    }
    public function destroy(SchoolClass $schoolClass)
    {
        abort_if(Gate::denies('school_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolClass->delete();

        return back()->with('success', 'Kelas Berhasil Dihapus');
    }

    public function massDestroy(MassDestroySchoolClassRequest $request)
    {
        SchoolClass::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function showing(SchoolClass $schoolClass)
    {
        abort_if(Gate::denies('school_class_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolClass->load('classLessons', 'classSiswa', 'classKontens');
        $classLesson = Lesson::all();

        return view('admin.schoolClasses.show', compact('schoolClass', 'classLesson'));
    }


    private function sendFonnteMessage___($phoneNumbers, $messageContent)
    {
        $curl = curl_init();
        $token = "TUpmVb#GdgaVZ_xkLh4H";

        $target = implode(',', $phoneNumbers); // Gabungkan nomor telepon menjadi satu string

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $messageContent,
                'delay' => '1',
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token" // Ganti TOKEN dengan token yang sebenarnya
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }




    public function sendNotification___($id, Request $request)
    {
        $messageTemplate = $request->input('message_content');

        $messages = Message::with('siswa.manageSiswa')->get();

        $phoneNumbersAndContents = [];
        $hasAbout = false;
        // $noAboutPhoneNumbers = [];
        foreach ($messages as $message) {
            foreach ($message->siswa as $siswa) {
                $aboutTexts = [];
                foreach ($siswa->manageSiswa as $manageSiswa) {
                    if ($manageSiswa->lesson_id == $message->lesson_id) {
                        if ($manageSiswa->about) { // Memeriksa apakah ada 'about'
                            $aboutTexts[] = $manageSiswa->about;
                            $hasAbout = true;
                        }
                    }
                }
                if ($hasAbout) {
                    $aboutTextsString = implode("\n+  ", $aboutTexts);

                    $individualMessage = $messageTemplate . "\n\n" . "*Catatan untuk saudara/i* " .
                        $siswa->named . ":\n\n+ " . $aboutTextsString .
                        "\n\n\nSekian,\nTerima kasih atas perhatinnya🙏\nHormat kami, *SD Telkom Makassar*.";

                    $phoneNumbersAndContents[] = [
                        'phone_number' => $siswa->phone_number,
                        'message' => $individualMessage
                    ];
                }
            }
        }
        foreach ($phoneNumbersAndContents as $data) {
            $phoneNumbers = [$data['phone_number']];
            $messageContent = $data['message'];

            $response = $this->sendFonnteMessage($phoneNumbers, $messageContent);

            if (!$response) {
                return redirect()->back()->with('error', 'Pesan Gagal Terkirim kepada ' . $data['phone_number']);
            }
        }
        return redirect()->back()->with('success', 'Pesan Terkirim');
    }

    public function sendNotification($id, Request $request)
    {
        $messageTemplate = $request->input('message_content');

        $messages = Message::with('siswa.manageSiswa')->get();

        $phoneNumbersAndContents = [];
        $hasAbout = false;
        foreach ($messages as $message) {
            foreach ($message->siswa as $siswa) {
                $aboutTexts = [];
                foreach ($siswa->manageSiswa as $manageSiswa) {
                    if ($manageSiswa->lesson_id == $message->lesson_id) {
                        if ($manageSiswa->about) { // Memeriksa apakah ada 'about'
                            $aboutTexts[] = $manageSiswa->about;
                            $hasAbout = true;
                        }
                    }
                }
                if ($hasAbout) {
                    $aboutTextsString = implode("\n+  ", $aboutTexts);

                    $individualMessage = $messageTemplate . "\n\n" . "*Catatan untuk saudara/i* " .
                        $siswa->named . ":\n\n+ " . $aboutTextsString .
                        "\n\n\nSekian,\nTerima kasih atas perhatinnya🙏\nHormat kami, *SD Telkom Makassar*.";

                    $phoneNumbersAndContents[] = [
                        'phone_number' => $siswa->phone_number,
                        'message' => $individualMessage
                    ];
                }
            }
        }

        foreach ($phoneNumbersAndContents as $data) {
            $phoneNumbers = [$data['phone_number']];
            $messageContent = $data['message'];

            // Menambahkan pengiriman file PDF
            $lesson = Lesson::find($id);
            $fileUrl = url('storage/' . $lesson->file_path);

            $response = $this->sendFonnteMessage($phoneNumbers, $messageContent, $fileUrl);

            if (!$response) {
                return redirect()->back()->with('error', 'Pesan Gagal Terkirim kepada ' . $data['phone_number']);
            }
        }

        return redirect()->back()->with('success', 'Pesan Terkirim');
    }

    private function sendFonnteMessage($phoneNumbers, $messageContent, $fileUrl = null)
    {
        $curl = curl_init();
        $token = "TUpmVb#GdgaVZ_xkLh4H";

        $target = implode(',', $phoneNumbers);

        $postData = [
            'target' => $target,
            'message' => $messageContent,
            'delay' => '1',
            'countryCode' => '62', // optional
        ];

        if ($fileUrl) {
            $postData['file'] = $fileUrl;
            $postData['filename'] = basename($fileUrl); // optional, nama file yang akan tampil di WhatsApp
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }



    public function makeMessage(Request $request, $id)
    {
        // Ambil semua siswa_id dari request
        $siswaIds = $request->input('siswa', []);

        // Periksa apakah ada siswa_id yang sudah ada di pivot table message_siswa
        $existingSiswa = DB::table('message_siswa')
            ->whereIn('siswa_id', $siswaIds)
            ->exists();

        // Jika ada siswa_id yang sudah ada, kembalikan pesan error
        if ($existingSiswa) {
            return redirect()->back()->withErrors(['error' => 'Siswa telah terinput']);
        }

        // Jika tidak ada, buat message baru dan sync siswa
        $message = Message::create($request->all());
        $message->siswa()->sync($siswaIds);

        return redirect()->back();
    }
}
