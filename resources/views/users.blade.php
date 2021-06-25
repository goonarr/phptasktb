@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a> &gt; {{ __('Users') }}</div>

                <div class="card-body">
                    <h4>{{ __('Users') }}</h4>
                    <div class="row">
                      <div class="col-md-3">
                        <h5>{{ __('Name') }}</h5>
                      </div>
                      <div class="col-md-3">
                        <h5>{{ __('Email') }}</h5>
                      </div>
                      <div class="col-md-2">
                        <h5>{{ __('Role') }}</h5>
                      </div>
                      <div class="col-md-4">
                        <h5>{{ __('Action') }}</h5>
                      </div>
                    </div>
                    <hr>
                    @foreach ($users as $user)
                      <div class="row border p-2 m-2">
                        <div class="col-md-3">
                          {{ $user->name }}
                        </div>
                        <div class="col-md-3">
                          {{ $user->email }}
                        </div>
                        <div class="col-md-2">
                          {{ $user->role }}
                        </div>
                        <div class="col-md-4">
                          <form method="post" action="{{ route('update.role') }}">
                            @csrf
                            <input type="hidden" value="{{ $user->id }}" name="userId">
                            <div class="form-row">
                              <div class="col-ms-6">
                                <select class="custom-select custom-select-sm" name="newRole">
                                  <option selected>{{ __('Change role')}}</option>
                                  <option value="super_admin">{{__('Super Admin')}}</option>
                                  <option value="Admin">{{__('Admin')}}</option>
                                  <option value="Member">{{__('Member')}}</option>
                                </select>
                              </div>
                              <div class="col-ms-6">
                                <button type="submit" class="btn btn-sm btn-primary">{{ __('Submit') }}</button>
                              </div>
                            </div>
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
