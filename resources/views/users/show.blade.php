@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>

                <div class="card-body">
                    <div class="form-group row">
                        <p class="col-md-4 text-md-right">{{ __('First Name') }}</p>

                        <div class="col-md-6">
                            <p>{{ $user->first_name }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <p class="col-md-4  text-md-right">{{ __('Last Name') }}</p>

                        <div class="col-md-6">
                            <p>{{ $user->last_name }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <p class="col-md-4  text-md-right">{{ __('E-Mail Address') }}</p>

                        <div class="col-md-6">
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <p class="col-md-4  text-md-right">{{ __('Department') }}</p>

                        <div class="col-md-6">
                            <p>{{ $user->department->code }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
