<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // لاستخدام الهاش لكلمة المرور
use Illuminate\Validation\Rule;

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
        return view('users.index', compact('users'));
    }

    // 2) صفحة إضافة مستخدم جديد
    public function create()
    {
        return view('users.create');
    }

    // 3) حفظ المستخدم الجديد في قاعدة البيانات
    public function store(Request $request)
    {
        // التحقق من البيانات
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'nullable|string'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // تشفير كلمة المرور
            'role' => $request->role ?? 'employee' // مثال
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'تم إضافة المستخدم بنجاح!');
    }

    // 4) عرض مستخدم واحد (غير ضروري غالبًا في لوحة التحكم)
    public function show(User $user)
    {
        return view('users.show', compact('user'));
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
