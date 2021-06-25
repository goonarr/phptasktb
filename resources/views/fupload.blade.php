@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a> &gt; {{ __('File upload') }}</div>

                <div class="card-body">
                    <h3>{{ __('File upload') }}</h3>
                    <form class="col-md-12" method="post" action="{{ route('upload') }}" aria-label="{{ __('Upload') }}" enctype="multipart/form-data">
                      @csrf
                      <div class="custom-file form-group">
                        <input type="file" class="custom-file-input" type="file" id="file_name" name="file_name" accept=".csv,.xlsx,.xml" oninput="this.nextElementSibling.value = this.value">
                        <output class="small"></output>
                        <label class="custom-file-label" for="file_name">{{ __('Select file for upload') }}</label>
                        <small class="text-muted px-4">{{ __('ONLY .csv, .xml, .xlsx ALLOWED') }}</small>
                      </div>

                        <div class="custom-control custom-radio form-group pt-4">
                          <input type="radio" id="parseOptin1" name="parseOptin" checked class="custom-control-input" value="upload-parse">
                          <label class="custom-control-label" for="parseOptin1">Upload and parse</label>
                        </div>

                        <div class="custom-control custom-radio form-group">
                          <input type="radio" id="parseOptin2" name="parseOptin" class="custom-control-input" value="upload">
                          <label class="custom-control-label" for="parseOptin2">Just upload</label>
                        </div>

                      <div class="form-group row">
                        <button class="btn btn-primary" name="submit"  type="submit">{{ __('Upload') }}</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
