@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- عنوان عام للصفحة -->
    <div class="text-center mb-4">
        <h1 class="display-4">لوحة التحكم</h1>
        <p class="lead">مرحبًا بك! يمكنك إدارة النظام من خلال هذه الواجهة.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- بطاقة توضح حالة تسجيل الدخول -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">حالة الحساب</h5>
        </div>
        <div class="card-body">
            {{ __('You are logged in!') }}
        </div>
    </div>

    <div class="row">
    @if(Auth::check() && Auth::user()->role === 'admin')

        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">إدارة الموظفين</h5>
                    <p class="card-text">
                        إضافة وتحرير وحذف بيانات الموظفين. يمكنك متابعة بيانات التواصل والملاحظات الخاصة بكل موظف.
                    </p>
                    <a href="{{ route('employees.index') }}" class="btn btn-primary">
                        عرض الموظفين
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">طلبات الإجازة</h5>
                    <p class="card-text">
                        مراجعة الطلبات الجديدة وقبولها أو رفضها، وعرض تفاصيل الإجازة للموظفين.
                    </p>
                    <a href="{{ route('leave-requests.index') }}" class="btn btn-primary">
                        عرض الطلبات
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
