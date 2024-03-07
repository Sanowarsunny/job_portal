<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function createJobPage(){

        $categories = Category::orderBy('name','ASC')->where('status',1)->get();
        $jobType = JobType::orderBy('name','ASC')->where('status',1)->get();

        return view('backend.job.createJob',[
            'categories'=>$categories,
            'jobType'=>$jobType,

        ]);
    }

    public function createJob(Request $request) {

        $rules = [
            'title' => 'required|min:3|max:50',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->passes()) {

            $job = new Job();
            $job->title = $request->title;
            $job->user_id = Auth::user()->id;

            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;

            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;

            $job->location = $request->location;
            $job->description = $request->description;

            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;

            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;

            $job->experience = $request->experience;
            $job->company_name = $request->company_name;

            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;

            $job->save();

            session()->flash('success','Job Created successfully.');

            return redirect()->route('myJobPage');
        } 
        else {
            // return response()->json([
            //     'errors' => $validator->errors(),
            //     'status' => false,
            // ]);
            return redirect()->route('createJobPage')
            ->withErrors($validator);
        }
    }

    public function myJobPage(){

        $id = Auth::user()->id;
        $jobs = Job::where('user_id',$id)->with('jobType')->orderBy('created_at','DESC')->paginate(10);

        return view('backend.job.myJobPage',[
            'jobs'=>$jobs,
        ]);
    }

    public function editJobPage(Request $request, $id) {

        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobType = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
    
        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $id
        ])->first();
    
        if ($job == null) {
            abort(404);
        }
    
        return view('backend.job.editJobPage', [
            'categories' => $categories,
            'jobType' => $jobType,
            'job' => $job
        ]);
    }
    

    public function updatedJob(Request $request,$id) {

        $rules = [
            'title' => 'required|min:3|max:50',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->passes()) {

            $job =  Job::find($id);
            $job->title = $request->title;
            $job->user_id = Auth::user()->id;

            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;

            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;

            $job->location = $request->location;
            $job->description = $request->description;

            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;

            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;

            $job->experience = $request->experience;
            $job->company_name = $request->company_name;

            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;

            $job->save();

            session()->flash('success','Job Updated successfully.');

            return redirect()->route('myJobPage');
        } 
        else {
            return redirect()->back()
            ->withErrors($validator);
        }
    }

    public function deleteJob(Request $request ,$id) {
        
        $job = Job::where([
        'user_id' => Auth:: user()->id,
        'id' => $id
        ])->first();

        if ($job == null) {
        session()->flash('error', 'Either job deleted or not found.');
        return redirect()->route('myJobPage');
        }
        Job::where('id', $id)->delete();
        session()->flash ('success', 'Job deleted successfully.');
        return redirect()->route('myJobPage');
    }
        
        
        
}


