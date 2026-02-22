<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;


class Resume extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'file_name',
        'file_url',
        'contact_info',
        'education',
        'experience',
        'skills',
        'summary',
        'user_id',
        'cloudinary_public_id',
    ];

    protected function casts(): array
    {
        return [

            'contact_info' => 'array',  
            'skills' => 'array',        
            'experience' => 'array',    
            'education' => 'array',     
            'deleted_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
