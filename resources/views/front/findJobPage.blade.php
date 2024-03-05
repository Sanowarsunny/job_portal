@extends('front.layouts.app')

@section('main')

<section class="section-3 py-5 bg-2 ">
    <div class="container">     
        <div class="row">
            <div class="col-6 col-md-10 ">
                <h2>Find Jobs</h2>  
            </div>
            <div class="col-6 col-md-2">
                <div class="align-end">
                    <select name="sort" id="sort" class="form-control">
                        <option value="">Latest</option>
                        <option value="">Oldest</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <div class="card border-0 shadow p-4">
                    <div class="mb-4">
                        <h2>Keywords</h2>
                        <input type="text" placeholder="Keywords" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Location</h2>
                        <input type="text" placeholder="Location" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Category</h2>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category</option>
                            @if ($categories->isNotEmpty())
                                @foreach ($categories->unique('name') as $item )
                                 <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>                   

                    <div class="mb-4">
                        <h2>Job Type</h2>
                        @if ($jobType->isNotEmpty())
                            @foreach ($jobType->unique('name') as $item)
                                <div class="form-check mb-2"> 
                                    <input class="form-check-input" name="job_type" type="checkbox" value="{{ $item->id }}" id="job_type-{{ $item->id }}">    
                                    <label class="form-check-label" for="job_type-{{ $item->id }}">{{ $item->name }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    

                    <div class="mb-4">
                        <label for="experience" class="mb-2">Experience</label>
                        <select class="form-select" name="experience" id="experience">
                            <option value="">Select Experience</option>
                            @for ($i = 0; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }} years</option>
                            @endfor
                            <option value="10+">10+ years</option>
                        </select>
                    </div>                   
                </div>
            </div>
            <div class="col-md-8 col-lg-9 ">
                <div class="job_listing_area">                    
                    <div class="job_lists">
                        <div class="row">

                            @if ($jobs->isNotEmpty())

                                @foreach ( $jobs as $item )
                                    <div class="col-md-4">
                                        <div class="card border-0 p-3 shadow mb-4">
                                            <div class="card-body">
                                                <h3 class="border-0 fs-5 pb-2 mb-0">{{ ucwords($item->title) }}</h3>
                                                <p>{{ Str::words($item->description, 5) }}</p>
                                                <div class="bg-light p-3 border">
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                        <span class="ps-1">{{ ucwords($item->location) }}</span>
                                                    </p>
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                        <span class="ps-1">{{ $item->jobType->name }}</span>
                                                    </p>
                                                    @if (!$item->salary == 0)
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                            <span class="ps-1">{{ $item->salary }}</span>
                                                        </p>
                                                    @endif
                                                    
                                                </div>
            
                                                <div class="d-grid mt-3">
                                                    <a href="job-detail.html" class="btn btn-primary btn-lg">Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @else
                                    <div class="col-md-12">Jobs Not Found</div>
                            @endif
                                       
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
  
@endsection