@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                @include('front.components.profile_sidenav')

                <div class="col-lg-9">
                    
                    @include("front.components.message")
                    
                    
                    <form action="{{ route('updatedJob',$job->id) }}" method="post">
                        @csrf
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Job Details</h3>


                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" value="{{ $job->title }}" placeholder="Job Title" id="title" name="title" class="form-control @error('title') is-invalid @enderror" >
                                        @error('title')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                            <option value="">Select a Category</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $item )
                                                    <option {{ ($job->category_id == $item->id)? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('category')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Type<span class="req">*</span></label>
                                        <select name="jobType" id="jobType" class="form-select @error('jobType') is-invalid @enderror" value="{{ old('jobType') }}">
                                            <option value="">Select a JobType</option>
                                            @if ($jobType->isNotEmpty())
                                                @foreach ($jobType as $item )
                                                    <option {{ ($job->job_type_id == $item->id)? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('jobType')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input value="{{ $job->vacancy }}" type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control @error('vacancy') is-invalid @enderror">
                                        @error('vacancy')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary</label>
                                        <input value="{{ $job->salary }}" type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                                    </div>
        
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location<span class="req">*</span></label>
                                        <input value="{{ $job->location }}" type="text" placeholder="location" id="location" name="location" class="form-control @error('location') is-invalid @enderror">
                                        @error('location')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="mb-4">
                                    <label for="" class="mb-2">Description</label>
                                    <textarea class="textarea @error('description') is-invalid @enderror" name="description" id="description" cols="5" rows="5" placeholder="Description">
                                        {{ $job->description }}
                                    </textarea>
                                    @error('description')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Benefits</label>
                                    <textarea class="textarea" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benefits }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Responsibility</label>
                                    <textarea  class="textarea" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Qualifications</label>
                                    <textarea class="textarea" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{ $job->qualifications }}</textarea>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="experience" class="mb-2">Experience</label>
                                    <select class="form-select" name="experience" id="experience">
                                        <option value="">Select Experience</option>
                                        @for ($i = 0; $i <= 10; $i++)
                                            <option {{ ($job->experience == $i) ? 'selected' : '' }} value="{{ $i }}">{{ $i }} years</option>
                                        @endfor
                                        <option {{ ($job->experience == '10+') ? 'selected' : '' }} value="10+">10+ years</option>
                                    </select>
                                </div>
                                
        
                                <div class="mb-4">
                                    <label for="" class="mb-2">Keywords</label>
                                    <input value="{{ $job->keywords }}" type="text" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                                </div>
        
                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>
        
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Name<span class="req">*</span></label>
                                        <input value="{{ $job->company_name }}" type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control @error('company_name') is-invalid @enderror">
                                        @error('company_name')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
        
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location</label>
                                        <input value="{{ $job->company_location }}" type="text" placeholder="Company location" id="company_location" name="company_location" class="form-control">
                                    </div>
                                </div>
        
                                <div class="mb-4">
                                    <label for="" class="mb-2">Website</label>
                                    <input value="{{ $job->website }}" type="text" placeholder="Website" id="website" name="website" class="form-control">
                                </div>
                            </div> 
                            <div class="card-footer  p-4">
                                <button class="btn btn-primary">Update Job</button>
                            </div>  
                        </form>             
                        </div>
                    
                        
                    

                </div>
            </div>
        </div>
    </section>
@endsection

