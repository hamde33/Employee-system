@extends('layouts.app2')

@section('content')
<div class="container py-4">
    <!-- رسالة نجاح/خطأ -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">{{ __('messages.manage_users') }}</h3>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> {{ __('messages.add_new_user') }}
            </a>
        </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#ID</th>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.role') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role ?? __('messages.not_available') }}</td>
                <td>
                    <!-- زر التعديل -->
                    <a href="{{ route('users.edit', $u->id) }}" class="btn btn-sm btn-info">
                        <i class="bi bi-pencil-square"></i> {{ __('messages.edit') }}
                    </a>

                    <!-- زر الحذف -->
                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            <i class="bi bi-trash3-fill"></i> {{ __('messages.delete') }}
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">{{ __('messages.no_users_registered') }}</td>
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
