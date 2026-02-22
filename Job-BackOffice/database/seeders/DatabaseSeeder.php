<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate([
            'email' => 'admin@wazzafny.com',
        ], [
            'name' => 'Admin',
            'email' => 'admin@wazzafny.com',
            'password' => Hash::make('123456789'),
            'role' => 'admin',
            'email_verified_at' => now(),

        ]);

        $jobdata=json_decode(file_get_contents(database_path('data/job_data.json')), true);


        foreach ($jobdata['jobCategories'] as $jobCategory) {
            JobCategory::firstOrCreate([
                'name' => $jobCategory,
            ]);
        }

        //companies

        foreach ($jobdata['companies'] as $company) {
            //create company owner
            $owner = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('123456789'),
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);

        Company::firstOrCreate([
                'name' => $company['name'],
            ], [
                'address' => $company['address'],
                'website' => $company['website'],
                'industry' => $company['industry'],
                'owner_id' => $owner->id,
            ]);
        }

        //job vacancies

        foreach ($jobdata['jobVacancies'] as $jobVacancy) {
            $company = Company::where('name', $jobVacancy['company'])->firstOrFail();
            $category = JobCategory::where('name', $jobVacancy['category'])->firstOrFail();
                JobVacancy::firstOrCreate([
                    'title' => $jobVacancy['title'],
                    'category_id' => $category->id,
                ], [
                    'description' => $jobVacancy['description'],
                    'location' => $jobVacancy['location'],
                    'type' => $jobVacancy['type'],
                    'company_id' => $company->id,
                    'salary' => $jobVacancy['salary'],
                    
                ]);
            
        }

        // Job Applications
        $applicationData = json_decode(file_get_contents(database_path('data/job_applications.json')), true);
        $jobVacancies = JobVacancy::all();
        
        if (!empty($applicationData['jobApplications']) && $jobVacancies->isNotEmpty()) {
            foreach ($applicationData['jobApplications'] as $application) {
                // Create job seeker user
                $jobSeeker = User::firstOrCreate([
                    'email' => fake()->unique()->safeEmail(),
                ], [
                    'name' => fake()->name(),
                    'password' => Hash::make('123456789'),
                    'role' => 'job-seeker',
                    'email_verified_at' => now(),
                ]);

                // Get random job vacancy
                $vacancy = $jobVacancies->random();
                
                JobApplication::firstOrCreate([
                    'user_id' => $jobSeeker->id,
                    'job_vacancy_id' => $vacancy->id,
                ], [
                    'status' => $application['status'],
                    'aiGeneratedScore' => $application['aiGeneratedScore'],
                    'aigeneratedFeedback' => $application['aiGeneratedFeedback'],
                ]);
            }
        }
    }


}
