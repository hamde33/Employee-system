@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">إضافة مستخدم جديد</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>خطأ!</strong> تحقق من المدخلات التالية:
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <input type="text" name="name" id="name" 
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" id="email" 
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <input type="password" name="password" id="password" 
                   class="form-control @error('password') is-invalid @enderror" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">الدور (Role)</label>
            <input type="text" name="role" id="role" 
                   class="form-control"
                   placeholder="مثال: admin أو employee"
                   value="{{ old('role') }}">
        </div>

        <button type="submit" class="btn btn-success">حفظ</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection
