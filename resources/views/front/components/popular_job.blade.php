{{-- popular job --}}
<section class="section-2 bg-2 py-5">
    <div class="container">
        <h2>Popular Categories</h2>
        <div class="row pt-5">
            @if ($categories->isNotEmpty())

                @foreach ( $categories as $item )
                <div class="col-lg-4 col-xl-3 col-md-6">
                    <div class="single_catagory">
                        <a href="jobs.html"><h4 class="pb-2">{{ $item -> name }}</h4></a>
                        <p class="mb-0"> <span>0</span> Available position</p>
                    </div>
                </div>
                @endforeach
            @endif
            
            
        </div>
    </div>
</section>