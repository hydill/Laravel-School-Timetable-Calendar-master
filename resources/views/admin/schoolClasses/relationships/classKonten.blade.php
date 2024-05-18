{{-- @can('konten_create') --}}
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.kontens.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.konten.title') }}
        </a>
    </div>
</div>

<div class="card">

    <div class="card-header">

        {{ trans('cruds.konten.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>

                        {{-- <th width="10">
                            {{ trans('cruds.konten.fields.id') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.konten.fields.desc') }}
                        </th>
                        <th width="10">
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($kontens as $konten)
                        <tr>

                            {{-- <td>
                                {{ $konten->id ?? '' }}
                            </td> --}}

                            <td>

                                {{ $konten->desc ?? '' }}
                            </td>

                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.kontens.show', $konten->id) }}">
                                    {{ trans('global.view') }}
                                </a>

                                <a class="btn btn-xs btn-info" href="{{ route('admin.kontens.edit', $konten->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                                <form action="{{ route('admin.kontens.destroy', $konten->id) }}" method="POST"
                                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                    style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger"
                                        value="{{ trans('global.delete') }}">
                                </form>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- @endcan --}}
