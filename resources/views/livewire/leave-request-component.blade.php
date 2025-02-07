
<div class="container py-4">
    <!-- بطاقة عنوان رئيسية -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title mb-0">  {{ __('messages.leave_requests') }}  </h4>
        </div>
        <div class="card-body bg-light">
            <!-- عرض رسائل الخطأ والنجاح -->
            @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- نموذج الإضافة/التعديل -->
            <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
                @csrf
                <div class="row">
                    <!-- اختيار الموظف أو إخفاءه إذا لم يكن إداريًا -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">  {{ __('messages.employee_name') }}</label>
                        @if(Auth::check() && Auth::user()->role === 'admin')
                        <!-- الإداري يختار الموظف من قائمة -->
                        <select wire:model="employee_id" class="form-select">
                            <option value="">   {{ __('messages.select_employee') }}</option>
                            @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->employee_name }}</option>
                            @endforeach
                        </select>
                        @else
                        <!-- الموظف العادي لا يظهر له الاختيار -->
                        <input type="hidden" wire:model="employee_id" value="{{ Auth::id() }}">
                        <div class="form-control-plaintext">
                            {{ Auth::user()->name }} <!-- عرض اسم الموظف فقط -->
                        </div>
                        @endif

                        @error('employee_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- نوع الإجازة -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">   {{ __('messages.leave_type') }}</label>
                        <select wire:model="leave_type_id" class="form-select">
                            <option value="">  {{ __('messages.select_leave_type') }} </option>
                            @foreach($leaveTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->leave_type_name }}</option>
                            @endforeach
                        </select>
                        @error('leave_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- من تاريخ -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">  {{ __('messages.from_date') }} </label>
                        <input wire:model="from_date" type="date" class="form-control">
                        @error('from_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- إلى تاريخ -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">  {{ __('messages.to_date') }} </label>
                        <input wire:model="to_date" type="date" class="form-control">
                        @error('to_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- سبب الإجازة -->
                <div class="mb-3">
                    <label class="form-label"> {{ __('messages.reason') }}  </label>
                    <input wire:model="reason" class="form-control" placeholder="مثال: ظروف صحية، سفر...">
                    @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- ملاحظات -->
                <div class="mb-3">
                    <label class="form-label">ملاحظات</label>
                    <textarea wire:model="notes" class="form-control" rows="3" placeholder="أي تفاصيل إضافية"></textarea>
                    @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- الحالة (فقط للإداري) -->
                @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.status') }}</label>
                    <select wire:model="status" class="form-select">
                        <option value="pending"> {{ __('messages.pending') }}</option>
                        <option value="approved">{{ __('messages.rejected') }}</option>
                        <option value="rejected">مرفوض</option>
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @else
                <input wire:model="status" value="pending" type="hidden" class="form-control">
                @endif

                <!-- الأزرار -->
                @if($updateMode)
                <button type="submit" class="btn btn-primary me-2">{{ __('messages.update') }}</button>
                <button type="button" wire:click="resetInputs" class="btn btn-secondary">{{ __('messages.cancel') }}</button>
                @else
                <button type="submit" class="btn btn-success">{{ __('messages.add') }}</button>
                @endif
            </form>
        </div>
    </div>

    <!-- بطاقة عرض قائمة الطلبات -->
    <div class="container my-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white">
                <h5 class="card-title mb-0">{{ __('messages.request_list') }}</h5>
            </div>
            <div class="card-body p-0 bg-white">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                        <th>{{ __('messages.id') }}</th>
                         <th>{{ __('messages.employee') }}</th>
                         <th>{{ __('messages.leave_type') }}</th>
                         <th>{{ __('messages.from') }}</th>
                         <th>{{ __('messages.to') }}</th>
                         <th>{{ __('messages.status') }}</th>
                         <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaveRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->employee->employee_name }}</td>
                            <td>{{ $request->leaveType->leave_type_name }}</td>
                            <td>{{ $request->from_date }}</td>
                            <td>{{ $request->to_date }}</td>
                            <td>
                                @if($request->status === 'pending')
                                <span class="badge bg-warning">قيد الانتظار</span>
                                @elseif($request->status === 'approved')
                                <span class="badge bg-success">موافقة</span>
                                @else
                                <span class="badge bg-danger">مرفوض</span>
                                @endif
                            </td>
                            <td>
                                <!-- زر التعديل -->
                                <button class="btn btn-sm btn-info"
                                    wire:click="edit({{ $request->id }})">
                                    {{ __('messages.edit') }}
                                    </button>

                                <!-- زر الحذف -->
                                <button class="btn btn-sm btn-danger"
                                    wire:click="delete({{ $request->id }})"
                                    onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                    {{ __('messages.delete') }}
                                    </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-3">
                                لا توجد طلبات في الوقت الحالي.
                            </td>
                            @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
