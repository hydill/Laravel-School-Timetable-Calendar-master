@extends('layouts.admin')
@section('content')
    {{-- @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif --}}
    <div class="content">
        @can('view_count')
            <div class="row">
                <div class="col-sm-6 col-xl-6">

                    <div class="card-counter primary">

                        <i class="fa fa-users"></i>
                        <span class="count-numbers">{{ $siswa->count() }}</span>
                        <span class="count-name">TOTAL SISWA</span>


                    </div>
                </div>
                <div class="col-sm-6 col-xl-6">
                    <div class="card-counter success">
                        <i class="fa fa-user"></i>
                        <span class="count-numbers">{{ $user->count() }}</span>
                        <span class="count-name">TOTAL GURU</span>
                    </div>
                </div>

            </div>
        @endcan
        {{-- <div class="mt-4">
            <div id='calendar'></div>

        </div> --}}
        <div class="mt-4">
            <div id='calendar'></div>
           <div id="report"></div>
        </div>

    </div>
@endsection
@section('scripts')
    @parent
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            dateClick: function(info) {
                fetch('/report/' + info.dateStr)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        var reportContent = '<h3>Laporan Harian</h3><ul>';
                        data.forEach(function(report) {
                            reportContent += '<li>' + report.siswa.named + ': ' + report.about + '</li>';
                        });
                        reportContent += '</ul>';
                        document.getElementById('report').innerHTML = reportContent;
                    })
                    .catch(error => {
                        console.error('There was a problem with your fetch operation:', error);
                        document.getElementById('report').innerHTML = '<p>Error loading report.</p>';
                    });
            }
        });
        calendar.render();
    });
</script>