@extends('layouts.admin')
@section('content')
    @can('school_class_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.school-classes.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.schoolClass.title_singular') }}
                </a>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('cruds.schoolClass.title_singular') }} 
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-SchoolClass">
                    <thead>
                        <tr>
                            <th>

                            </th>
                            <th width="10%">
                                {{ trans('cruds.schoolClass.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.schoolClass.fields.name') }}
                            </th>

                            <th>
                                Jadwal
                            </th>

                            {{-- @can('sesi_pembelajaran')
                                <th>
                                    Sesi
                                </th>
                            @endcan --}}
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schoolClasses as $key => $school_class)
                            <tr data-entry-id="{{ $school_class->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $school_class->id ?? '' }}
                                </td>
                                <td>
                                    {{ $school_class->name ?? '' }}
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-success"
                                        href="{{ route('admin.calendar.index') }}?class_id={{ $school_class->id }}">
                                        <i class="fa fa-calendar-check-o nav-icon"></i>
                                    </a>
                                </td>
                                <td>
                                    @can('school_class_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.school-classes.show', $school_class->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('school_class_edit')
                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.school-classes.edit', $school_class->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('school_class_delete')
                                        {{-- <form action="{{ route('admin.school-classes.destroy', $school_class->id) }}"
                                            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
                                        </form> --}}

                                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal"
                                            data-target="#confirmDeleteModalclass-{{ $school_class->id }}">
                                            {{ trans('global.delete') }}
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="confirmDeleteModalclass-{{ $school_class->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="confirmDeleteModalLabel-{{ $school_class->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        Apa kamu serius menghapus data tersebut?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Kembali</button>
                                                        <form action="{{ route('admin.school-classes.destroy', $school_class->id) }}"
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('school_class_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.school-classes.massDestroy') }}",
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
            $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
