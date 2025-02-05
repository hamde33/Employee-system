<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
    <!-- ربط Bootstrap CSS (مثال باستخدام CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- أي مراجع أخرى مثل Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* يمكنك إضافة بعض التعديلات إذا لزم الأمر */
        body {
            direction: rtl;
            text-align: right;
        }
        /* على سبيل المثال: تقليل الهوامش إذا كان العرض ضيق */
        .container {
            padding: 15px;
        }
    </style>
    <!-- تضمين تنسيقات Livewire -->
    @livewireStyles
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">نظام إدارة</a>
    <!-- زر توسيع/طي القائمة في الشاشات الصغيرة -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل القائمة">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <!-- مثال على رابط للموظفين -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('employees.index') }}">الموظفين</a>
        </li>

        <!-- رابط للمستخدمين (يظهر فقط في حال كان الدور admin) -->
        @if(Auth::check() && Auth::user()->role === 'admin')
          <li class="nav-item">
              <a class="nav-link" href="{{ route('users.index') }}">إدارة المستخدمين</a>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>

<!-- مكان حقن محتوى الـLivewire -->
<main class="container py-4">
    {{ $slot }}
</main>

<!-- Bootstrap JS (مثال باستخدام CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- تضمين سكربتات Livewire -->
@livewireScripts
</body>
</html>
