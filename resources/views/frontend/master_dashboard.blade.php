<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/imgs/theme/favicon.svg') }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css?v=5.3') }}" />
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    @include('frontend.body.quicview')

    @include('frontend.body.header')

    <main class="main">
        @yield('main')
    </main>

    @include('frontend.body.footer')
    
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('frontend/assets/imgs/theme/loading.gif') }}" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS-->
    <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src="{{ asset('frontend/assets/js/main.js?v=5.3') }}"></script>
    <script src="{{ asset('frontend/assets/js/shop.js?v=5.3') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script>
	@if(Session::has('message'))
	var type = "{{ Session::get('alert-type','info') }}"
	switch(type){
		case 'info':
		toastr.info(" {{ Session::get('message') }} ");
		break;

		case 'success':
		toastr.success(" {{ Session::get('message') }} ");
		break;

		case 'warning':
		toastr.warning(" {{ Session::get('message') }} ");
		break;

		case 'error':
		toastr.error(" {{ Session::get('message') }} ");
		break; 
	}
	@endif 
	</script>

    <script type="text/javascript">
    
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })
        /// Start product view with Modal 

        function productView(id) {
            alert(id)
        }
        function productView(id){
        // alert(id)
            $.ajax({
                type: 'GET',
                url: '/product/view/modal/'+id,
                dataType: 'json',
                success:function(data){
                    //console.log(data)
                    
                    $('#productName').text(data.product.product_name);
                    $('#productPrice').text(data.product.selling_price);
                    $('#productCode').text(data.product.product_code);
                    $('#productCategory').text(data.product.category.product_category);
                    $('#productBrand').text(data.product.brand.brand_name);
                    $('#productImage').attr('src','/'+data.product.product_thumbnail);
                    $('#productVendorId').text(data.product.vendor_id);

                    $('#product_id').val(id);
                    $('#qty').val(1);

                    if (data.product.discount_price == null) {
                        $('#productPrice').text('');
                        $('#oldPrice').text('');
                        $('#productPrice').text(data.product.selling_price);
                        
                    } else {
                        $('#productPrice').text(data.product.discount_price);
                        $('#oldPrice').text(data.product.selling_price);
                    }

                    if (data.product.product_qty > 0) {
                        $('#aviable').text('');
                        $('#stockout').text('');
                        $('#aviable').text('aviable');
                    } else {
                        $('#aviable').text('');
                        $('#stockout').text('');
                        $('#stockout').text('stockout');                        
                    }

                    $('select[name="size"]').empty();
                    $.each(data.size,function(key,value){
                        $('select[name="size"]').append('<option value="'+value+' ">'+value+'  </option')
                        if (data.size == "") {
                            $('#sizeArea').hide();
                        }else{
                            $('#sizeArea').show();
                        }
                    })
                     
                    $('select[name="color"]').empty();
                    $.each(data.color,function(key,value){
                        $('select[name="color"]').append('<option value="'+value+' ">'+value+'  </option')
                        if (data.color == "") {
                            $('#colorArea').hide();
                        }else{
                            $('#colorArea').show();
                        }
                    })
                }
            })
        }

        //end product with modal

        //start add to cart product
        function addToCart(){
            var product_name = $('#productName').text();  
            var id = $('#product_id').val();
            var vendor = $('#productVendorId').text();
            var color = $('#color option:selected').text();
            var size = $('#size option:selected').text();
            var quantity = $('#quantity').val(); 
                $.ajax({
                    type: "POST",
                    dataType : 'json',
                    data:{
                        color:color, size:size, quantity:quantity,product_name:product_name, vendor:vendor
                    },
                    url: "/cart/data/store/"+id,
                    success:function(data){
                        miniCart()
                        $('#closeModal').click();
                        //console.log(data)


                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        if ($.isEmptyObject(data.error)) {
                            Toast.fire({
                                type: 'success',
                                title: data.success,
                            })
                        } else {
                            Toast.fire({
                                type: 'error',
                                title: data.error,
                            })
                        }
                            
                    }
                })
            }
        //end add to cart product


        //start detail page add to cart product
        function addToCartDetails(){
            var product_name = $('#dproductName').text();  
            var id = $('#dproduct_id').val();
            var vendor = $('#vproduct_id').val();
            var color = $('#dsize option:selected').text();
            var size = $('#dcolor option:selected').text();
            var quantity = $('#dquantity').val(); 
                $.ajax({
                    type: "POST",
                    dataType : 'json',
                    data:{
                        color:color, size:size, quantity:quantity,product_name:product_name, vendor:vendor
                    },
                    url: "/dcart/data/store/"+id,
                    success:function(data){
                        miniCart()
                        //console.log(data)


                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        if ($.isEmptyObject(data.error)) {
                            Toast.fire({
                                type: 'success',
                                title: data.success,
                            })
                        } else {
                            Toast.fire({
                                type: 'error',
                                title: data.error,
                            })
                        }
                            
                    }
                })
            }
            //end detail page add to cart product


    
    </script>

    <!--//mini cart-->
    <script type="text/javascript">
         function miniCart(){
                $.ajax({
                    type: 'GET',
                    url: '/product/mini/cart',
                    dataType: 'json',
                    success:function(response){
                    //console.log(response)

                    $('span[id="cartSubTotal"]').text(response.cartTotal);
                    $('#cartQty').text(response.cartQty);

                    var miniCart = ""
                    $.each(response.carts, function(key,value){
                        miniCart += ` <ul>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="shop-product-right.html"><img alt="Nest" src="/${value.options.image} " style="width:50px;height:50px;" /></a>
                                            </div>
                                            <div class="shopping-cart-title" style="margin: -73px 74px 14px; width" 146px;>
                                                <h4><a href="shop-product-right.html"> ${value.name} </a></h4>
                                                <h4><span>${value.qty} × </span>${value.price}</h4>
                                            </div>
                                            <div class="shopping-cart-delete" style="margin: -85px 1px 0px;">
                                                <a type="submit" id="${value.rowId}" onclick="miniCartRemove(this.id)"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li> 
                                    </ul> <hr><br> `
                        
                                });
                    $('#miniCart').html(miniCart);

                }
            })
        }

        miniCart();



        //MİNİ CART REMOVE START

        function miniCartRemove(rowId){
            $.ajax({
                type:'GET',
                url:'/minicart/product/remove/'+rowId,
                dataType:'json',
                success:function(data){
                    miniCart();

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            title: data.success,
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: data.error,
                        })
                    }
                }
            })
        }

        //MİNİ CART REMOVE END


    </script>
    <!--//mini cart-->


    <!--//wishlist start add-->
    <script type="text/javascript">
        
        function addToWishList(product_id){
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/add-to-wishlist/"+product_id,
                success:function(data){
                    wishlist();
                     // Start Message 
            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000 
            })
            if ($.isEmptyObject(data.error)) {
                    
                    Toast.fire({
                    type: 'success',
                    icon: 'success', 
                    title: data.success, 
                    })
            }else{
               
           Toast.fire({
                    type: 'error',
                    icon: 'error', 
                    title: data.error, 
                    })
                }
              // End Message  
                }
            })
        }
    </script>
    <!--//wishlist end add-->

    <!--//wishlist start add-->
    <script type="text/javascript">
        
        function wishlist(){
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/get-wishlist-product/",
                success:function(response){

                    $('#wishlistQuantity').text(response.wishlistQuantity);

                    var rows = ""
                    $.each(response.wishlist, function(key,value){
                    rows += `<tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                        
                                </td>
                                <td class="image product-thumbnail pt-40"><img src="/${value.product.product_thumbnail}" alt="#" /></td>
                                <td class="product-des product-name">
                                    <h6><a class="product-name mb-10" href="shop-product-right.html">${value.product.product_name} </a></h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">

                                    ${value.product.discount_price == null

                                    ? `<h3 class="text-brand">$${value.product.selling_price}</h3>`

                                    :`<h3 class="text-brand">$${value.product.discount_price}</h3>`

                                    }
                                        
                                </td>
                                
                                <td class="text-center detail-info" data-title="Stock">

                                    ${value.product.product_qty > 0 

                                        ? `<span class="stock-status in-stock mb-0"> In Stock </span>`
                                        
                                        :`<span class="stock-status out-stock mb-0">Stock Out </span>`
                                    } 
                               
                                </td>
                                
                                <td class="action text-center" data-title="Remove">
                                    <a type="submit" id="${value.id}" onclick="wishlistRemove(this.id)" class="text-body"><i class="fi-rs-trash"></i></a>
                                </td>
                            </tr> ` 
                    });

                $('#wishlist').html(rows);
                
                }
            })
        }

    wishlist();
    //wishlist end add-->

    //wishlist remove start   

    function wishlistRemove(id){
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/wishlist-remove/"+id,

                success:function(data){
                wishlist();   
                     // Start Message 
            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000 
            })
            if ($.isEmptyObject(data.error)) {
                    
                    Toast.fire({
                    type: 'success',
                    icon: 'success', 
                    title: data.success, 
                    })
            }else{
               
           Toast.fire({
                    type: 'error',
                    icon: 'error', 
                    title: data.error, 
                    })
                }
              // End Message  
                }
            })
        }
    
    //wishlist remove end 

    </script>

    <!--//coompare start add-->
    <script type="text/javascript">
        
        function addToCompare(product_id){
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/add-to-compare/"+product_id,
                success:function(data){
                     // Start Message 
            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000 
            })
            if ($.isEmptyObject(data.error)) {
                    
                    Toast.fire({
                    type: 'success',
                    icon: 'success', 
                    title: data.success, 
                    })
            }else{
               
           Toast.fire({
                    type: 'error',
                    icon: 'error', 
                    title: data.error, 
                    })
                }
              // End Message  
                }
            })
        }
    </script>
    <!--//coompare end add-->


    <!--//compare start add-->
    <script type="text/javascript">
        
        function compare(){
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/get-compare-product/",
                success:function(response){

                    var rows = ""
                    $.each(response, function(key,value){
                    rows += ` <tr class="pr_image">
                                    <td class="text-muted font-sm fw-600 font-heading mw-200">Preview</td>
                                    <td class="row_img"><img src="/${value.product.product_thumbnail}" style="width: 300px; height: 300px;" alt="compare-img" /></td>
                                </tr>
                                <tr class="pr_title">
                                    <td class="text-muted font-sm fw-600 font-heading">Name</td>
                                    <td class="product_name">
                                        <h6><a href="shop-product-full.html" class="text-heading">${value.product.product_name}</a></h6>
                                    </td>
                                </tr>
                                <tr class="pr_price">
                                    <td class="text-muted font-sm fw-600 font-heading">Price</td>
                                    <td class="product_price">
                                        ${value.product.discount_price == null

                                            ? `<h4 class="price text-brand">$${value.product.selling_price}</h4>`

                                            : `<h4 class="price text-brand">$${value.product.discount_price}</h4>`

                                        }
                                    </td>
                                </tr>
                                <tr class="description">
                                    <td class="text-muted font-sm fw-600 font-heading">Description</td>
                                    <td class="row_text font-xs">
                                        <p class="font-sm text-muted">${value.product.short_description}</p>
                                    </td>
                                </tr>
                                <tr class="pr_stock">
                                    <td class="text-muted font-sm fw-600 font-heading">Stock status</td>

                                        ${value.product.product_qty > 0 

                                            ? `<td class="row_stock"><span class="stock-status in-stock mb-0">In Stock</span></td>`

                                            : `<td class="row_stock"><span class="stock-status out-stock mb-0">Stock Out</span></td>`
                                        }

                                </tr>
                                <tr class="pr_remove text-muted">
                                    <td class="text-muted font-md fw-600"></td>
                                    <td class="row_remove">
                                        <a type="submit" id="${value.id}" onclick="compareRemove(this.id)" class="text-muted"><i class="fi-rs-trash mr-5"></i><span>Remove</span> </a>
                                    </td>
                                </tr> ` 
                    });

                $('#compare').html(rows);
                
                }
            })
        }

    compare();
    //compare end add-->

    //compare remove start   
    function compareRemove(id){
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/compare-remove/"+id,

                success:function(data){
                compare();   
                     // Start Message 
            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000 
            })
            if ($.isEmptyObject(data.error)) {
                    
                    Toast.fire({
                    type: 'success',
                    icon: 'success', 
                    title: data.success, 
                    })
            }else{
               
           Toast.fire({
                    type: 'error',
                    icon: 'error', 
                    title: data.error, 
                    })
                }
              // End Message  
                }
            })
        }
    
    //compare remove end 

    </script>


    <script type="text/javascript">
        //start load mycart
        function cart(){
                $.ajax({
                    type: 'GET',
                    url: '/get-cart-product',
                    dataType: 'json',
                    success:function(response){
                    //console.log(response)

                    var rows = ""
                    $.each(response.carts, function(key,value){
                        rows += `<tr class="pt-30">
                                    <td class="custome-checkbox pl-30">
                                        
                                    </td>
                                    <td class="image product-thumbnail pt-40"><img src="/${value.options.image}" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">${value.name}</a></h6>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-body">$${value.price} </h4>
                                    </td>

                                    <td class="price" data-title="Price">
                                        ${value.options.color == null
                                        ? `<span>....</span>`
                                        : `<h4 class="text-body">${value.options.color} </h4>`
                                        }
                                    </td>

                                    <td class="price" data-title="Price">
                                        ${value.options.size == null
                                        ? `<span>....</span>`
                                        : `<h4 class="text-body">${value.options.size} </h4>`
                                        }
                                    </td>

                                    <td class="text-center detail-info" data-title="Stock">
                                        <div class="detail-extralink mr-15">
                                            <div class="detail-qty border radius">
                                                <a type="submit" class="qty-down" id="${value.rowId}" onclick="cartDecrement(this.id)"><i class="fi-rs-angle-small-down"></i></a>

                                                <input type="text" name="quantity" class="qty-val" value="${value.qty}" min="1">
                                                
                                                <a type="submit" class="qty-up" id="${value.rowId}" onclick="cartIncrement(this.id)"><i class="fi-rs-angle-small-up"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-brand">$${value.subtotal} </h4>
                                    </td>
                                    <td class="action text-center" data-title="Remove"><a type="submit" id="${value.rowId}" onclick="cartRemove(this.id)" class="text-body"><i class="fi-rs-trash"></i></a></td>
                                </tr>`
                        });
                    $('#cartPage').html(rows);

                }
            })
        }

        cart();
        //end load mycart


        //mycart remove start   
        function cartRemove(id){
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: "/cart-remove/"+id,

                    success:function(data){
                    cart();
                    miniCart();
                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000 
                    })
                    if ($.isEmptyObject(data.error)) {
                            
                            Toast.fire({
                            type: 'success',
                            icon: 'success', 
                            title: data.success, 
                            })
                    }else{
                    
                Toast.fire({
                            type: 'error',
                            icon: 'error', 
                            title: data.error, 
                            })
                        }
                    // End Message  
                    }
                })
            }
        
        //mycart remove end 

        //cart increment start 
        function cartIncrement(rowId){
            $.ajax({
                type: "GET",
                url: "/cart-increment/"+rowId,
                dataType: 'json',
                success:function(data) {
                    couponCalculation();
                    cart();
                    miniCart();
                }
            });
        }
        //cart increment start 
        

        //cart decrement start 
        
        function cartDecrement(rowId){
            $.ajax({
                type: "GET",
                url: "/cart-decrement/"+rowId,
                dataType: 'json',
                success:function(data) {
                    couponCalculation();
                    cart();
                    miniCart();
                }
            });
        }
        
        //cart decrement end 

    </script>    


    <!-- START APPLY COUPON  -->

    <script type="text/javascript">

    function applyCoupon(){
            var coupon_name = $('#coupon_name').val();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    data: {coupon_name:coupon_name},
                    url: "/coupon-apply",
                    success:function(data){
                        couponCalculation();

                        if (data.validity == true) {
                            $('#couponField').hide();
                        }
                   
                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000 
                    })
                    if ($.isEmptyObject(data.error)) {
                            
                            Toast.fire({
                            type: 'success',
                            icon: 'success', 
                            title: data.success, 
                            })
                    }else{
                    
                Toast.fire({
                            type: 'error',
                            icon: 'error', 
                            title: data.error, 
                            })
                        }
                    // End Message  
                    }
                })
            }


    // Start Coupon Calculation Method 
    function couponCalculation(){
        $.ajax({
            type: 'GET',
            url: "/coupon-calculation",
            dataType: 'json',
            success:function(data){

                if (data.total) {

                    $('#couponCalField').html(
                        `<tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">Subtotal</h6>
                            </td>
                            <td class="cart_total_amount">
                                <h4 class="text-brand text-end">$${data.total}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col" colspan="2">
                                <div class="divider-2 mt-10 mb-10"></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">Grand Total</h6>
                            </td>
                            <td class="cart_total_amount">
                                <h4 class="text-brand text-end">$${data.total}</h4>
                            </td>
                        </tr>`
                    )
                    
                } else {

                    $('#couponCalField').html(
                        `<tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">Subtotal</h6>
                            </td>
                            <td class="cart_total_amount">
                                <h4 class="text-brand text-end">$${data.subtotal}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col" colspan="2">
                                <div class="divider-2 mt-10 mb-10"></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">Coupon</h6>
                            </td>
                            <td class="cart_total_amount">
                                <h6 class="text-brand text-end">${data.coupon_name}<a type="submit" onclick="couponRemove()"><i class="fi-rs-trash"></i></a></h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">Discount Amount</h6>
                            </td>
                            <td class="cart_total_amount">
                                <h4 class="text-brand text-end">$${data.discount_amount}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">Coupon</h6>
                            </td>
                            <td class="cart_total_amount">
                                <h4 class="text-brand text-end">$${data.total_amount}</h4>
                            </td>
                        </tr>`
                    )
                }
            }
        });
    }    
    
    couponCalculation();
    // End Coupon Calculation Method 

    </script>    

    <!-- END APPLY COUPON  -->

    <script type="text/javascript">
        //coupon remove start   
            function couponRemove(){
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: "/coupon-remove",

                    success:function(data){

                    couponCalculation();
                    $('#couponField').show();

                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000 
                    })
                    if ($.isEmptyObject(data.error)) {
                            
                            Toast.fire({
                            type: 'success',
                            icon: 'success', 
                            title: data.success, 
                            })
                    }else{
                    
                Toast.fire({
                            type: 'error',
                            icon: 'error', 
                            title: data.error, 
                            })
                        }
                    // End Message  
                    }
                })
            }
        
        //coupon remove end
    </script> 
     

</body>

</html>