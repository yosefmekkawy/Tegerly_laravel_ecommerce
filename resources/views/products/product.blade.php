@extends('layout')
@section('content')
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <div class="images-container row">
                        <img
                            class="card-img-top mb-5 mb-md-0 col-12 main-img"
                            src="{{asset($product['images']->isEmpty() ? 'images/placeholder.png' : 'images/'.$product['images'][0]->name)}}"
                            alt="..."
                        />
                        <div class="mini-images col-12 row g-3 flex-wrap">
                            @foreach($product['images'] as $image )
                                <div class="mini_img col-3">
                                    <img src="{{asset('images/'.$image->name)}}" alt="mini" style="width: 100%;height: 100px;object-fit: contain">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <h1>{{ $product['title'] }}</h1>
                    <h1 class="text-decoration">{{__('pages.price').': $'.$product['price']}}</h1>
                    </div>

                    <p class="lead text-center mt-5">
                        {{ $product['description'] }}
                    </p>

                    <!-- Add to Cart Form -->
                    <div class="row">
                        <form action="{{ route('cart.add', $product['id']) }}" method="post" class="cart row g-3">
                            @csrf
                            <div class="d-flex gap-3 align-items-center">
                                <span>Quantity: </span>
                                <input
                                    class="form-control text-center me-3"
                                    name="quantity"
                                    type="number"
                                    value="1"
                                    style="max-width: 4rem"
                                />
                            </div>

                            <button class="btn btn-outline-dark flex-shrink-0 add-cart">
                                <i class="ri-shopping-cart-line"></i>
                                Add to cart
                            </button>
                        </form>
                    </div>

                    @if($canReview)
                        <div class="mt-5">
                            <h4>Leave a Review</h4>
                            <form action="{{ route('reviews.store', $product['id']) }}" method="post">
                                @csrf
                                <div class="form-group text-center">
                                    <label for="rating">Rating</label>
                                    <select name="rating" id="rating" class="form-control" required>
                                        <option value="">Select Rating</option>
                                        <option value="5">5 - Excellent</option>
                                        <option value="4">4 - Good</option>
                                        <option value="3">3 - Average</option>
                                        <option value="2">2 - Below Average</option>
                                        <option value="1">1 - Poor</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="review_message">Review</label>
                                    <textarea name="review_message" id="review_message" class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Submit Review</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-5 text-center">
                <h3 class="text-center mt-5">Customer Reviews</h3>
                @forelse($product['reviews'] as $review)
                    <div class="review p-3 mb-3 border rounded">
                        <p><strong>{{ optional($review->user)->name }}</strong> rated {{ $review->rating }} / 5</p>
                        <p>{{ $review->review_message }}</p>
                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                    </div>
                @empty
                    <p>No reviews yet. Be the first to review this product!</p>
                @endforelse
            </div>


    </section>
@endsection

@section('styling')

    <style>
        .main-img {
            height: 400px;
            object-fit: contain;
        }
    </style>
@endsection

@section('scripts')
    <script>
        let mainImg = document.querySelector('.main-img');
        let miniImgs = document.querySelectorAll('.mini_img img');
        miniImgs.forEach(function(image) {
            image.addEventListener('mouseover', function() {
                mainImg.src = image.src;
            });
        });

        let addToCart = document.querySelector('.add-cart');
        let cartForm = document.querySelector('form .cart');
        addToCart.addEventListener('click', function() {
            cartForm.submit();
            window.location.reload();
        });
    </script>
@endsection
