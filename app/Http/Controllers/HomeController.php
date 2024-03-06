<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::where('status',1)->with('job')
                            ->orderBy('name','ASC')
                            ->take(10)->get();

        $featuredJob = Job::where('status',1)
                        ->where('isFeatured',1)
                        ->with('jobType')
                        ->orderBy('created_at','DESC')
                        ->take(10)->get();
        
        $latestJob = Job::where('status',1)
                        ->orderBy('created_at','DESC')
                        ->with('jobType')
                        ->take(10)->get();      
                    
        $newCategories = Category::where('status',1)->orderBy('name','ASC')->get();

        return view("front.home",[
            'categories'=>$categories,
            'featuredJob'=>$featuredJob,
            'latestJob'=>$latestJob,
            'newCategories' => $newCategories
        ]);
    }
}
