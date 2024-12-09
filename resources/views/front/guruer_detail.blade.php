@extends('front.layouts.layout') @section('content')
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
            <h1 class="text-white">Gurur Detail</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="row product-detail-page">
        <div class="col-lg-6 product-summary-left">
            <!-- Main Product Image -->
             
            <div class="main-product-image">
                <img id="main-product-image" src="{{url('public/admin/uploads/user',@$guruer->profile_image)}}" alt="Main Product" class="" />
            </div>

            <!-- Related Product Images -->
            <!-- <div class="related-product-images mt-3">
                <div class="row product-images-inner">
                @if(!empty($productImages) && count($productImages) > 0)
                @foreach($productImages as $index => $image)
                <div class="col-3 one related-product-one">
                        <a href="javascript:void(0);">
                            <img src="{{url('public/Productupload',$image->product_image)}}" alt="Related Product 1" class="related-product-img" />
                        </a>
                </div>
                @endforeach
                @else
                <p>No Images On Galary</p>
                @endif
                </div>
            </div> -->
        </div>

        <div class="col-lg-6 product-summary-right">
            <h1 class="product_title entry-title">{{@$guruer->first_name}}</h1>
            <p>Languages:</p>
                                                    
            <ul class="language-list">
                @foreach($userLanguages as $lang)
                @if(@$guruer->id == @$lang->user_id)
                <li>{{@$lang->language_name}}</li>
                @endif
                @endforeach
            </ul>
            <p class="price">$60</p>

        </div>
    </div>

 
    <div class="container related-products-list">
        <h1 class="inner-detail-pdc">Related GURUERS</h1>
   <img src="https://votivelaravel.in/tailor_hub/public/front_assets/images/Line.png">
        <div class="row related-products">
        @if(!empty($allUsers) && count($allUsers) > 0)
        @foreach($allUsers as $index => $value)
        <div class="col-md-3 col-sm-6 product-item">
                <div class="product-wrap">
                    <div class="product-img img-zoom">
                        <a href="{{url('/guruerDetail',$value->id)}}">
                            <img class="img-fluid w-100" src="{{url('public/admin/uploads/user',$value->profile_image)}}" alt="" />
                        </a>
                    </div>
                    <div class="product-content text-center">
                     <span class="review-rating">★★★★★</span>

                        <h3><a href="{{url('/guruerDetail',$value->id)}}">{{@$value->first_name}}</a></h3>
                        <div class="product-price">
                            <span>$60</span>
                                                

                        </div>
                    </div>
                </div>
        </div>
        @endforeach
        @else
        <p>No products available blogs this category</p>
        @endif


        </div>
    </div>


   <div class="row reviews-details">
        <div class="reviews-point">
            <h2>Customer Reviews</h2>

            <div class="review">
                <div class="review-header">
                    <strong>John Doe</strong>
                    <span class="review-rating">★★★★★</span>
                </div>
                <p class="review-comment">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

</p>
            </div>

            <div class="review">
                <div class="review-header">
                    <strong>Jane Smith</strong>
                    <span class="review-rating">★★★★☆</span>
                </div>
                <p class="review-comment">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.

</p>
            </div>

            <a href="#" class="see-all-reviews-btn">See All Reviews</a>
        </div>
    </div>

        </div>

    <script>
        // JavaScript to handle the click event
        document.querySelectorAll(".related-product-img").forEach((image) => {
            image.addEventListener("click", function () {
                const mainImage = document.getElementById("main-product-image");
                mainImage.src = this.src; // Update the main product image source
            });
        });
    </script>

    <script>
        (function () {
            const quantityContainer = document.querySelector(".quantity");
            const minusBtn = quantityContainer.querySelector(".minus");
            const plusBtn = quantityContainer.querySelector(".plus");
            const inputBox = quantityContainer.querySelector(".input-box");

            updateButtonStates();

            quantityContainer.addEventListener("click", handleButtonClick);
            inputBox.addEventListener("input", handleQuantityChange);

            function updateButtonStates() {
                const value = parseInt(inputBox.value);
                minusBtn.disabled = value <= 1;
                plusBtn.disabled = value >= parseInt(inputBox.max);
            }

            function handleButtonClick(event) {
                if (event.target.classList.contains("minus")) {
                    decreaseValue();
                } else if (event.target.classList.contains("plus")) {
                    increaseValue();
                }
            }

            function decreaseValue() {
                let value = parseInt(inputBox.value);
                value = isNaN(value) ? 1 : Math.max(value - 1, 1);
                inputBox.value = value;
                updateButtonStates();
                handleQuantityChange();
            }

            function increaseValue() {
                let value = parseInt(inputBox.value);
                value = isNaN(value) ? 1 : Math.min(value + 1, parseInt(inputBox.max));
                inputBox.value = value;
                updateButtonStates();
                handleQuantityChange();
            }

            function handleQuantityChange() {
                let value = parseInt(inputBox.value);
                value = isNaN(value) ? 1 : value;

                // Execute your code here based on the updated quantity value
                console.log("Quantity changed:", value);
            }
        })();
    </script>

    @endsection

