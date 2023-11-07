<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Image/logo.png')}}" />
    <link rel="stylesheet" href="{{ asset('CSS/cart.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
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
    <div class="container1">
        <div class="heading">
            <h1>
                <span class="shopper"></span> Nahinn Cart
            </h1>
        </div>
        <div class="cart transition is-open">
            <form action="{{route('customer.data')}}" method="get">
                @csrf
                <div class="table">
                    <div   div class="layout-inline row th">
                        <div class="col col-pro">Product</div>
                        <div class="col align-center">Color</div>
                        <div class="col align-center">Version</div>
                        <div class="col col-price align-center">Price</div>
                        <div class="col col-qty align-center">QTY</div>
                        <div class="col">Total</div>
                        <div class="col">Action</div>
                    </div>

                    @if (!empty($cart) && is_array($cart) && count($cart) > 0)
                        @php
                        $product_id=[];
                        $totalPrice = 0;
                        $cartQuantity = 0;
                        @endphp
                        @foreach($cart as $productId => $cartItem)
                            @php
                                $productIds[] = $productId; // Thêm product_id vào mảng
                            @endphp
                            @php
                            $cartQuantity += $cartItem['quantity'];
                            $product = DB::table('product')
                                ->select('product.product_id', 'product.product_name', 'attribute_value.price', 'product_data.URL as image')
                                ->join('product_attribute', 'product.product_id', '=', 'product_attribute.product_id')
                                ->join('attribute', 'product_attribute.attribute_id', '=', 'attribute.attribute_id')
                                ->join('attribute_value', 'attribute.attribute_id', '=', 'attribute_value.attribute_id')
                                ->join('product_data', 'product.product_id', '=', 'product_data.product_id')
                                ->where('product.product_id', $productId)
                                ->where('product_data.Loai_URL', 'img')
                                ->first();
                            @endphp

                            @if ($product)
                                @php
                                    $productTotal = $product->price * $cartItem['quantity'];
                                    $totalPrice += $productTotal;
                                @endphp  

                                <div class="layout-inline row" data-product-id="{{ $productId }}">
                                    @php
                                        $product_id[] = $productId; 
                                    @endphp
                                    <input type="hidden" name="product_id[] " value="{{$productId}}">
                                    <div class="col col-pro layout-inline">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" />
                                        <p>{{ $product->product_name }}</p>
                                    </div>
                                    <div class="col col-numeric align-center color" data-color-id="{{ $cart[$productId]['color_id'] }}">
                                        <p class="color">{{$cart[$productId]['color']}}</p>
                                        <input type="hidden" name="color_id" value="{{ $cart[$productId]['color_id'] }}">
                                    </div>
                                    <div class="col col-numeric align-center version" data-version-id="{{ $cart[$productId]['version_id'] }}">
                                        <p class="version">{{$cart[$productId]['version']}}</p>
                                        <input type="hidden" name="version_id" value="{{ $cart[$productId]['version_id'] }}">
                                    </div>
                                    <div class="col col-numeric align-center">
                                        <p id="price-product">{{$product->price}}$</p>
                                    </div>
                                    <div class="col col-qty layout-inline">
                                        <a href="#" class="qty qty-minus">-</a>
                                        <input type="numeric" value="{{ $cartItem['quantity'] }}" class="quantity"  id="quantity"/>
                                        <input type="hidden" name="hidden_quantity" id="quantity-hidden" value="">
                                        <a href="#" class="qty qty-plus">+</a>
                                    </div>

                                    <div class="col col-numeric col-total p">
                                        <p class="productTotal" id="totalPrice">{{ $productTotal }}</p>
                                    </div>

                                    <div>
                                        <a href="{{ route('customer.delete', ['id' => $productId]) }}" class="btn btn-danger btn-delete-product" data-product-id="{{ $productId }}">Delete</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p>Your cart is empty.</p>
                    @endif
                    <div class="total-order">
                        <p>Tổng đơn hàng: <span id="cart-total" class="cartTotal"></span>$</p>
                        <input type="hidden" name="cart_total" id="cart-total-hidden" value="">
                        <button type="submit" class="btn btn-danger btn-delete-product btn-submit">Buy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
<script>
    function calculateProductTotal($productRow) {
        var priceText = $productRow.find('#price-product').text();
        var quantityText = $productRow.find('#quantity').val();
        var price = parseFloat(priceText.replace('$', ''));
        var quantity = parseInt(quantityText);
        $('#quantity-hidden').val(quantityText);
        if (!isNaN(price) && !isNaN(quantity)) {
            var productTotal = price * quantity;
            $productRow.find('.col-total p').text(productTotal.toFixed(2) + '$');
            calculateCartTotal();
        } else {
            console.log("Giá hoặc số lượng không hợp lệ.");
        }
    }
    function calculateCartTotal() {
        var cartTotal = 0;
        $('.col-total p').each(function() {
            cartTotal += parseFloat($(this).text().replace('$', ''));
        });
        document.getElementById('cart-total-hidden').value = cartTotal.toFixed(2);
        $('#cart-total-hidden').val(cartTotal.toFixed(2));
        $('#cart-total').text(cartTotal.toFixed(2) + '$');
    }

    calculateCartTotal();

    $('a.qty-minus, a.qty-plus').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $productRow = $this.closest('.layout-inline.row');
        var $quantityInput = $productRow.find('#quantity');
        var currentQuantity = parseInt($quantityInput.val());
        if ($this.hasClass('qty-minus') && currentQuantity > 0) {
            $quantityInput.val(currentQuantity - 1);
        } else if ($this.hasClass('qty-plus')) {
            $quantityInput.val(currentQuantity + 1);
        }

        calculateProductTotal($productRow);
    });

    $('input.quantity').on('blur', function() {
        var input = $(this);
        var $productRow = input.closest('.layout-inline.row');
        calculateProductTotal($productRow);
    });
    $('.quantity').on('input', function() {
        var quantity = $(this).val();
        $('#quantity-hidden').val(quantity);
    });

    $('.quantity').on('input', function() {
        var quantity = $(this).val();
        $('#quantity-hidden').val(quantity);

        var hiddenQuantity = document.getElementById('quantity-hidden').value;
        console.log(hiddenQuantity);
    });
</script>

</html>