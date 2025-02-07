@extends('layouts.app2')

@section('content')

    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="card-title mb-0">قائمة الطلبات</h5>
        </div>
        <div class="card-body bg-white">
        <table class="table table-bordered table-hover" style="direction: rtl;">
    <thead>
        <tr>
            <th>ID</th>
            <th>الموظف</th>
            <th>نوع الإجازة</th>
            <th>من</th>
            <th>إلى</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
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
            <td>تعديل - حذف</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">لا توجد طلبات في الوقت الحالي.</td>
        </tr>
        @endforelse
    </tbody>
</table>

        </div>
    </div>
    @endsection