<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
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

  </div>
</nav>


<main class="container py-4">
@yield('content')
</main>

<!-- Bootstrap JS (مثال باستخدام CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- تضمين سكربتات Livewire -->
@livewireScripts
</body>
</html>
