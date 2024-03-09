<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobAppliedSaveController extends Controller
{
    public function jobApplyPage(){
        $jobApplications = JobApplication::where('user_id',Auth::user()->id)
                ->with(['job','job.jobType','job.applications'])
                ->orderBy('created_at','DESC')
                ->paginate(4);

        return view('backend.job.jobApplyPage',[
            'jobApplications' => $jobApplications
        ]);
    }

    public function removeAppliedJobs(Request $request){
        $jobApplication = JobApplication::where([
                                    'id' => $request->id, 
                                    'user_id' => Auth::user()->id]
                                )->first();
        
        if ($jobApplication == null) {
            session()->flash('error','Job application not found');
            return response()->json([
                'status' => false,                
            ]);
        }

        JobApplication::find($request->id)->delete();
        session()->flash('success','Job application removed successfully.');

        return response()->json([
            'status' => true,                
        ]);

    }

    public function saveJobPage(){
        // $jobApplications = JobApplication::where('user_id',Auth::user()->id)
        //         ->with(['job','job.jobType','job.applications'])
        //         ->paginate(10);

        $savedJobs = SavedJob::where([
            'user_id' => Auth::user()->id
        ])->with(['job','job.jobType','job.applications'])
        ->orderBy('created_at','DESC')
        ->paginate(10);

        return view('backend.job.saveJobPage',[
            'savedJobs' => $savedJobs
        ]);
    }

    public function removeSavedJob(Request $request){
        $savedJob = SavedJob::where([
                                    'id' => $request->id, 
                                    'user_id' => Auth::user()->id]
                                )->first();
        
        if ($savedJob == null) {
            session()->flash('error','Job not found');
            return response()->json([
                'status' => false,                
            ]);
        }

        SavedJob::find($request->id)->delete();
        session()->flash('success','Job removed successfully.');

        return response()->json([
            'status' => true,                
        ]);

    }
    
}
