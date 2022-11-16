<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Parameters;

class Devices extends Model
{
    use HasFactory;
    use HasUuids;
    protected $guarded = ['id', 'uuid'];
    public function newUniqueId()
    {
        return (string) Uuid::uuid4();
    }

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('created_at', 'like', '%' . $search . '%');
            });
        });
    }
    public function getRouteKeyName()
    {
        return 'uuid';
    }
    public function parameters()
    {
        return $this->hasMany(Parameters::class, 'device_id', 'id');
    }
}
