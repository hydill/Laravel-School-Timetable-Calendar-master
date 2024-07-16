@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.siswa.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" value="back" onclick="history.go(-1);">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="30%">
                            {{ trans('cruds.siswa.fields.nis') }}
                        </th>
                        <td>
                            {{ $student->nis }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siswa.fields.named') }}
                        </th>
                        <td>
                           {{ $student->named }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siswa.fields.class_id') }}
                        </th>
                        <td>
                            {{ $student->class->name ?? '' }}

                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siswa.fields.gender') }}
                        </th>
                        <td>
                            {{ $student->gender }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siswa.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $student->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siswa.fields.address') }}
                        </th>
                        <td>
                            {{ $student->address }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection