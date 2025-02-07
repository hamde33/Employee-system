@extends('layouts.app2')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">{{ __('messages.edit_user_data') }}</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>{{ __('messages.error') }}</strong> {{ __('messages.check_inputs') }}
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('messages.name') }}</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('messages.email') }}</label>
            <input type="email" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('messages.new_password_optional') }}</label>
            <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ __('messages.password_placeholder') }}">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">{{ __('messages.role') }}</label>
            <input type="text" name="role" id="role" 
                   class="form-control"
                   value="{{ old('role', $user->role) }}">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
