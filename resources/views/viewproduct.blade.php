<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Image/logo.png')}}" />
    <link rel="stylesheet" href="{{ asset('CSS/viewproduct.css') }}">
</head>

<body>
    <header class="header">
        <div class="container header__container">
            <div class="header__logo">
                <img class="header__img" src="{{asset('Image/logo.png')}}">
                <h1 class="header__title">Nahinn<span class="header__light">.com</span></h1>
            </div>
            <div class="header__menu">
                <nav id="navbar" class="header__nav collapse">
                    <ul class="header__elenco">
                        <li class="header__el"><a href="{{route('homepage')}}" class="header__link">Home</a></li>
                        <li class="header__el header__el--category">
                            <a href="#" class="header__link" id="category-link">Category</a>
                            <ul class="category-list" id="category-list">
                                @foreach ($categories as $category)
                                <li class="header__el">
                                    <a href="#" class="header__link">{{ $category->category_name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="header__el"><a href="{{route('customer.cart')}}" class="header__link">Cart</a></li>
                        <li class="header__el"><a href="{{route('contact')}}" class="header__link">Contact us</a></li>
                        @if(auth()->check())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn--white">Logout →</button>
                        </form>
                        @else
                        <li class="header__el header__el--blue"><a href="{{ route('login') }}" class="btn btn--white">Sign In →</a></li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <section aria-label="Main content" role="main" class="product-detail">
        <div>
            <div class="shadow">
                <div class="_cont detail-top">
                    <div class="cols">
                        <div class="left-col">
                            <div class="big">
                                <img id="big-image" src="{{ asset('storage/' . $product->image) }}" class="img" quickbeam="image">
                            </div>
                        </div>
                        <form action="{{route('customer.addtoCart', ['product_id'=>$product->product_id])}}" method="GET">
                            @csrf
                            <div class="right-col">
                                <input type="hidden" name="product_id" value="{{$product->product_id}}" id="product_id">
                                <h1 itemprop="name">{{$product->product_name}}</h1>
                                <label for="color">Select Color:</label>
                                <div class="radio-options">
                                    @foreach($Color as $color)
                                        <label>
                                            <input type="radio" name="color" value="{{ $color->attribute_value_id }}" class="color-radio">
                                            {{ $color->attribute_value_name }}
                                        </label>
                                    @endforeach
                                </div>

                                <label for="version">Select Version:</label>
                                <div class="radio-options">
                                    @foreach($Version as $version)
                                        <label>
                                            <input type="radio" name="version" value="{{ $version->attribute_value_id }}" class="version-radio">
                                            {{ $version->attribute_value_name }}
                                        </label>
                                    @endforeach
                                </div>

                                <div>
                                    <p>Price: <span id="productPrice">N/A</span></p>
                                </div>
                                <div class="btn-and-quantity-wrap">
                                    <div class="btn-and-quantity">
                                        <div class="spinner">
                                            <span class="btn minus" data-id="2721888517"></span>
                                            <input type="text" id="updates_2721888517" name="quantity" value="1" class="quantity-selector">
                                            <input type="hidden" id="product_id" name="product_id" value="2721888517">
                                            <span class="q">Qty.</span>
                                            <span class="btn plus" data-id="2721888517"></span>
                                        </div>
                                        <div id="AddToCart" quickbeam="add-to-cart">
                                            <button type="submit" class="btn-submit"><span id="AddToCartText">Add to Cart</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                    <div class="tabs">
                                        <div class="tab-labels">
                                            <span data-id="1" class="active">Info</span>
                                        </div>
                                        <div class="tab-slides">
                                            <div id="tab-slide-1" itemprop="description" class="slide active">
                                                <p>{{$product->description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
                <aside class="related">
                    <div class="_cont">
                        <h2 class="title">You might also like</h2>
                        <div class="box-product">
                            @foreach($products as $products)
                            <div class="row hind row--text-center ">
                                <div class="col-md-4 col-sm-4 price-box1 price-box--purple">
                                    <div class="price-box__wrap1">

                                        <div class="price-box__img1">
                                            <img class="img_box" src="{{ asset('storage/' . $products->image) }}" width="350px">
                                        </div>
                                        <h1 class="price-box__title1">
                                            {{ $products->product_name }}
                                        </h1>
                                        <p class="price-box__people1">
                                            {{ $products->category_name }}
                                        </p>
                                        <div class="price-box__btn">
                                            <a class="btn btn--purple btn--width" href="{{ route('product.show', ['id' => $products->product_id]) }}">Buy now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                </aside>
            </div>

    </section>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-xs-6">
                    <img class="footer__img" width="100px" src="{{asset('/Image/logo.png')}}">
                    <h1 class="footer__title">Nahinn<span class="footer__light">.com</span></h1>
                </div>
            </div>
        </div>
    </footer>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const minusButton = document.querySelector('.btn.minus');
    const plusButton = document.querySelector('.btn.plus');
    const quantityInput = document.querySelector('.quantity-selector');
    const colorRadios = document.querySelectorAll('.color-radio');
    const versionRadios = document.querySelectorAll('.version-radio');
    const productPrice = document.getElementById('productPrice');

    minusButton.addEventListener('click', function() {
        var currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > 1) {
            quantityInput.value = currentQuantity - 1;
            updateProductPrice();
        }
    });

    plusButton.addEventListener('click', function() {
        var currentQuantity = parseInt(quantityInput.value);
        quantityInput.value = currentQuantity + 1;
        updateProductPrice();
    });

    colorRadios.forEach(colorRadio => {
        colorRadio.addEventListener('change', updateProductPrice);
    });

    versionRadios.forEach(versionRadio => {
        versionRadio.addEventListener('change', updateProductPrice);
    });

    function updateProductPrice() {
        const selectedColor = document.querySelector('.color-radio:checked').value;
        const selectedVersion = document.querySelector('.version-radio:checked').value;

        fetch(`/get-product-price/${selectedColor}/${selectedVersion}`)
            
            .then(response => response.json())
            .then(data => {
                const price = parseFloat(data.price);
                const quantity = parseInt(quantityInput.value);
                const newProductPrice = price * quantity;
                productPrice.textContent = newProductPrice;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    updateProductPrice();
});
</script>

</html>