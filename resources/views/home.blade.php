@extends('layouts.app2')

@section('content')
<div class="container py-5">
    <!-- عنوان عام للصفحة -->
    <div class="text-center mb-4">
        <h1 class="display-4">{{ __('messages.login') }}</h1>
        <p class="lead">{{ __('messages.welcome_message') }}</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- بطاقة توضح حالة تسجيل الدخول -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">{{ __('messages.account_status') }}</h5>
        </div>
        <div class="card-body">
            {{ __('messages.logged_in') }}
        </div>
    </div>

    <div class="row">
        @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.manage_employees') }}</h5>
                        <p class="card-text">
                            {{ __('messages.manage_employees_description') }}
                        </p>
                        <a href="{{ route('employees.index') }}" class="btn btn-primary">
                            {{ __('messages.view_employees') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.leave_requests') }}</h5>
                    <p class="card-text">
                        {{ __('messages.leave_requests_description') }}
                    </p>
                    <a href="{{ route('leave-requests.index') }}" class="btn btn-primary">
                        {{ __('messages.view_requests') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
