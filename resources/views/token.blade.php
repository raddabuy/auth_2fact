@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Two factor authentication') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{url('/auth/token')}}">
                            @csrf

                            <div class="form-group row">
                                <label for="token" class="col-md-4 col-form-label text-md-right">{{ __('Token') }}</label>

                                <div class="col-md-6">
                                    <input id="token" type="token" name="token" class="form-control" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Validate') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
