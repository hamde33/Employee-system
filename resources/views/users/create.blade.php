@extends('layouts.app2')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">{{ __('messages.add_user_employee') }}</h3>

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

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <!-- حقول المستخدم -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('messages.email_for_login') }}</label>
            <input type="email" name="email" id="email" 
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('messages.password') }}</label>
            <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">{{ __('messages.role') }}</label>
            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                <option value="employee" selected>{{ __('messages.employee') }}</option>
                <option value="admin">{{ __('messages.admin') }}</option>
            </select>
        </div>

        <hr>

        <!-- حقول الموظف -->
        <div class="mb-3">
            <label for="employee_name" class="form-label">{{ __('messages.employee_name') }}</label>
            <input type="text" name="employee_name" id="employee_name"
                   class="form-control @error('employee_name') is-invalid @enderror"
                   value="{{ old('employee_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="employee_number" class="form-label">{{ __('messages.employee_number') }}</label>
            <input type="text" name="employee_number" id="employee_number"
                   class="form-control @error('employee_number') is-invalid @enderror"
                   value="{{ old('employee_number') }}" required>
        </div>

        <div class="mb-3">
            <label for="mobile_number" class="form-label">{{ __('messages.mobile_number') }}</label>
            <input type="text" name="mobile_number" id="mobile_number"
                   class="form-control @error('mobile_number') is-invalid @enderror"
                   value="{{ old('mobile_number') }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">{{ __('messages.address') }}</label>
            <input type="text" name="address" id="address"
                   class="form-control @error('address') is-invalid @enderror"
                   value="{{ old('address') }}">
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">{{ __('messages.notes') }}</label>
            <textarea name="notes" id="notes"
                      class="form-control @error('notes') is-invalid @enderror"
                      rows="3">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
