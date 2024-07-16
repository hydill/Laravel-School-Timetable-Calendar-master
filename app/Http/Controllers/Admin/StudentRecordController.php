<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStudentRequest;
use App\Http\Requests\StoreStudentReq;
use App\Http\Requests\UpdateStudentRequest;
use App\SchoolClass;
use App\Siswa;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;

class StudentRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.students.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentReq $request)
    {


        $st = new Siswa();
        $student = Siswa::latest()->first();
        $kt = date("Y");
        if ($student == null) {
            $urut = "0001";
        } else {
            $urut = substr($student->nis, 4, 4) + 1;
            $urut = str_pad($urut, 4, "0", STR_PAD_LEFT);
        }
        $nis = $kt . $urut;
        // $ct = students::find('id')->get();
        // $data = strtoupper($ct.(mt_rand(1000, 99999)));
        $st->named = $request->named;
        $st->nis = $request['nis'] = $nis;
        $st->gender = $request->gender;
        $st->address = $request->address;
        $st->phone_number = $request->phone_number;
        $st->class_id = $request->class_id;
        // $this->whatsappNotif($st->phone_number);
        $st->save();



        // students::create($request->all());
        // return dd($st);
        return redirect()->back()->with('success', 'Berhasil Menambahkan Siswa');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $student)
    {
        $student->load('class');

        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $student)
    {
        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $student->load('class');
        return view('admin.students.edit', compact('classes', 'student'));
        // dd($students);
    }
    // $teachers = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, Siswa $student)
    {
        $student->update($request->all());
        // return dd($students);
        return redirect()->back()->with('success', 'Berhasil Mengubah Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Siswa $student)
    {
        $student->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus Data');
    }

    public function massDestroy(MassDestroyStudentRequest $request)
    {
        Siswa::whereIn('id', $request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
