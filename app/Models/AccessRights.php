<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessRights extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function dashboard()
    {
        return $this->hasOne(Dashboard::class, 'id', 'dashboard_id');
    }
}
