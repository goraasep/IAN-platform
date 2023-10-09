<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connections extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function topics()
    {
        return $this->hasMany(Topics::class, 'connection_id', 'id');
    }
}
