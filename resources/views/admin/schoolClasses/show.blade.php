@extends('layouts.admin')
@section('content')
    <div class="card">
        

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.school-classes.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>

                        <tr>
                            <th>
                                {{ trans('cruds.schoolClass.fields.name') }}
                            </th>
                            <td>
                                {{ $schoolClass->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Kelola
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#class_lessons" role="tab" data-toggle="tab">
                    {{ trans('cruds.lesson.title') }}
                </a>
            </li>
            {{-- <li class="nav-item">
            <a class="nav-link" href="#class_users" role="tab" data-toggle="tab">
                {{ trans('cruds.user.title') }}
            </a>
        </li> --}}
            <li class="nav-item">
                <a class="nav-link" href="#class_student" role="tab" data-toggle="tab">
                    {{ trans('cruds.siswa.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="#class_details" role="tab" data-toggle="tab" class="nav-link">
                    Kirim Pemberitahuan
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="#class_manage" role="tab" data-toggle="tab" class="nav-link">
                    Kelola Kelas
                </a>
            </li> --}}
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="class_lessons">
                @includeIf('admin.schoolClasses.relationships.classLessons', [
                    'lessons' => $schoolClass->classLessons,
                    'teachers' => $teachers,
                    'classes' => $classes,
                ])
            </div>
            {{-- <div class="tab-pane" role="tabpanel" id="class_users">
            @includeIf('admin.schoolClasses.relationships.classUsers', ['users' => $schoolClass->classUsers])
        </div> --}}
            <div class="tab-pane" role="tabpanel" id="class_student">
                @includeIf('admin.schoolClasses.relationships.classStudent', [
                    'students' => $schoolClass->classSiswa,
                    'classes' => $classes,
                ])
            </div>
            <div class="tab-pane" role="tabpanel" id="class_details">
                @includeIf('admin.schoolClasses.relationships.classDetails', [
                    'lesson_timess' => $lesson_times,
                    'students' => $schoolClass->classSiswa,
                    'message' => $message,
                    'timeOfDay' => $timeOfDay,
                    
                ])
            </div>
            {{-- <div class="tab-pane" role="tabpanel" id="class_manage">
                @includeIf('admin.schoolClasses.relationships.classManageSiswa', [
                    'some' => 'data'])
            </div> --}}
        </div>
    </div>
@endsection
