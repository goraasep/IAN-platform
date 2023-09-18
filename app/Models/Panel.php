<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function parameter()
    {
        return $this->hasOne(Parameters::class, 'id', 'parameter_id');
    }
}
