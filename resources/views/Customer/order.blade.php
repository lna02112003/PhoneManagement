<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Image/logo.png')}}" />
    <link rel="stylesheet" href="{{ asset('CSS/order.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <div id="invoiceholder">

        <div id="headerimage"></div>
        <div id="invoice" class="effect2">
            <div id="invoice-top">
                <div class="logo"></div>
                <div class="clientlogo"></div>
                <div class="info">
                    <div class="avatar">
                        <img src="{{ asset('storage/' . $cart['customer']['img']) }}">
                    </div>
                    <div class="data_info">
                        <h2>{{ $cart['customer']['first_name'] }} {{ $cart['customer']['middle_name'] }} {{ $cart['customer']['last_name'] }}</h2>
                        <p>{{ $cart['customer']['email'] }}</p>
                        <p>{{ $cart['customer']['phone'] }}</p>
                        <p>{{ $cart['customer']['address'] }}</p>
                    </div>
                </div>

                <div id="project">
                    <h2>Project Description</h2>
                    <p>Proin cursus, dui non tincidunt elementum, tortor ex feugiat enim, at elementum enim quam vel purus. Curabitur semper malesuada urna ut suscipit.</p>
                </div>
            </div><!--End InvoiceTop-->

            <div id="invoice-bot">
                <div id="table">
                    <table>
                        <tr class="tabletitle">
                            <td class="item">
                                <h2>Product Name</h2>
                            </td>
                            <td class="Hours">
                                <h2>Image</h2>
                            </td>
                            <td class="Hours">
                                <h2>Color</h2>
                            </td>
                            <td class="Rate">
                                <h2>Version</h2>
                            </td>
                            <td class="Hours">
                                <h2>Price</h2>
                            </td>
                            <td class="Hours">
                                <h2>Quantity</h2>
                            </td>
                            <td class="subtotal">
                                <h2>Sub-total</h2>
                            </td>
                        </tr>
                        @if (!empty($cart) && is_array($cart) && count($cart) > 0)
                            @foreach($cart as $cartItem)
                                @php
                                $productId = $cartItem['productId'];
                                $product = DB::table('product as p')
                                            ->select('p.product_name', 'pd.URL as image')
                                            ->join('product_data as pd', 'pd.product_id', '=', 'p.product_id')
                                            ->where('p.product_id', $productId)
                                            ->first();
                                @endphp
                                @if ($product)
                                    <tr class="service">
                                        <td class="tableitem">
                                            <p class="itemtext">{{ $product->product_name }}</p>
                                        </td>
                                        <td class="tableitem">
                                            <p class="itemtext"><img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" /></p>
                                        </td>
                                        <td class="tableitem">
                                            <p class="itemtext"></p>
                                        </td>
                                        <td class="tableitem">
                                            <p class="itemtext"></p>
                                        </td>
                                        <td class="tableitem">
                                            <p class="itemtext"></p>
                                        </td>
                                        <td class="tableitem">
                                            <p class="itemtext"></p>
                                        </td>
                                        <td class="tableitem">
                                            <p class="itemtext"></p>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <p>Your order is empty.</p>
                        @endif
                        
                        <tr class="tabletitle">
                            <td></td>
                            <td></td>
                            <td class="Rate">
                                <h2>Total</h2>
                            </td>
                            <td class="payment">
                                <h2>$3,644.25</h2>
                            </td>
                        </tr>

                    </table>
                </div><!--End Table-->

                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="QRZ7QTM9XRPJ6">
                    <input type="image" src="http://michaeltruong.ca/images/paypal.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                </form>


                <div id="legalcopy">
                    <p class="legal"><strong>Thank you for your business!</strong>  Payment is expected within 31 days; please process this invoice within that time. There will be a 5% interest charge per month on late invoices.
                    </p>
                </div>

            </div><!--End InvoiceBot-->
        </div><!--End Invoice-->
    </div><!-- End Invoice Holder-->
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

</html>