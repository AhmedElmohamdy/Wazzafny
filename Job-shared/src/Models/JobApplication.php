<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends Model
{
    use SoftDeletes, HasUuids, HasFactory;

    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aigeneratedFeedback',
        'user_id',
        'resume_id',
        'job_vacancy_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }
}
