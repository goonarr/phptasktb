@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('modals.search')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a> &gt; {{ __('Books of Knjige') }} <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#searchModal">{{__('Search Form')}}</button></div>

                <div class="card-body">
                    <h4>{{ __('Books') }} <small class="text-muted">{{ count($knjige).' items'}}</small></h4>
                    <h6 class="p-2 m-2 text-muted">
                      <span>{{__('Search terms')}}: </span>
                      @if ( count($search_terms)==0 )
                        {{__('none')}}
                      @endif

                      @foreach ($search_terms as $name=>$term)
                        <span> {{ $name.'='.$term }}</span>
                      @endforeach
                    </h6>
                    <div class="row p-2 m-2">
                      <div class="col-md-1">
                        <h5>{{ __('ID') }}</h5>
                      </div>
                      <div class="col-md-3">
                        <h5>{{ __('Naziv') }}</h5>
                      </div>
                      <div class="col-md-3">
                        <h5>{{ __('Autor') }}</h5>
                      </div>
                      <div class="col-md-3">
                        <h5>{{ __('Izdavac') }}</h5>
                      </div>
                      <div class="col-md-2">
                        <h5>{{ __('Godina izdanja') }}</h5>
                      </div>
                    </div>
                    <hr>
                    @foreach($knjige as $knjiga)
                    <div class="row border p-2 m-2">
                      <div class="col-md-1">
                        {{ $knjiga->id }}
                      </div>
                      <div class="col-md-3">
                        {{ $knjiga->naziv }}
                      </div>
                      <div class="col-md-3">
                        {{ $knjiga->autor }}
                      </div>
                      <div class="col-md-3">
                        {{ $knjiga->izdavac }}
                      </div>
                      <div class="col-md-2">
                        {{ $knjiga->godinaIzdanja() }}
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
