<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;


class JobVacancy extends Model
{
    use HasFactory , HasUuids , SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'views',
        'company_id',
        'category_id',
    ];

    protected function casts(): array
    {
        return [
          'deleted_at' => 'datetime',
        ];
    }

    protected $dates = ['deleted_at'];
    protected $table = 'job_vacancies';

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class);
    }
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

}
