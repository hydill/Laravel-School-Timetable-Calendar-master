@extends('layouts.admin')
@section('content')
    {{-- @if (\Session::has('success'))
        <div class="alert alert-success">
            {!! \Session::get('success') !!}</li>
        </div>
    @endif --}}

    <div class="card">
        <div class="card-header">
            Sesi Pelajaran {{ $class->name ?? '' }} Saat ini
        </div>
        <div class="card-body">
            @foreach ($lesson_times as $lesson_time)
                @if ($lesson_time['check'])
                    <div class="container mb-3 p-0">


                        <span
                            class="tracking-wider text-white bg-green-500 px-4 py-1 text-sm rounded leading-loose mx-2 font-semibold"
                            title="">
                            <i class="fa fa-info-circle" aria-hidden="true"></i> Pelajaran Sedang Berlangsung
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable">
                            <tbody>
                                <tr>
                                    <td><b>Sesi</b></td>
                                    <td>
                                        <h4 class="badge badge-success">{{ $lesson_time['start_time'] }} -
                                            {{ $lesson_time['end_time'] }}</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Guru</b></td>
                                    <td>{{ $lesson_time['teacher_id'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Mata Pelajaran</b></td>
                                    <td>{{ $lesson_time['mata_pelajaran'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach
            @foreach ($lesson_times as $lesson_time)
                @if ($lesson_time['check'])
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover datatable">
                            <thead>
                                <tr>
                                    <th>
                                        Konten Pembelajaran
                                    </th>
                                    <th width="15%">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lesson_times as $lesson_time)
                                    @if ($lesson_time['check'])
                                        <tr>
                                            <td>
                                                {{ $lesson_time['konten'] }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#editmodal-{{ $lesson_time['id'] }}"
                                                    data-konten="{{ $lesson_time['konten'] }}"
                                                    data-id="{{ $lesson_time['id'] }}"><i
                                                        class="fa fa-pencil-square-o nav-icon"></i></button>
                                                <div class="modal fade" id="editmodal-{{ $lesson_time['id'] }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Konten
                                                                    Pembelajaran
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('admin.update.lesson', $lesson_time['id']) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="message-text"
                                                                            class="col-form-label">Deskripsi:</label>
                                                                        <textarea type="input" class="form-control" id="message-text-{{ $lesson_time['id'] }}" name="konten">{{ old('konten', $lesson_time['konten']) }}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="pdf_file" class="col-form-label">Lampirkan File Presentasi Jika Ada:</label>
                                                                        <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept="application/pdf">
                                                                    </div>
                                                                    <i style="color: red;">* PDF, Max. 2MB</i> <br>
                                                                    <i style="color: rgb(122, 121, 121);">(Dikarenakan layanan attachment diharuskan berlangganan premium, maka fitur lampiran file tidak berfungsi untuk saat ini)</i> <br>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Kembali</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Ubah</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <i style="color: red;">* Konten pembelajaran akan diteruskan kepada orang tua siswa</i> <br>
                    <i style="color: red;">* Silahkan berikan deskripsi yang jelas. contohnya: (1. Mata pelajaran, 2. Tema
                        pelajaran yang dibahas, dst.)</i>
                @endif
            @endforeach
            @if ($noLessonFound)
                <span
                    class="tracking-wider text-white bg-red-500 px-4 py-1 text-sm rounded leading-loose mx-2 font-semibold"
                    title="">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Tidak Ada Pelajaran Berlangsung
                </span>
            @endif
        </div>
    </div>
    <div class="card">

        <div class="card-header">
            Kelola Siswa
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-SchoolClass">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th width="5%%">
                                ID
                            </th>
                            <th>
                                {{ trans('cruds.siswa.fields.nis') }}
                            </th>
                            <th>
                                {{ trans('cruds.siswa.fields.named') }}
                            </th>
                            <th>
                                {{ trans('cruds.manage_class.fields.about') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($class->classSiswa as $s)
                            <tr>
                                <td></td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->named }}</td>
                                <td>

                                    @foreach ($lesson_times as $lesson_time)
                                        @if ($lesson_time['check'])
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal-{{ $s->id }}"
                                                data-nis="{{ $s->nis }}" data-name="{{ $s->named }}"
                                                data-whatever="@mdo"
                                                onclick="logStudentData('{{ $s->id }}', '{{ $lesson_time['id'] }}', '{{ $s->nis }}', '{{ $s->named }}')">
                                                <i class="fa fa-plus-circle nav-icon"></i></button>

                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#editmodal-{{ $s->id }}-{{ $lesson_time['id'] }}"
                                                data-nis="{{ $s->nis }}" data-name="{{ $s->named }}"
                                                onclick="logStudentData('{{ $s->id }}', '{{ $lesson_time['id'] }}', '{{ $s->nis }}', '{{ $s->named }}')"><i
                                                    class="fa fa-eye nav-icon"></i></button>
                                </td>
                            </tr>

                            {{-- tambah --}}
                            <div class="modal fade" id="exampleModal-{{ $s->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title badge badge-primary" id="exampleModalLabel">
                                                {{ $s->named }} - {{ $s->nis }} </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST"
                                            action="{{ route('admin.manage-class.store', $s->class_id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="siswa_id" value="{{ $s->id }}">
                                            <input type="hidden" name="class_id" value="{{ $s->class_id }}">
                                            @foreach ($lesson_times as $lesson)
                                                @if ($lesson['check'])
                                                    <input type="hidden" name="lesson_id[]"
                                                        value="{{ $lesson['id'] }}">
                                                @endif
                                            @endforeach
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Catatan:</label>
                                                    <textarea class="form-control" id="message-text" name="about"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="photo_path" class="col-form-label">Unggah Potret Siswa di Kelas:</label>
                                                    <input type="file" class="form-control-file" id="photo_path" name="photo_path">
                                                </div>
                                                <i style="color: red;">* jpeg,png,jpg,gif,svg MAX. 2MB</i> <br>
                                                <i style="color: rgb(122, 121, 121);">(Dikarenakan layanan attachment perlu berlangganan premium, maka fitur unggah foto tidak berfungsi untuk saat ini)</i> <br>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Kembali</button>
                                                <button type="submit" class="btn btn-primary">Tambah
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- edit --}}
                            @php
                                $aboutTexts = $s->manageSiswa
                                    ->filter(function ($manageSiswa) use ($lesson_time, $s) {
                                        return $manageSiswa->lesson_id == $lesson_time['id'] &&
                                            $manageSiswa->siswa_id == $s->id;
                                    })
                                    ->pluck('about')
                                    ->filter()
                                    ->toArray();
                            @endphp
                            <div class="modal fade" id="editmodal-{{ $s->id }}-{{ $lesson_time['id'] }}"
                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title badge badge-primary" id="exampleModalLabel">
                                                {{ $s->named }} - {{ $s->nis }}</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Catatan:</label>
                                                <div class="scroll p-2">
                                                    @foreach ($aboutTexts as $text)
                                                        <li class="list-group-item d-flex align-items-center border-0 mb-2 rounded-6"
                                                            style="background-color: #e9edf0;">
                                                            {{ $text }}
                                                        </li>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Kembali</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                        {{-- akhir edit --}}
                        @endforeach
                    </tbody>
                </table>
                <i style="color: red;">* Berikan catatan kepada tiap siswa terkait apapun yang menyangkut siswa pada saat
                    pembelajaran berlangsung</i><br>
                <i style="color: red;">* Tiap siswa bisa mendapat catatan beberapa poin, dan hanya akan dilihat oleh orang
                    tua siswa</i>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'asc']
                ],
                pageLength: 100,
            });
            $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>

    <script>
        function logLessonData(konten, lessonId) {
            console.log("Lesson data:", {
                konten,
                lessonId
            });
        }

        function logStudentData(studentId, lessonId, nis, named) {
            console.log("Student data:", {
                studentId,
                lessonId,
                nis,
                named
            });
        }
    </script>
@endsection
{{-- // $aboutTexts = $s->manageSiswa
//     ->where('lesson_id', $lesson_time['id'])
//     ->where('siswa_id', $s->id)
//     ->pluck('about')
//     ->filter()
//     ->toArray();
// $aboutTexts = null; // Inisialisasi dengan null

// $aboutTexts = $s->manageSiswa
//     ->filter(function ($manageSiswa) use ($lesson_times) {
//         return in_array($manageSiswa->lesson_id, $lesson_times->pluck('id')->toArray());
//     })
//     ->pluck('about')
//     ->toArray(); --}}
