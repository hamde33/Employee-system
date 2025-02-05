<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;

class EmployeeComponent extends Component
{
    // خصائص ستُربط بالفورم (بيانات النموذج)
    public $employee_id;
    public $employee_name;
    public $employee_number;
    public $mobile_number;
    public $address;
    public $notes;

    // للتحكم في وضعية (إضافة أم تعديل)
    public $updateMode = false;

    protected $rules = [
        'employee_name'   => 'required|string',
        'employee_number' => 'required|string|unique:employees,employee_number',
        'mobile_number'   => 'nullable|string',
        'address'         => 'nullable|string',
        'notes'           => 'nullable|string',
    ];

    // تُستدعى عند كل رندرة للصفحة
    public function render()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'ليس لديك صلاحية للوصول إلى هذه الصفحة!');
        }
        $employees = Employee::orderBy('id', 'desc')->get();
        return view('livewire.employee-component', compact('employees'));
    }

    // دالة الحفظ (إنشاء موظف جديد)
    public function store()
    {
        // التحقق
        $this->validate();

        Employee::create([
            'employee_name'   => $this->employee_name,
            'employee_number' => $this->employee_number,
            'mobile_number'   => $this->mobile_number,
            'address'         => $this->address,
            'notes'           => $this->notes,
        ]);

        // تفريغ الحقول بعد الحفظ
        $this->resetInputs();
        session()->flash('message', 'تم إضافة الموظف بنجاح!');
    }

    // تعبئة النموذج ببيانات الموظف عند الضغط على زر التعديل
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);

        $this->employee_id     = $employee->id;
        $this->employee_name   = $employee->employee_name;
        $this->employee_number = $employee->employee_number;
        $this->mobile_number   = $employee->mobile_number;
        $this->address         = $employee->address;
        $this->notes           = $employee->notes;

        $this->updateMode = true;
    }

    // حفظ التعديلات
    public function update()
    {
        // تحقّق من المدخلات
        // ملاحظة: عند التعديل يُفترض تعديل قاعدة unique حسب الـ ID
        $this->validate([
            'employee_name'   => 'required|string',
            'employee_number' => 'required|string|unique:employees,employee_number,'.$this->employee_id,
            'mobile_number'   => 'nullable|string',
            'address'         => 'nullable|string',
            'notes'           => 'nullable|string',
        ]);

        $employee = Employee::findOrFail($this->employee_id);
        $employee->update([
            'employee_name'   => $this->employee_name,
            'employee_number' => $this->employee_number,
            'mobile_number'   => $this->mobile_number,
            'address'         => $this->address,
            'notes'           => $this->notes,
        ]);

        $this->resetInputs();
        $this->updateMode = false;

        session()->flash('message', 'تم تعديل الموظف بنجاح!');
    }

    // حذف موظف
    public function delete($id)
    {
        Employee::destroy($id);
        session()->flash('message', 'تم حذف الموظف بنجاح!');
    }

    // دالة مساعدة لإعادة تعيين الخصائص بعد الحفظ أو التعديل
    private function resetInputs()
    {
        $this->employee_id = null;
        $this->employee_name = null;
        $this->employee_number = null;
        $this->mobile_number = null;
        $this->address = null;
        $this->notes = null;
    }
}
