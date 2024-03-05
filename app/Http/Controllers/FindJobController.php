<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class FindJobController extends Controller
{
    
    public function findJobPage(){
        $categories = Category::where('status',1)->get();
        $jobType = JobType::where('status',1)->get();

        $jobs = Job::where('status',1)
                        ->orderBy('created_at','DESC')
                        ->paginate(4);  

        return view('front.findJobPage',[
            'categories'=>$categories,
            'jobType'=>$jobType,
            'jobs'=>$jobs,
        ]);
        
    }
}
