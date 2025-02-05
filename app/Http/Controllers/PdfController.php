<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; // تأكد من استيراد Facade الخاص بالمكتبة
use App\Models\LeaveRequest; // نموذج الطلبات (تأكد من صحة اسم الموديل)

class PdfController extends Controller
{
    public function generateLeaveRequestsPdf()
    {
        // جلب بيانات الطلبات من قاعدة البيانات مع العلاقات المطلوبة (الموظف ونوع الإجازة)
        $leaveRequests = LeaveRequest::with(['employee', 'leaveType'])->get();

        // تحميل العرض وتمرير البيانات إليه
     
$pdf = PDF::setOptions([
    'isHtml5ParserEnabled' => true,
    'isRemoteEnabled'      => true,
    'defaultFont'          => 'DejaVu Sans'
])->loadView('pdf.leave_requests', compact('leaveRequests'));

        // عرض ملف الـ PDF في المتصفح
        return $pdf->stream('leave_requests.pdf');

        // أو يمكنك تحميل الملف مباشرة:
        // return $pdf->download('leave_requests.pdf');
    }
}
