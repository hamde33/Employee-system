<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use Carbon\Carbon;

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
        if (auth()->user()->role !== 'admin') {
            $leaveTypes  = LeaveType::all();

        }
        else {
            $leaveTypes  = LeaveType::where('employee_number', auth()->user()->id)->get();
        }
        $leaveRequests = LeaveRequest::with('employee','leaveType')
            ->orderBy('id', 'desc')
            ->get();
        $employees   = Employee::all();
        
         return view('livewire.leave-request-component', [
            'leaveRequests' => $leaveRequests,
            'employees'     => $employees,
            'leaveTypes'    => $leaveTypes,
        ])->layout('layouts.app'); // <-- دمج layout هنا
    }
    public function store()
    {
        // إذا المستخدم ليس إداريًا، نجعل employee_id = Auth::id()
        if (auth()->check() && auth()->user()->role !== 'admin') {
            $this->employee_id = auth()->id();
        }
    
        // التحقق من المدخلات
        $this->validate();
    
        // منع التداخل - اختياري
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
    
        // إعادة ضبط المدخلات
        $this->resetInputs();
    
        // رسالة نجاح
        session()->flash('message', 'تم إضافة طلب الإجازة بنجاح!');
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
        if (auth()->check() && auth()->user()->role !== 'admin') {
            $this->employee_id = auth()->id();
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
