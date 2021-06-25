@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('modals.search')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a> &gt; {{ __('Files') }} <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#searchModal">{{__('Search Form')}}</button></div>

                <div class="card-body">
                    <h4>{{ __('Books') }} <small class="text-muted">{{ count($files).' items'}}</small></h4>
                    <h6 class="p-2 m-2 text-muted">

                    </h6>
                    <div class="row p-2 m-2">
                      <div class="col-md-1">
                        <h5>{{ __('ID') }}</h5>
                      </div>
                      <div class="col-md-2">
                        <h5>{{ __('Uploaded by user') }}</h5>
                      </div>
                      <div class="col-md-2">
                        <h5>{{ __('Name') }}</h5>
                      </div>
                      <div class="col-md-2">
                        <h5>{{ __('Path') }}</h5>
                      </div>
                      <div class="col-md-1">
                        <h5>{{ __('Parsed') }}</h5>
                      </div>
                      <div class="col-md-2">
                        <h5>{{ __('file info') }}</h5>
                      </div>
                      <div class="col-md-2">
                        <h5>{{ __('Action') }}</h5>
                      </div>
                    </div>
                    <hr>
                    @foreach($files as $file)
                    <div class="row border p-2 m-2">
                      <div class="col-md-1">
                        {{ $file->id }}
                      </div>
                      <div class="col-md-2">
                        {{ $file->user->name }}
                      </div>
                      <div class="col-md-2">
                        {{ $file->name }}
                      </div>
                      <div class="col-md-2">
                        <input class="form-control" type="text" readonly value="{{ $file->path }}">
                      </div>
                      <div class="col-md-1">
                        {{ $file->parsed }}
                      </div>
                      <div class="col-md-2">
                        <span>type: {{$file->file_info['extension']}}</span><br>
                        <span>size: {{$file->file_info['size']}}</span><br>
                        <span>mime Type: {{$file->file_info['mimeType']}}</span><br>
                      </div>
                      <div class="col-md-2">
                        <a href="{!! $file->url() !!}"> download </a>
                        <form method="post" action="{!! route('parse.file') !!}">
                          @csrf
                          <input type="hidden" name="file_id" value="{{ $file->id }}">
                          <button type="submit" class="btn btn-sm btn-success">{{ __('Parse file') }}
                        </form>
                        <form method="post" action="{!! route('delete.file') !!}">
                          @csrf
                          <input type="hidden" name="file_id" value="{{ $file->id }}">
                          <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete file from DB and system') }}
                        </form>
                      </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
  @parent
  <script>
    var current_url = "{!! route('index.knjiga') !!}";
  </script>
  <script src="{{ asset('vendor/app_utils.js') }}" defer></script>
@endsection
