<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
<style>
    @font-face {
    font-family: 'Amiri';
    src: url("{{ public_path('fonts/Amiri-Regular.ttf') }}") format('truetype');
    font-weight: normal;
    font-style: normal;
}
body {
    font-family: 'Amiri', sans-serif;
}

    </style>

    <meta charset="utf-8">
    <title>قائمة الطلبات</title>
    <style>
        body {
            font-family: sans-serif;
            direction: rtl;
            text-align: right;
            margin: 20px;
        }
        h3 {
            text-align: center;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #6c757d;
            color: #fff;
            padding: 10px;
        }
        .card-body {
            padding: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .badge {
            padding: 5px;
            border-radius: 3px;
            font-size: 12px;
        }
        .bg-warning {
            background-color: #ffc107;
            color: #000;
        }
        .bg-success {
            background-color: #28a745;
            color: #fff;
        }
        .bg-danger {
            background-color: #dc3545;
            color: #fff;
        }
        /* إزالة تنسيق الأزرار في PDF */
        .btn {
            display: none;
        }
    </style>
</head>
<body>
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="card-title mb-0">قائمة الطلبات</h5>
        </div>
        <div class="card-body bg-white">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
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
                        <td>
                            <!-- في PDF يمكن إزالة أزرار التعديل والحذف أو تركها كنص فقط -->
                            تعديل - حذف
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-3">
                            لا توجد طلبات في الوقت الحالي.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
