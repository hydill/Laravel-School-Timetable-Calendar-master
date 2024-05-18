@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.konten.title') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.kontens.store') }}" enctype="multipart/form-data">
                @csrf
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        
                            {!! \Session::get('success') !!}</li>
                        
                    </div>
                @endif
                <div class="form-group">
                    <label class="required" for="class_id">{{ trans('cruds.lesson.fields.class') }}</label>
                    <select class="form-control select2 {{ $errors->has('class_id') ? 'is-invalid' : '' }}" name="class_id"
                        id="class_id" required>
                        @foreach ($classes as $id => $class)
                            <option value="{{ $id }}" {{ old('class_id') == $id ? 'selected' : '' }}>
                                {{ $class }}</option>
                        @endforeach
                    </select>
                    {{-- @if ($errors->has('class'))
                        <div class="invalid-feedback">
                            {{ $errors->first('class') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span> --}}
                </div>
                <div class="form-group">
                    <label class="required" for="desc">{{ trans('cruds.konten.fields.desc') }}</label>
                    <input class="form-control {{ $errors->has('desc') ? 'is-invalid' : '' }}" type="text" name="desc"
                        id="desc" value="{{ old('desc') }}">
                    @if ($errors->has('desc'))
                        <div class="invalid-feedback">
                            {{ $errors->first('desc') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.konten.fields.desc_helper') }}</span>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
