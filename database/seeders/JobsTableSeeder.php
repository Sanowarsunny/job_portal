<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobTitles = [
            'Software Engineer',
            'Web Developer',
            'Data Analyst',
            'UI/UX Designer',
            'Project Manager',
            'Marketing Specialist',
            'Accountant',
            'HR Manager',
            'Sales Representative',
            'Customer Support Specialist',
            'Graphic Designer',
            'Network Administrator',
            'Content Writer',
            'Financial Analyst',
            'Business Analyst',
            'System Administrator',
            'Digital Marketing Manager',
            'Product Manager',
            'Quality Assurance Engineer',
            'Operations Manager'
        ];

        // Shuffle the job titles array
        shuffle($jobTitles);

        // Loop to insert 20 job records
        for ($i = 0; $i < 20; $i++) {
            DB::table('jobs')->insert([
                'title' => $jobTitles[$i],
                'user_id' => rand(1, 5), // Assuming you have 10 users, adjust this according to your setup
                'category_id' => rand(1, 5), // Assuming you have 5 categories, adjust this according to your setup
                'job_type_id' => rand(1, 3), // Assuming you have 3 job types, adjust this according to your setup
                'vacancy' => rand(1, 10),
                'salary' => rand(30000, 80000), // Random salary between 30000 and 80000
                'location' => 'Location ' . $i,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'benefits' => 'Health insurance, flexible working hours',
                'responsibility' => 'Developing new features, fixing bugs',
                'qualifications' => 'Bachelor\'s degree in Computer Science',
                'keywords' => 'Keyword1, Keyword2, Keyword3',
                'experience' => '2-5 years',
                'company_name' => 'Company ' . $i,
                'company_location' => 'Location ' . $i,
                'company_website' => 'http://example.com',
                'status' => 1,
                'isFeatured' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
