<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobAdminController extends Controller
{
    public function jobPage() {
        $jobs = Job::orderBy('created_at','DESC')->with('user','applications')->paginate(10);
        return view('backend.admin.jobs.listPage',[
            'jobs' => $jobs
        ]);
    }

    public function jobEdit($id) {
        $job = Job::findOrFail($id);

        $categories = Category::orderBy('name','ASC')->get();
        $jobTypes = JobType::orderBy('name','ASC')->get();
        
        return view('backend.admin.jobs.editPage',[
            'job' => $job,
            'categories' => $categories,
            'jobTypes' => $jobTypes,
        ]);
    }

    public function jobUpdate(Request $request, $id) {

        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75',          

        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->passes()) {

            $job = Job::find($id);
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id  = $request->jobType;
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
            $job->company_website = $request->website;

            $job->status = $request->status;
            $job->isFeatured = (!empty($request->isFeatured)) ? $request->isFeatured : 0;
            $job->save();

            session()->flash('success','Job updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function jobDelete(Request $request) {
        $id = $request->id;

        $job = Job::find($id);

        if ($job == null) {
            session()->flash('error','Either job deleted or not found');
            return response()->json([
                'status' => false                
            ]);
        }

        $job->delete();
        session()->flash('success','Job deleted successfully.');
        return response()->json([
            'status' => true                
        ]);
    }


    //job application start

    public function jobApplicationsPage() {
        $applications = JobApplication::orderBy('created_at','DESC')    
                            ->with('job','user','employer')
                            ->paginate(10);
        return view('backend.admin.jobs.jobApplicationPage',[
            'applications' => $applications
        ]);
    }

    public function jobApplicationsDelete(Request $request){
        $id = $request->id;

        $jobApplication = JobApplication::find($id);

        if ($jobApplication == null) {
            session()->flash('error','Either job application deleted or not found.');
            return response()->json([
                'status' => false
            ]);
        }

        $jobApplication->delete();
        session()->flash('success','Job application deleted successfully.');
        return response()->json([
            'status' => true
        ]);

    }
}
