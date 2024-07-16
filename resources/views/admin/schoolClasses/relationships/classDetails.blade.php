@foreach ($lesson_timess as $lesson_time)
    @if ($lesson_time['check'])
        <span class="tracking-wider text-white bg-green-500 px-4 py-1 text-sm rounded leading-loose mx-2 font-semibold"
            title="">
            <i class="fa fa-info-circle" aria-hidden="true"></i> Pelajaran Sedang Berlangsung
        </span>
        <br>
        <br>
        <h6>{{ $today }}</h6>
        <br>
        <i style="color: red;">* Ini adalah pemberitahuan yang akan diterima oleh orang tua siswa melalui Whatsapp.
            Silahkan pilih tujuan
            terlebih dahulu!</i>
        <table class=" table table-bordered table-striped table-hover datatable">

            <form method="POST" action="{{ route('admin.school-classes.send-notification', $lesson_time['class_id']) }}"
                enctype="multipart/form-data">
                @csrf
                <tbody>
                    <tr>
                        <td width="10%"><b>Sesi</b></td>
                        <td>
                            <h6>
                                Sesi pelajaran dari pukul {{ $lesson_time['start_time'] }} hingga
                                {{ $lesson_time['end_time'] }}
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td width="10%"><b>Guru</b></td>
                        <td>
                            <h6>
                                Kelas dikelola oleh guru atas nama: {{ $lesson_time['teacher_id'] }}
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        @php
                            $keterangan = '<em>Belum diinput oleh guru di kelas</em>';
                        @endphp
                        <td width="10%"><b>Konten</b></td>
                        <td>
                            <h6> {!! $lesson_time['konten'] ?? $keterangan !!}</h6>
                        </td>
                    </tr>
                    <tr>
                        @php
                            $aboutTexts = [];
                        @endphp
                        <td width="10%"><b>Siswa</b></td>
                        <td>
                            @if ($message)
                                @foreach ($message as $msg)
                                    @foreach ($msg->siswa as $item)
                                        <span class="badge badge-info">{{ $item->named }}</span>
                                        <input type="hidden" name="phone_number[]" value="{{ $item->phone_number }}">
                                        @foreach ($lesson_time['manage_siswa'] as $manage_siswa)
                                            @if ($manage_siswa->siswa_id == $item->id)
                                                @php
                                                    $aboutTexts[] = $manage_siswa->about;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @else
                                <p>tidak ada catatan untuk siswa</p>
                            @endif
                        </td>

                    </tr>
                </tbody>
        </table>
        @php
            $aboutTextsString = implode("\n+ ", $aboutTexts);
            $valueText = "Selamat {$timeOfDay} Bapak/Ibu,\nSemoga senantiasa diberi kesehatan dan keselamatan🤲 \nIzin memberikan informasi terkait kelas hari ini:\n\n";
            $valueText .= "+ {$today}\n";
            $valueText .= "   Sesi Pembelajaran: {$lesson_time['start_time']} - {$lesson_time['end_time']}\n";
            $valueText .= "   Guru: {$lesson_time['teacher_id']}\n\n";
            $valueText .= "*Selengkapnya*:\n\n+  {$lesson_time['konten']}\n\n";

        @endphp
        <input type="hidden" name="message_content" value="{{ $valueText }}">
        <input type="hidden" name="about" value="{{ $aboutTextsString }}">
        {{-- <input type="hidden" name="message_content" value="<p>This is a paragraph with &quot;quotes&quot; and &lt;other&gt; special characters.</p>"> --}}
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-2">

                    <button type="button"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-md"
                        data-toggle="modal" data-target="#exampleModal-{{ $lesson_time['id'] }}"
                        data-lesson-id="{{ $lesson_time['id'] }}" data-whatever="@mdo"> <i
                            class="fa fa-plus-circle nav-icon">&nbsp;&nbsp;&nbsp;</i>Pilih Tujuan</button>
                </div>
                <div class="col-2">

                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md">
                        <i class="fa fa-paper-plane nav-icon"></i>&nbsp;&nbsp;Kirim Pesan</button>
                </div>
            </div>
        </div>
        </form>
        {{-- modal tambah siswa vvvv --}}
        <div class="modal fade" id="exampleModal-{{ $lesson_time['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">
                            <b>Tentukan siswa sebagai tujuan</b>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('admin.send.students', $lesson_time['id']) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="lesson_id" value="{{ $lesson_time['id'] }}">
                            <select class="form-control select2" name="siswa[]" id="siswa" multiple required>
                                @foreach ($students as $s)
                                    <option value="{{ $s->id }}">{{ $s->named }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="d-flex justify-content-end mb-2">
                                <label for="select_all" class="mr-2">Select All</label>
                                <input type="checkbox" id="select_all">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary">Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- modal tambah siswa ^^^^ --}}
    @endif
@endforeach

@if ($noLessonFound)
    <span class="tracking-wider text-white bg-red-500 px-4 py-1 text-sm rounded leading-loose mx-2 font-semibold"
        title="">
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Tidak Ada Pelajaran Sedang Berlangsung
    </span>
@endif
<script>
    document.getElementById('select_all').addEventListener('change', function() {
        var selectAll = this.checked;
        var siswaSelect = document.getElementById('siswa');

        for (var i = 0; i < siswaSelect.options.length; i++) {
            siswaSelect.options[i].selected = selectAll;
        }
    });
</script>

{{-- 



<script>
    document.getElementById('siswaForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman form standar

        let form = event.target;
        let formData = new FormData(form);

        fetch('{{ route('admin.send.students') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Perbarui isi tag <td>
                    let siswaList = data.students.map(students =>
                        `<span class="badge badge-info">${students.named}  </span>`).join('');
                    document.getElementById('siswaList').innerHTML = siswaList;

                    // Tutup modal
                    $('#exampleModal').modal('hide'); 

                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script> --}}







{{-- @if ($message)
                                @foreach ($message as $msg)
                                    @foreach ($msg->siswa as $item)
                                        <span class="badge badge-info">{{ $item->named }}</span>
                                        <input type="hidden" name="phone_number[]" value="{{ $item->phone_number }}">
                                        @if ($item->manageSiswa)
                                            @foreach ($item->manageSiswa as $manage)
                                                @php
                                                    $aboutTexts[] = $manage->about;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endforeach
                            @else
                                <p>tidak ada catatan untuk siswa</p>
                            @endif --}}
