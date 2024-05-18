<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyKontenRequest;
use App\Http\Requests\MassDestroyLessonRequest;
use App\Http\Requests\StoreKontenRequest;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateKontenRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\KontenClass;
use App\Lesson;
use App\SchoolClass;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class KontenController extends Controller
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

        // abort_if(Gate::denies('lesson_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // $teachers = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.kontens.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKontenRequest $request)
    {
        // $kontens = KontenClass::create($request->all());
        $konten = new KontenClass();
        $konten->desc = $request->desc;
        $konten->class_id = $request->class_id;
        $konten->save();
        // return redirect()->route('admin.kontens.index');
        return redirect()->back()->with('success', 'Berhasil Menambahkan Konten');
        // return view('admin.schoolClasses.relationships.classKonten');

    }

    public function show(KontenClass $konten)
    {
        // abort_if(Gate::denies('konten_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $konten->load('class');

        return view('admin.kontens.show', compact('konten'));
    }


    public function edit(KontenClass $konten)
    {
        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // $teachers = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $konten->load('class');

        return view('admin.kontens.edit', compact('classes', 'konten'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKontenRequest $request,KontenClass $konten)
    {

        $konten->update($request->all());
        
        return redirect()->back()->with('success', 'Berhasil Mengubah Konten');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(KontenClass $konten) 
    {
        $konten->delete();
        return back();
    }
    public function massDestroy(MassDestroyKontenRequest $request)
    {
        KontenClass::whereIn('id', request('ids'))->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Konten');
    }

    
}
