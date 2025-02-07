<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Auth;

class LeaveRequestComponent extends Component
{
    public $leave_request_id;
    public $employee_id;
    public $leave_type_id;
    public $from_date;
    public $to_date;
    public $reason;
    public $notes;
    public $status = 'pending';

    public $updateMode = false;

    protected $rules = [
        'employee_id'   => 'required|exists:employees,id',
        'leave_type_id' => 'required|exists:leave_types,id',
        'from_date'     => 'required|date|before:to_date',
        'to_date'       => 'required|date|after:from_date',
        'reason'        => 'nullable|string',
        'notes'         => 'nullable|string',
        'status'        => 'in:pending,approved,rejected',
    ];

    public function render()
    {

        // 1) جلب طلبات الإجازة حسب دور المستخدم
        if (Auth::user()->role === 'admin') {
            // الإداري يرى كل الطلبات
            $leaveRequests = LeaveRequest::with('employee','leaveType')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            // الموظف العادي: نعثر على سجله في جدول employees ثم نعرض طلباته
            $employee = Employee::where('user_id', Auth::id())->first();
            if (!$employee) {
                // إذا لم يعثر على سجل موظف لهذا المستخدم
                // يمكنك إمّا إظهار رسالة أو منع الوصول:
                abort(403, 'لم يتم العثور على سجل الموظف لهذا المستخدم.');
            }

            $leaveRequests = LeaveRequest::with('employee','leaveType')
                ->where('employee_id', $employee->id)
                ->orderBy('id', 'desc')
                ->get();
        }

        // 2) جلب أنواع الإجازات وقائمة الموظفين (إن احتجتها)
        //    في الغالب الإداري فقط من يحتاج employees لإضافة طلب بالنيابة
        $leaveTypes = LeaveType::all();
        $employees  = Employee::all();

        return view('livewire.leave-request-component', [
            'leaveRequests' => $leaveRequests,
            'employees'     => $employees,
            'leaveTypes'    => $leaveTypes,
        ])->layout('layouts.app');
    }


    public function store()
    {
        if (auth()->user()->role !== 'admin') {
            $employee = Employee::where('user_id', auth()->id())->first();
            $this->employee_id = $employee->id;
        }
        

        // إذا المستخدم موظف عادي، نجلب employee_id من سجل الموظف المرتبط بـ user_id
        if (Auth::check() && Auth::user()->role !== 'admin') {
            $employee = Employee::where('user_id', Auth::id())->first();
            if (!$employee) {
                abort(403, 'لم يتم العثور على سجل الموظف لهذا المستخدم.');
            }
            $this->employee_id = $employee->id;
        }
        
        // التحقق من المدخلات
        $this->validate();

        // منع التداخل (اختياري)
        $overlapExists = LeaveRequest::where('employee_id', $this->employee_id)
            ->where(function($query) {
                $query->whereBetween('from_date', [$this->from_date, $this->to_date])
                      ->orWhereBetween('to_date', [$this->from_date, $this->to_date])
                      ->orWhere(function ($subQuery) {
                          $subQuery->where('from_date', '<=', $this->from_date)
                                   ->where('to_date', '>=', $this->to_date);
                      });
            })
            ->exists();
        if ($overlapExists) {
            session()->flash('error', 'هناك إجازة متداخلة لهذا الموظف.');
            return;
        }

        // إنشاء طلب الإجازة
        LeaveRequest::create([
            'employee_id'   => $this->employee_id,
            'leave_type_id' => $this->leave_type_id,
            'from_date'     => $this->from_date,
            'to_date'       => $this->to_date,
            'reason'        => $this->reason,
            'notes'         => $this->notes,
            'status'        => $this->status,
        ]);

        $this->resetInputs();
        session()->flash('message', 'تم إضافة طلب الإجازة بنجاح!');
        return back();
    }

    public function edit($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        $this->leave_request_id = $leaveRequest->id;
        $this->employee_id      = $leaveRequest->employee_id;
        $this->leave_type_id    = $leaveRequest->leave_type_id;
        $this->from_date        = $leaveRequest->from_date;
        $this->to_date          = $leaveRequest->to_date;
        $this->reason           = $leaveRequest->reason;
        $this->notes            = $leaveRequest->notes;
        $this->status           = $leaveRequest->status;

        $this->updateMode = true;
    }

    public function update()
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            $employee = Employee::where('user_id', Auth::id())->first();
            if (!$employee) {
                abort(403, 'لم يتم العثور على سجل الموظف لهذا المستخدم.');
            }
            $this->employee_id = $employee->id;
        }

        $this->validate();

        $leaveRequest = LeaveRequest::findOrFail($this->leave_request_id);
        $leaveRequest->update([
            'employee_id'   => $this->employee_id,
            'leave_type_id' => $this->leave_type_id,
            'from_date'     => $this->from_date,
            'to_date'       => $this->to_date,
            'reason'        => $this->reason,
            'notes'         => $this->notes,
            'status'        => $this->status,
        ]);

        $this->resetInputs();
        $this->updateMode = false;

        session()->flash('message', 'تم تعديل طلب الإجازة بنجاح!');
        return back();

    }

    public function delete($id)
    {
        LeaveRequest::destroy($id);
        session()->flash('message', 'تم حذف طلب الإجازة!');
    }

    private function resetInputs()
    {
        $this->leave_request_id = null;
        $this->employee_id      = null;
        $this->leave_type_id    = null;
        $this->from_date        = null;
        $this->to_date          = null;
        $this->reason           = null;
        $this->notes            = null;
        $this->status           = 'pending';
        $this->updateMode       = false;
    }
}
