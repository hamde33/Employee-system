@extends('layouts.app') 

@section('content')
<div class="container py-4">
    <!-- رسالة نجاح/خطأ -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(Auth::check() && Auth::user()->role === 'admin')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">إدارة المستخدمين</h3>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> إضافة مستخدم جديد
        </a>
    </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#ID</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الدور (Role)</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role ?? 'N/A' }}</td>
                <td>
                    <!-- زر التعديل -->
                    <a href="{{ route('users.edit', $u->id) }}" class="btn btn-sm btn-info">
                        <i class="bi bi-pencil-square"></i> تعديل
                    </a>

                    <!-- زر الحذف -->
                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            <i class="bi bi-trash3-fill"></i> حذف
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">لا يوجد مستخدمون مسجلون</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- روابط التصفح -->
    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection
