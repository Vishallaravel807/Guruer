@extends('front.layouts.layout')

@section('content')
<style>
    .language-list {
    list-style-type: none; /* Removes default bullet points */
    padding: 0; /* Removes default padding */
    margin: 0; /* Removes default margin */
    display: flex; /* Makes the list items display in a row */
    gap: 10px; /* Adds space between list items */
}

.language-list li {
    background-color: #f0f0f0; /* Adds a light gray background */
    padding: 5px 10px; /* Adds padding inside each list item */
    border-radius: 4px; /* Rounds the corners */
    font-size: 14px; /* Adjusts font size */
}
</style>


<div class="banner-tailors">
<div class="container browse-tailors">
  <div class="row browse-content">
    <h1 class="text-white">All Guruer</h1>
  </div>
</div>
</div>

<div class="shop-area mt-5 mb-5">
            <div class="container">
                <div class="row flex-row-reverse">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <div class="shop-page-wrap">
                            <div class="shop-top-bar">
                                <div class="shop-sorting-area">
                                    <select class="nice-select nice-select-style-2">
                                        <option>Default Sorting</option>
                                        <option>Sort by popularity</option>
                                        <option>Sort by average rating</option>
                                        <option>Sort by latest</option>
                                    </select>
                                </div>
                            </div>
                            <div class="padding-54-row-col">
                                <div class="row">
                                    @foreach($allUsers as $key => $value)
                                    <div class="card mb-5">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <a href="{{url('/guruerDetail ,$value->id')}}" >
                                                   
                                                   <img class="img-fluid" src="{{url('public/admin/uploads/user',$value->profile_image)}}" alt="myimage">
                                                   </a>
                                                </div>
                                                <div class="col-md-10">
                                                <div class="d-flex justify-content-center justify-content-between">
                                                    <div>
                                                    <h3><a href="{{url('/guruerDetail',$value->id)}}">{{@$value->first_name}}</a></h3>
                                                    <p>Languages:</p>
                                                    
                                                    <ul class="language-list">
                                                        @foreach($userLanguages as $lang)
                                                        @if(@$value->id == @$lang->user_id)
                                                        <li>{{@$lang->language_name}}</li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                    </div>
                                                    <div>
                                                        <h4>$40</h4>
                                                        <button class="btn btn-sm btn-primary">Buy Now</button>
                                                    </div>
                                                </div>

                                                </div>
                                            </div>

                                        
                                        </div>
                                    </div>
                                    @endforeach

     
                                </div>
                            </div>
                            <div class="pagination-style text-center mt-30">
                                <ul>
                                    <li><a class="active" href="#">01</a></li>
                                    <li><a href="#">02</a></li>
                                    <li><a href="#">03</a></li>
                                    <li><a href="#">04</a></li>
                                    <li><a href="#">05</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
            </div>
        </div>


@endsection