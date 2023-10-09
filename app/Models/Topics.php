<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function connection()
    {
        return $this->hasOne(Connections::class, 'id', 'connection_id');
    }
}
