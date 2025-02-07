<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // لاستخدام الهاش لكلمة المرور
use Illuminate\Validation\Rule;
use Livewire\Component;

class UserController extends Controller
{
    // 1) عرض قائمة المستخدمين
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'ليس لديك صلاحية للوصول إلى هذه الصفحة!');
        }
        // جلب جميع المستخدمين بشكل مرتب
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('users.index', [
            'users' => $users,
       
        ]);
    }
 
    // 2) صفحة إضافة مستخدم جديد
    public function create()
    {
        return view('users.create')->layout('layouts.app');
    }

    // 3) حفظ المستخدم الجديد في قاعدة البيانات
    public function store(Request $request)
    {
        // التحقق من البيانات
        // نجمع قواعد المستخدم + الموظف
        $request->validate([
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:6',
            'role'            => 'nullable|string',
            
            // حقول الموظف
            'employee_name'   => 'required|string|max:100',
            'employee_number' => 'required|string|unique:employees,employee_number',
            'mobile_number'   => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'notes'           => 'nullable|string',
        ]);
    
        // 1) إنشـاء المستخدم
        $user = User::create([
            'email'    => $request->email,
            'name'   => $request->employee_name,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'employee',
            // إذا أردت حفظ الاسم في user أيضاً، يمكنك إضافة حقل name في النموذج.
        ]);
    
        // 2) إنشـاء الموظف
        // إذا لديك حقل user_id في employees املأه كي يرتبط الموظف بهذا المستخدم
        $employee = \App\Models\Employee::create([
            'user_id'         => $user->id,
            'employee_name'   => $request->employee_name,
            'employee_number' => $request->employee_number,
            'mobile_number'   => $request->mobile_number,
            'address'         => $request->address,
            'notes'           => $request->notes,
        ]);
    
        // عودة لقائمة المستخدمين
        return redirect()->route('users.index')
                         ->with('success', 'تم إضافة المستخدم والموظف بنجاح!');
    }
    

    // 4) عرض مستخدم واحد (غير ضروري غالبًا في لوحة التحكم)
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user,
       
        ])->layout('layouts.app');
    }

    // 5) صفحة تعديل بيانات المستخدم
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // 6) حفظ التعديلات
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'role' => 'nullable|string'
        ]);

        // إذا تم إدخال حقل password، فقم بتحديثه
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role ?? $user->role
        ];

        if($request->filled('password')){
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
                         ->with('success', 'تم تعديل بيانات المستخدم بنجاح!');
    }

    // 7) حذف مستخدم
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
                         ->with('success', 'تم حذف المستخدم بنجاح!');
    }
}
