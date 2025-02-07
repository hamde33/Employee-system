<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'employee_name',
        'employee_number',
        'mobile_number',
        'address',
        'user_id',
        'notes',
    ];
    
    // علاقة بالطلبات
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
