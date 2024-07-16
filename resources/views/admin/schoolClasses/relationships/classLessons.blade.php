@can('lesson_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            {{-- <a class="btn btn-success" href="{{ route('admin.lessons.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.lesson.title_singular') }}
            </a> --}}

            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
                Tambah Pelajaran</button>
        </div>
    </div>
@endcan

<div class="card">

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <b>
                            Tambah Pelajaran
                        </b>
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('admin.lessons.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="required" for="class_id">{{ trans('cruds.lesson.fields.class') }}</label>
                            <select class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}"
                                name="class_id" id="class_id" required>
                                @foreach ($classes as $id => $class)
                                    <option value="{{ $id }}" {{ old('class_id') == $id ? 'selected' : '' }}>
                                        {{ $class }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('class'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('class') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="teacher_id">{{ trans('cruds.lesson.fields.teacher') }}</label>
                            <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}"
                                name="teacher_id" id="teacher_id" required>
                                @foreach ($teachers as $id => $teacher)
                                    <option value="{{ $id }}"
                                        {{ old('teacher_id') == $id ? 'selected' : '' }}>
                                        {{ $teacher }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('teacher'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('teacher') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.lesson.fields.teacher_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="weekday">{{ trans('cruds.lesson.fields.weekday') }}</label>
                            {{-- <input class="form-control {{ $errors->has('weekday') ? 'is-invalid' : '' }}"
                                    type="number" name="weekday" id="weekday" value="{{ old('weekday') }}"
                                    step="1" required> --}}
                            <select class="form-control {{ $errors->has('weekday') ? 'is-invalid' : '' }}"
                                name="weekday" id="weekday" required>
                                <option value="">Pilih Hari</option>
                                <option value="1" {{ old('weekday') == 1 ? 'selected' : '' }}>Senin
                                </option>
                                <option value="2" {{ old('weekday') == 2 ? 'selected' : '' }}>Selasa
                                </option>
                                <option value="3" {{ old('weekday') == 3 ? 'selected' : '' }}>Rabu
                                </option>
                                <option value="4" {{ old('weekday') == 4 ? 'selected' : '' }}>Kamis
                                </option>
                                <option value="5" {{ old('weekday') == 5 ? 'selected' : '' }}>Jumat
                                </option>
                                <option value="6" {{ old('weekday') == 6 ? 'selected' : '' }}>Sabtu
                                </option>
                                <option value="7" {{ old('weekday') == 7 ? 'selected' : '' }}>Minggu
                                </option>
                            </select>

                            @if ($errors->has('weekday'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('weekday') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.lesson.fields.weekday_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                for="start_time">{{ trans('cruds.lesson.fields.start_time') }}</label>
                            <input
                                class="form-control lesson-timepicker {{ $errors->has('start_time') ? 'is-invalid' : '' }}"
                                type="text" name="start_time" id="start_time" value="{{ old('start_time') }}"
                                required>
                            @if ($errors->has('start_time'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('start_time') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.lesson.fields.start_time_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="end_time">{{ trans('cruds.lesson.fields.end_time') }}</label>
                            <input
                                class="form-control lesson-timepicker {{ $errors->has('end_time') ? 'is-invalid' : '' }}"
                                type="text" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
                            @if ($errors->has('end_time'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('end_time') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.lesson.fields.end_time_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="mata_pelajaran">Mata Pelajaran</label>
                            <input class="form-control {{ $errors->has('mata_pelajaran') ? 'is-invalid' : '' }}"
                                type="text" name="mata_pelajaran" id="mata_pelajaran"
                                value="{{ old('mata_pelajaran') }}">
                            @if ($errors->has('mata_pelajaran'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('mata_pelajaran') }}
                                </div>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="konten">Konten Pelajaran</label>
                            <input class="form-control {{ $errors->has('konten') ? 'is-invalid' : '' }}" type="text"
                                name="konten" id="konten" value="{{ old('konten') }}" readonly
                                placeholder="Di isi oleh guru di kelas">
                            @if ($errors->has('konten'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('konten') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.konten.fields.desc_helper') }}</span>
                        </div>


                </div>
                <div class="modal-footer">




                    <button class="btn btn-success" type="submit">
                        Simpan
                    </button>
                </div>


                </form>

            </div>



        </div>
    </div>


    <div class="card-header">
        Daftar Pelajaran
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Lesson">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.class') }}
                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.teacher') }}
                        </th>
                        <th>
                            Mata Pelajaran
                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.weekday') }}
                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.start_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.end_time') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lessons as $key => $lesson)
                        <tr data-entry-id="{{ $lesson->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $lesson->class->name ?? '' }}
                            </td>
                            <td>
                                {{ $lesson->teacher->name ?? '' }}
                            </td>
                            <td>
                                {{ $lesson->mata_pelajaran }}
                            </td>
                            <td>
                                {{ $lesson->weekday_name ?? '' }}
                            </td>
                            <td>
                                {{ $lesson->start_time ?? '' }}
                            </td>
                            <td>
                                {{ $lesson->end_time ?? '' }}
                            </td>
                            <td>
                                @can('lesson_show')
                                    <a class="btn btn-xs btn-primary"
                                        href="{{ route('admin.lessons.show', $lesson->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('lesson_edit')
                                    {{-- <a class="btn btn-xs btn-info" href="{{ route('admin.lessons.edit', $lesson->id) }}">
                                        {{ trans('global.edit') }}
                                    </a> --}}
                                    <button type="button" class="btn btn-xs btn-info" data-toggle="modal"
                                        data-target="#editlesson-{{ $lesson->id }}" data-whatever="@mdo"
                                        onclick="logModalInfo({{ $lesson->id }})">
                                        Edit</button>
                                @endcan

                                @can('lesson_delete')
                                    {{-- <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                            value="{{ trans('global.delete') }}">
                                    </form> --}}
                                    <button type="button" class="btn btn-xs btn-danger" data-toggle="modal"
                                        data-target="#confirmDeleteModal-{{ $lesson->id }}">
                                        {{ trans('global.delete') }}
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="confirmDeleteModal-{{ $lesson->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="confirmDeleteModalLabel-{{ $lesson->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    Apa kamu serius menghapus data tersebut?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Kembali</button>
                                                    <form action="{{ route('admin.lessons.destroy', $lesson->id) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-danger">{{ trans('global.delete') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan

                            </td>

                        </tr>



                        <div class="modal fade" id="editlesson-{{ $lesson->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            <b>
                                                Edit Pelajaran
                                            </b>
                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST"
                                            action="{{ route('admin.lessons.update', [$lesson->id]) }}"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="form-group">
                                                <label class="required"
                                                    for="class_id">{{ trans('cruds.lesson.fields.class') }}</label>
                                                <select
                                                    class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}"
                                                    name="class_id" id="class_id" required>
                                                    @foreach ($classes as $id => $class)
                                                        <option value="{{ $id }}"
                                                            {{ ($lesson->class ? $lesson->class->id : old('class_id')) == $id ? 'selected' : '' }}>
                                                            {{ $class }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @if ($errors->has('class'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('class') }}
                                                    </div>
                                                @endif
                                                <span
                                                    class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label class="required"
                                                    for="teacher_id">{{ trans('cruds.lesson.fields.teacher') }}</label>
                                                <select
                                                    class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}"
                                                    name="teacher_id" id="teacher_id" required>
                                                    @foreach ($teachers as $id => $teacher)
                                                        <option value="{{ $id }}"
                                                            {{ ($lesson->teacher ? $lesson->teacher->id : old('teacher_id')) == $id ? 'selected' : '' }}>
                                                            {{ $teacher }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('teacher'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('teacher') }}
                                                    </div>
                                                @endif
                                                <span
                                                    class="help-block">{{ trans('cruds.lesson.fields.teacher_helper') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label class="required"
                                                    for="weekday">{{ trans('cruds.lesson.fields.weekday') }}</label>
                                                <select
                                                    class="form-control {{ $errors->has('weekday') ? 'is-invalid' : '' }}"
                                                    name="weekday" id="weekday" required>
                                                    <option value="">Pilih Hari</option>
                                                    <option value="1"
                                                        {{ old('weekday', $lesson->weekday) == 1 ? 'selected' : '' }}>
                                                        Senin</option>
                                                    <option value="2"
                                                        {{ old('weekday', $lesson->weekday) == 2 ? 'selected' : '' }}>
                                                        Selasa</option>
                                                    <option value="3"
                                                        {{ old('weekday', $lesson->weekday) == 3 ? 'selected' : '' }}>
                                                        Rabu</option>
                                                    <option value="4"
                                                        {{ old('weekday', $lesson->weekday) == 4 ? 'selected' : '' }}>
                                                        Kamis</option>
                                                    <option value="5"
                                                        {{ old('weekday', $lesson->weekday) == 5 ? 'selected' : '' }}>
                                                        Jumat</option>
                                                    <option value="6"
                                                        {{ old('weekday', $lesson->weekday) == 6 ? 'selected' : '' }}>
                                                        Sabtu</option>
                                                    <option value="7"
                                                        {{ old('weekday', $lesson->weekday) == 7 ? 'selected' : '' }}>
                                                        Minggu</option>
                                                </select>
                                                @if ($errors->has('weekday'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('weekday') }}
                                                    </div>
                                                @endif
                                                <span
                                                    class="help-block">{{ trans('cruds.lesson.fields.weekday_helper') }}</span>
                                            </div>

                                            <div class="form-group">
                                                <label class="required"
                                                    for="start_time">{{ trans('cruds.lesson.fields.start_time') }}</label>
                                                <input
                                                    class="form-control lesson-timepicker {{ $errors->has('start_time') ? 'is-invalid' : '' }}"
                                                    type="text" name="start_time" id="start_time"
                                                    value="{{ old('start_time', $lesson->start_time) }}" required>
                                                @if ($errors->has('start_time'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('start_time') }}
                                                    </div>
                                                @endif
                                                <span
                                                    class="help-block">{{ trans('cruds.lesson.fields.start_time_helper') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label class="required"
                                                    for="end_time">{{ trans('cruds.lesson.fields.end_time') }}</label>
                                                <input
                                                    class="form-control lesson-timepicker {{ $errors->has('end_time') ? 'is-invalid' : '' }}"
                                                    type="text" name="end_time" id="end_time"
                                                    value="{{ old('end_time', $lesson->end_time) }}" required>
                                                @if ($errors->has('end_time'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('end_time') }}
                                                    </div>
                                                @endif
                                                <span
                                                    class="help-block">{{ trans('cruds.lesson.fields.end_time_helper') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="mata_pelajaran">Mata Pelajaran</label>
                                                <input
                                                    class="form-control {{ $errors->has('mata_pelajaran') ? 'is-invalid' : '' }}"
                                                    type="text" name="mata_pelajaran" id="mata_pelajaran"
                                                    value="{{ old('mata_pelajaran', $lesson->mata_pelajaran) }}">
                                                @if ($errors->has('mata_pelajaran'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('mata_pelajaran') }}
                                                    </div>
                                                @endif

                                            </div>
                                            <div class="form-group">
                                                <label for="konten">Konten Pelajaran</label>
                                                <input
                                                    class="form-control {{ $errors->has('konten') ? 'is-invalid' : '' }}"
                                                    type="text" name="konten" id="konten"
                                                    value="{{ old('konten', $lesson->konten) }}" readonly>
                                                <div id="warning-message" class="warning-message"><i> Diinput oleh
                                                        guru di kelas</i></div>
                                                @if ($errors->has('konten'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('konten') }}
                                                    </div>
                                                @endif
                                                <span
                                                    class="help-block">{{ trans('cruds.konten.fields.desc_helper') }}</span>


                                            </div>


                                    </div>
                                    <div class="modal-footer">


                                        <button class="btn btn-success" type="submit">
                                            Simpan
                                        </button>
                                        </form>

                                    </div>




                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- modal edit lesson --}}





@section('scripts')
    @parent

    <script>
        function logModalInfo(lessonId) {
            console.log("Modal for lesson ID:", lessonId);
        }
    </script>


    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('lesson_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.lessons.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'asc']
                ],
                pageLength: 100,
            });
            $('.datatable-Lesson:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var kontenInput = document.getElementById('konten');
            var warningMessage = document.getElementById('warning-message');

            kontenInput.addEventListener('focus', function() {
                warningMessage.classList.add('visible');
            });

            kontenInput.addEventListener('blur', function() {
                warningMessage.classList.remove('visible');
            });
        });
    </script>
@endsection
