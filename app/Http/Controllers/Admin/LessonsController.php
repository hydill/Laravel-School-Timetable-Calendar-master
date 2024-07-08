<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLessonRequest;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Lesson;
use App\SchoolClass;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LessonsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('lesson_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::all();

        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {
        abort_if(Gate::denies('lesson_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teachers = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.lessons.create', compact('classes', 'teachers'));
    }

    public function store(StoreLessonRequest $request)
    {
        $lesson = Lesson::create($request->all());

        // return redirect()->route('admin.lessons.index')->with('success', 'Berhasil Menambahkan Pelajaran');
        return redirect()->back()->with('success', 'Berhasil Menambahkan Pelajaran');
    }

    public function edit(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teachers = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lesson->load('class', 'teacher');

        return view('admin.lessons.edit', compact('classes', 'teachers', 'lesson'));
    }
    public function updated_(Request $request, $id)
    {
        $validated = $request->validate([
            'konten' => 'max:255',
        ]);

        $lessonTime = Lesson::findOrFail($id);
        $lessonTime->konten = $request->input('konten');
        $lessonTime->save();


        return redirect()->back()->with('success', 'Konten berhasil diperbarui');
    }

    public function updated(Request $request, $id)
    {
        $validated = $request->validate([
            'konten' => 'max:255',
            'pdf_file' => 'nullable|mimes:pdf|max:2048', // validasi file PDF
        ]);

        $lessonTime = Lesson::findOrFail($id);
        $lessonTime->konten = $request->input('konten');

        // Mengelola unggahan file PDF
        if ($request->hasFile('pdf_file')) {
            $pdf = $request->file('pdf_file');
            $pdfPath = $pdf->store('public/pdf_files'); // simpan file PDF

            $lessonTime->pdf_path = $pdfPath; // menyimpan path PDF di database
        }

        $lessonTime->save();

        // Mengirimkan pemberitahuan WhatsApp jika ada file PDF
    
        return redirect()->back()->with('success', 'Konten berhasil diperbarui');
    }



    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, ['disk' => 'public']);

            // Menyimpan nama file ke dalam database atau atribut lainnya yang relevan
            $lesson->file_path = $filePath;
        }

        $lesson->update($request->all());

        return redirect()->back()->with('success', 'Pelajaran Diperbarui');
    }

    public function show(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lesson->load('class', 'teacher');

        return view('admin.lessons.show', compact('lesson'));
    }

    public function destroy(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lesson->delete();

        return back()->with('success', 'Berhasil Menghapus Pelajaran');
    }

    public function massDestroy(MassDestroyLessonRequest $request)
    {
        Lesson::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function detail()
    {
    }
}
