<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
     use HasFactory , HasUuids , SoftDeletes;


    protected $fillable = [
        'name',
        'address',
        'website',
       'industry',
       'owner_id',
    ];

    protected function casts(): array
    {
        return [
          'deleted_at' => 'datetime',
        ];
    }
    
    protected $dates = ['deleted_at'];
    protected $table = 'companies';

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class);
    }

    public function jobApplications()
{
    return $this->hasMany(JobApplication::class);
}
}
