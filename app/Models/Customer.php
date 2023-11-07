<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model implements Authenticatable
{
    use HasFactory;

    protected $table = 'customer';
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'email',
        'phone',
        'address',
        'img',
        'password',
        'created_at',
        'updated_at',
    ];
    public function getAuthIdentifierName()
    {
        return 'customer_id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        // Phương thức lấy thông tin ghi nhớ phiên
    }

    public function setRememberToken($value)
    {
        // Phương thức thiết lập thông tin ghi nhớ phiên
    }

    public function getRememberTokenName()
    {
        // Phương thức trả về tên trường chứa thông tin ghi nhớ phiên
    }
}
