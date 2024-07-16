<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        {{-- <a class="btn btn-success" href="{{ route('admin.student.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.siswa.title') }}
        </a> --}}
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalsiswa"
            data-whatever="@mdo">
            Tambah Siswa</button>
    </div>
</div>

<div class="card">

    <div class="card-header">
        {{ trans('cruds.siswa.title') }}
    </div>

    <div class="modal fade" id="exampleModalsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <b>
                            Tambah Siswa
                        </b>
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- <div class="card-body"> --}}
                    <form method="POST" action="{{ route('admin.student.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="required" for="class_id">Kelas</label>
                            <select class="form-control select2 {{ $errors->has('class_id') ? 'is-invalid' : '' }}"
                                name="class_id" id="class_id" required>
                                @foreach ($classes as $id => $class)
                                    <option value="{{ $id }}" {{ old('class_id') == $id ? 'selected' : '' }}>
                                        {{ $class }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="required" for="named">{{ trans('cruds.siswa.fields.named') }}</label>
                            <input type="text" class="form-control {{ $errors->has('named') ? 'is-invalid' : '' }} "
                                name="named" value="{{ old('named') }}">
                            @if ($errors->has('named'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('named') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="gender" class="required">{{ trans('cruds.siswa.fields.gender') }}</label>
                            <select name="gender" id="gender" class="form-control select col-3"
                                data-placeholder="choose.." required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">

                            <label for="phone_number"
                                class="required">{{ trans('cruds.siswa.fields.phone_number') }}</label>

                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">+62</span>
                                <input type="number" id="phone"
                                    class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}"
                                    name="phone_number" value="{{ old('phone_number') }}">
                            </div>
                            <div id="warning-message" class="warning-message"><i>Harap pastikan nomor whatsapp
                                    aktif!</i></div>
                        </div>
                        @if ($errors->has('phone_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone_number') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="address" class="required">{{ trans('cruds.siswa.fields.address') }}</label>
                            <input type="text" name="address"
                                class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                value="{{ old('address') }}">
                        </div>
                        @if ($errors->has('address'))
                            <div class="invalid-feedback">
                                {{ $errors->first('address') }}
                            </div>
                        @endif

                        {{-- </div> --}}

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


    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-student">
                <thead>
                    <tr>
                        <th></th>
                        <th width="5%">{{ trans('cruds.siswa.fields.id') }}</th>
                        <th>{{ trans('cruds.siswa.fields.nis') }}</th>
                        <th>{{ trans('cruds.siswa.fields.named') }}</th>
                        <th>{{ trans('cruds.siswa.fields.class_id') }}</th>
                        <th>{{ trans('cruds.siswa.fields.gender') }}</th>
                        <th>{{ trans('cruds.siswa.fields.address') }}</th>
                        <th>{{ trans('cruds.siswa.fields.phone_number') }}</th>
                        <th>&nbsp;</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $key => $student)
                        <tr data-entry-id = "{{ $student->id }}">
                            <td></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->nis ?? '' }}</td>
                            <td>{{ $student->named ?? '' }}</td>
                            <td>{{ $student->class->name }}</td>
                            <td>{{ $student->gender ?? '' }}</td>
                            <td>{{ $student->address ?? '' }}</td>
                            <td>{{ $student->phone_number ?? '' }}</td>
                            <td>
                                <a class="btn btn-xs btn-primary"
                                    href="{{ route('admin.student.show', $student->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                                {{-- <a class="btn btn-xs btn-info" href="{{ route('admin.student.edit', $student->id) }}">
                                    {{ trans('global.edit') }}
                                </a> --}}

                                <button type="button" class="btn btn-xs btn-info" data-toggle="modal"
                                    data-target="#editstudent-{{ $student->id }}" data-whatever="@mdo"
                                    onclick="logModalInfo({{ $student->id }})">
                                    Edit</button>

                                {{-- <form action="{{ route('admin.student.destroy', $student->id) }}" method="POST"
                                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                    style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger"
                                        value="{{ trans('global.delete') }}">
                                </form> --}}
                                <!-- Trigger Button -->
                                <button type="button" class="btn btn-xs btn-danger" data-toggle="modal"
                                    data-target="#confirmDeleteModal-{{ $student->id }}">
                                    {{ trans('global.delete') }}
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="confirmDeleteModal-{{ $student->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="confirmDeleteModalLabel-{{ $student->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                Apa kamu serius menghapus data tersebut?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Kembali</button>
                                                <form action="{{ route('admin.student.destroy', $student->id) }}"
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

                            </td>
                        </tr>

                        <div class="modal fade" id="editstudent-{{ $student->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            <b>
                                                Edit Siswa
                                            </b>
                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form method="POST"
                                            action="{{ route('admin.student.update', [$student->id]) }}"
                                            enctype="multipart/form-data">
                                            @method ('PUT')
                                            @csrf
                                            <div class="form-group">
                                                <label class="required"
                                                    for="class_id">{{ trans('cruds.lesson.fields.class') }}</label>
                                                <select
                                                    class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}"
                                                    name="class_id" id="class_id" required>
                                                    @foreach ($classes as $id => $class)
                                                        <option value="{{ $id }}"
                                                            {{ ($student->class ? $student->class->id : old('class_id')) == $id ? 'selected' : '' }}>
                                                            {{ $class }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="required"
                                                    for="named">{{ trans('cruds.siswa.fields.named') }}</label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('named') ? 'is-invalid' : '' }} "
                                                    name="named" value="{{ old('named', $student->named) }}">
                                                @if ($errors->has('named'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('named') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="gender"
                                                    class="required">{{ trans('cruds.siswa.fields.gender') }}</label>
                                                <select name="gender" id="gender"
                                                    class="form-control select col-3" data-placeholder="choose.."
                                                    required>
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>

                                            <div class="form-group">

                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">+62</span>
                                                    <input type="number" id="phone"
                                                        class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}"
                                                        name="phone_number"
                                                        value="{{ old('phone_number', $student->phone_number) }}">
                                                </div>
                                            </div>
                                            @if ($errors->has('phone_number'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('phone_number') }}
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <label for="address"
                                                    class="required">{{ trans('cruds.siswa.fields.address') }}</label>
                                                <input type="text" name="address"
                                                    class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                                    value="{{ old('address', $student->address) }}">
                                            </div>
                                            @if ($errors->has('address'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('address') }}
                                                </div>
                                            @endif

                                            
                                            
                                            
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

@section('scripts')
    @parent
    <script>
        function logModalInfo(studentID) {
            console.log("Modal for student ID:", studentID);
        }
    </script>
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.student.massDestroy') }}",
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

            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'asc']
                ],
                pageLength: 100,
            });
            $('.datatable-student:not(.ajaxTable)').DataTable({
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
            let phoneInput = document.getElementById('phone');
            phoneInput.addEventListener('input', function() {
                if (!phoneInput.value.startsWith('62')) {
                    phoneInput.value = '62' + phoneInput.value;
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var phoneInput = document.getElementById('phone');
            var warningMessage = document.getElementById(' ');

            phoneInput.addEventListener('focus', function() {
                warningMessage.classList.add('visible');
            });

            phoneInput.addEventListener('blur', function() {
                warningMessage.classList.remove('visible');
            });
        });
    </script>
@endsection
