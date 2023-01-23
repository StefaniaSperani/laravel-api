@extends('layouts.app')

@section('content')
@include('partials.sidebar')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mycard">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <br>
                    <button class="btn btn-danger mylink my-2">
                        <a class="nav-link " href="{{url('admin/projects') }}">{{ __('Projects') }}</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
