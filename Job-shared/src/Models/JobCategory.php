<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCategory extends Model
{
    use HasFactory , HasUuids , SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected function casts(): array
    {
        return [
          'deleted_at' => 'datetime',
        ];
    }

    protected $dates = ['deleted_at'];

    protected $table = 'job_categories';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'category_id' , 'id');
    }

}
