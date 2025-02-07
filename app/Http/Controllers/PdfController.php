<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; // تأكد من استيراد Facade الخاص بالمكتبة
use App\Models\LeaveRequest; // نموذج الطلبات (تأكد من صحة اسم الموديل)

class PdfController extends Controller
{
    public function generateLeaveRequestsPdf()
    {

        $leaveRequests = LeaveRequest::all();

    $pdf = Pdf::loadView('pdf.leave_requests', compact('leaveRequests'))
              ->setPaper('a4')
              ->setOption('isHtml5ParserEnabled', true)
              ->setOption('isFontSubsettingEnabled', true);

    return $pdf->stream('leave_requests.pdf');

        // جلب البيانات من قاعدة البيانات
      
    }
}
