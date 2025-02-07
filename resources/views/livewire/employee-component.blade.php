
<div class="container mt-5 p-4 shadow-lg bg-white rounded">
    <h2 class="mb-4 text-center text-primary">{{ __('messages.manage_employees') }} </h2>

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
        <h5 class="mb-0">{{ $updateMode ? __('messages.edit_employee') : __('messages.add_employee') }}</h5>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="employee_name" class="form-label"> {{ __('messages.employee_name') }}</label>
                    <input wire:model="employee_name" id="employee_name" type="text" class="form-control" placeholder="{{ __('messages.enter_name') }}">
                    @error('employee_name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label for="employee_number" class="form-label">{{ __('messages.employee_number') }}</label>
                    <input wire:model="employee_number" id="employee_number" type="text" class="form-control" placeholder="{{ __('messages.enter_employee_number') }}">
                    @error('employee_number') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label for="mobile_number" class="form-label">{{ __('messages.mobile_number') }}</label>
                    <input wire:model="mobile_number" id="mobile_number" type="text" class="form-control" placeholder="{{ __('messages.enter_mobile_number') }}">
                    @error('mobile_number') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label for="address" class="form-label">{{ __('messages.address') }}</label>
                    <input wire:model="address" id="address" type="text" class="form-control" placeholder="{{ __('messages.enter_address') }}">
                    @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="notes" class="form-label">{{ __('messages.notes') }}</label>
                    <textarea wire:model="notes" id="notes" class="form-control" placeholder="{{ __('messages.enter_notes') }}" rows="3"></textarea>
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
                    <th>{{ __('messages.employee_name') }}</th>
                    <th>{{ __('messages.employee_number') }} </th>
                    <th>{{ __('messages.mobile_number') }} </th>
                    <th>{{ __('messages.address') }}</th>
                    <th>{{ __('messages.notes') }}</th>
                    <th>{{ __('messages.actions') }}</th>
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
                            {{ __('messages.edit') }}
                            </button>
                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $emp->id }})" onclick="return confirm('هل أنت متأكد؟')">
                            {{ __('messages.delete') }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">  {{ __('messages.no_data') }}   </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
