<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>Nest Online Shop</title>
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

        function addToCard(params) {
            var product_name = $('#productName').text();  
            var id = $('#product_id').val();   
            var color = $('#color option:select').text();   
            var size = $('#size option:selected').text();   
            var quantity = $('#quantity').val();   
            $.ajax({
                type: "POST",
                dataType: 'json',
                data:{
                    color:color, size:size, quantity:quantity, product_name:product_name
                },
                url: "/cart/data/store/"+id,
                success: function(data) {
                    console.log(data)
                }
            })
        }

        //end add to cart product


    </script>

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

</body>

</html>