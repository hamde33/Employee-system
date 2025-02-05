@extends('layouts.app')

@section('content')
<div class="container mt-5 p-4 shadow-lg bg-white rounded">
    <h2 class="mb-4 text-center text-primary">إدارة الموظفين</h2>

    <!-- عرض رسالة نجاح عند الإضافة/التعديل/الحذف -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- نموذج الإضافة أو التعديل -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $updateMode ? 'تعديل موظف' : 'إضافة موظف جديد' }}</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="employee_name" class="form-label">الاسم</label>
                        <input wire:model="employee_name" id="employee_name" type="text" class="form-control" placeholder="أدخل الاسم">
                        @error('employee_name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="employee_number" class="form-label">الرقم الوظيفي</label>
                        <input wire:model="employee_number" id="employee_number" type="text" class="form-control" placeholder="أدخل الرقم الوظيفي">
                        @error('employee_number') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="mobile_number" class="form-label">رقم الهاتف</label>
                        <input wire:model="mobile_number" id="mobile_number" type="text" class="form-control" placeholder="أدخل رقم الهاتف">
                        @error('mobile_number') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="address" class="form-label">العنوان</label>
                        <input wire:model="address" id="address" type="text" class="form-control" placeholder="أدخل العنوان">
                        @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <textarea wire:model="notes" id="notes" class="form-control" placeholder="أدخل ملاحظات" rows="3"></textarea>
                        @error('notes') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    @if($updateMode)
                        <button type="submit" class="btn btn-primary me-2">حفظ التعديلات</button>
                        <button type="button" class="btn btn-secondary" wire:click="resetInputs">إلغاء</button>
                    @else
                        <button type="submit" class="btn btn-success">إضافة موظف</button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- جدول الموظفين -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mt-3">
            <thead class="table-light text-center">
                <tr>
                    <th>ID</th>
                    <th>الاسم</th>
                    <th>الرقم الوظيفي</th>
                    <th>رقم الهاتف</th>
                    <th>العنوان</th>
                    <th>ملاحظات</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                    <tr>
                        <td class="text-center">{{ $emp->id }}</td>
                        <td>{{ $emp->employee_name }}</td>
                        <td class="text-center">{{ $emp->employee_number }}</td>
                        <td class="text-center">{{ $emp->mobile_number }}</td>
                        <td>{{ $emp->address }}</td>
                        <td>{{ $emp->notes }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info me-1" wire:click="edit({{ $emp->id }})">
                                تعديل
                            </button>
                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $emp->id }})" onclick="return confirm('هل أنت متأكد؟')">
                                حذف
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">لا توجد بيانات متاحة</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
