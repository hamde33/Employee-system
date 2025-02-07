### **README for Leave Management System (Laravel Application)**

---

## **Project Overview**
The Leave Management System is a web application built with Laravel. It helps manage leave requests in organizations by allowing employees to submit leave requests and administrators to manage and approve or reject those requests. The application supports multi-user roles and provides essential leave management features.

---

## **Requirements**
- **PHP** >= 8.0
- **Composer** >= 2.0
- **Laravel** >= 10
- **MySQL** or other supported database
- **Node.js** (for front-end assets with Vite)
- **npm** >= 7

---

## **Installation Steps**

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd leave-management-system
   ```

2. **Install dependencies using Composer:**
   ```bash
   composer install
   ```

3. **Install front-end dependencies:**
   ```bash
   npm install
   npm run dev
   ```

4. **Configure the `.env` file:**
   - Copy `.env.example` to `.env`.
   ```bash
   cp .env.example .env
   ```
   - Update database and other configurations in the `.env` file.

5. **Generate the application key:**
   ```bash
   php artisan key:generate
   ```

6. **Run the database migrations:**
   ```bash
   php artisan migrate
   ```

7. **Seed the database (optional):**
   ```bash
   php artisan db:seed
   ```

8. **Start the server:**
   ```bash
   php artisan serve
   ```

---

## **Main Features**

1. **User Management**
   - Login/Logout functionality.
   - Role-based access control (Admin and Employee).

2. **Employee Management**
   - Add, edit, and delete employees.

3. **Leave Request Management**
   - Employees can submit leave requests.
   - Administrators can approve, reject, or modify requests.

4. **Request Status**
   - Pending, Approved, or Rejected.

5. **PDF Export**
   - Generate PDF reports of leave requests.

---

## **Project Structure**

### **Routes**
- **Public Routes:**
  - `/login` – User login page.
  - `/home` – Home dashboard.

- **Admin Routes:**
  - `/employees` – Employee management page.
  - `/leave-requests` – Leave request management page.

---

### **Core Components**

#### **Controllers**
- **UserController**: Handles user operations such as creating and managing users.
- **LeaveRequestController**: Manages leave requests and PDF export.

#### **Livewire Components**
- **EmployeeComponent**: Manages employee data.
- **LeaveRequestComponent**: Manages leave requests and interactions.

#### **Database**
- **Tables**: 
  - `users` – Stores user accounts.
  - `employees` – Stores employee information.
  - `leave_requests` – Stores leave request data.
  - `leave_types` – Stores leave types.

---

## **Usage Instructions**

### **For Employees**
1. Log in using employee credentials.
2. Submit a leave request.
3. Monitor the status of requests (pending, approved, or rejected).

### **For Administrators**
1. Log in using admin credentials.
2. Manage leave requests (approve, reject, or edit).
3. Add new employees and manage user accounts.
4. Export leave request reports to PDF.

---

## **Important Commands**

- **Update dependencies:**
  ```bash
  composer update
  npm update
  ```

- **Run Vite for asset development:**
  ```bash
  npm run dev
  ```

- **Run language translation (if using localization):**
  ```bash
  php artisan lang:publish
  ```

---

## **Additional Features**

- **PDF Export**:
  - Ensure the `dompdf` package is installed:
    ```bash
    composer require barryvdh/laravel-dompdf
    ```

- **Localization (Multi-language Support)**:
  - Add language files in `resources/lang` for different languages.

---

## **Contribution**

Feel free to contribute by forking the project and submitting pull requests. Follow Laravel's coding guidelines and ensure your code is tested before submission.

---

## **Support**

For technical support or bug reports, please open an issue in the project repository.

---

## **License**

This project is open-source and available under the **MIT License**. See the `LICENSE` file for more details.