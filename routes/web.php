<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ShippingAreaController;

use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\CartController;

use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\CompareController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('frontend.index');
//});

Route::get('/', [IndexController::class, 'Index']);

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('update.password');
});

//VENDOR
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('/vendor/change/password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/update/password', [VendorController::class, 'VendorUpdatePassword'])->name('vendor.update.password');

    //VENDOR PRODUCT CONTROLLER
    Route::controller(VendorProductController::class)->group(function () {
        Route::get('/vendor/all/product', 'VendorAllProduct')->name('vendor.all.product');
        Route::get('/vendor/add/product', 'VendorAddProduct')->name('vendor.add.product');
        Route::post('/vendor/product/store', 'VendorProductStore')->name('vendor.product.store');
        Route::get('/vendor/subcategory/ajax/{category_id}' , 'VendorGetSubCategory');
        Route::get('/vendor/edit/product/{id}', 'VendorEditProduct')->name('vendor.edit.product');
        Route::post('/vendor/product/update', 'VendorProductUpdate')->name('vendor.product.update');
        Route::post('/vendor/product/update/thumbnail', 'VendorUpdateProductThumbnail')->name('vendor.product.update.thumbnail');
        Route::post('/vendor/product/update/multiimage', 'VendorUpdateProductMultiimage')->name('vendor.product.update.multiimage');
        Route::get('/vendor/product/multiimage/delete/{id}', 'VendorMultiImageDelete')->name('vendor.product.multiimage.delete');
        Route::get('/vendor/product/inactive/{id}', 'VendorProductInactive')->name('vendor.product.inactive');
        Route::get('/vendor/product/active/{id}', 'VendorProductActive')->name('vendor.product.active');
        Route::get('/vendor/delete/product/{id}', 'VendorProductDelete')->name('vendor.delete.product');
        
    });


});//END VENDOR MİDDLEWARE

require __DIR__.'/auth.php';

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class);
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);

Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');




Route::middleware(['auth', 'role:admin'])->group(function () {

    //BRAND ROUTE
    Route::controller(BrandController::class)->group(function () {
        Route::get('/all/brand', 'AllBrand')->name('all.brand');
        Route::get('/add/brand', 'AddBrand')->name('add.brand');
        Route::post('/brand/store', 'StoreBrand')->name('brand.store');
        Route::get('/edit/brand/{id}', 'EditBrand')->name('edit.brand');
        Route::post('/update/store', 'UpdateBrand')->name('update.store');
        Route::get('/delete/brand/{id}', 'DeleteBrand')->name('delete.brand');
    });

    //CATEGORY ROUTE
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/category/store', 'StoreCategory')->name('category.store');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::post('/update/category', 'UpdateCategory')->name('update.category');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');
    });

    //SUBCATEGORY ROUTE
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/all/subcategory', 'AllSubCategory')->name('all.subcategory');
        Route::get('/add/subcategory', 'AddSubCategory')->name('add.subcategory');
        Route::post('/subcategory/store', 'StoreSubCategory')->name('subcategory.store');
        Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory');
        Route::post('/update/subcategory', 'UpdateSubCategory')->name('update.subcategory');
        Route::get('/delete/subcategory/{id}', 'DeleteSubCategory')->name('delete.subcategory');
        Route::get('/subcategory/ajax/{category_id}' , 'GetSubCategory');
    });

    //VENDOR ACTIVE, INACTIVE ROUTE
    Route::controller(AdminController::class)->group(function () {
        Route::get('/inactive/vendor', 'InactiveVendor')->name('inactive.vendor');
        Route::get('/active/vendor', 'ActiveVendor')->name('active.vendor');
        Route::get('/inactive/vendor/details/{id}', 'InactiveVendorDetails')->name('inactive.vendor.details');
        Route::post('/active/vendor/approve', 'ActiveVendorApprove')->name('active.vendor.approve');
        Route::get('/active/vendor/details/{id}', 'ActiveVendorDetails')->name('active.vendor.details');
        Route::post('/inactive/vendor/approve', 'InactiveVendorApprove')->name('inactive.vendor.approve');
    });

    //PRODUCT ROUTE
    Route::controller(ProductController::class)->group(function () {
        Route::get('/all/product', 'AllProduct')->name('all.product');
        Route::get('/add/product', 'AddProduct')->name('add.product');
        Route::post('/product/store', 'StoreProduct')->name('product.store');
        Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
        Route::post('/product/update', 'UpdateProduct')->name('product.update');
        Route::post('/product/update/thumbnail', 'UpdateProductThumbnail')->name('product.update.thumbnail');
        Route::post('/product/update/multiimage', 'UpdateProductMultiimage')->name('product.update.multiimage');
        Route::get('/product/multiimage/delete/{id}', 'MultiImageDelete')->name('product.multiimage.delete');
        Route::get('/product/inactive/{id}', 'ProductInactive')->name('product.inactive');
        Route::get('/product/active/{id}', 'ProductActive')->name('product.active');
        Route::get('/delete/product/{id}', 'ProductDelete')->name('delete.product');
    });

    //SLİDER ROUTE
    Route::controller(SliderController::class)->group(function () {
        Route::get('/all/slider', 'AllSlider')->name('all.slider');
        Route::get('/add/slider', 'AddSlider')->name('add.slider');
        Route::post('/slider/store', 'StoreSlider')->name('slider.store');
        Route::get('/edit/slider/{id}', 'EditSlider')->name('edit.slider');
        Route::post('/slider/update', 'SliderUpdate')->name('slider.update');
        Route::get('/delete/slider/{id}', 'DeleteSlider')->name('delete.slider');
    });

    //BANNER ROUTE
    Route::controller(BannerController::class)->group(function () {
        Route::get('/all/banner', 'AllBanner')->name('all.banner');
        Route::get('/add/banner', 'AddBanner')->name('add.banner');
        Route::post('/banner/store', 'StoreBanner')->name('banner.store');
        Route::get('/edit/banner/{id}', 'EditBanner')->name('edit.banner');
        Route::post('/banner/update', 'BannerUpdate')->name('banner.update');
        Route::get('/delete/banner/{id}', 'DeleteBanner')->name('delete.banner');
    });

    //COUPON ROUTE
    Route::controller(CouponController::class)->group(function () {
        Route::get('/all/coupon', 'AllCoupon')->name('all.coupon');
        Route::get('/add/coupon', 'AddCoupon')->name('add.coupon');
        Route::post('/coupon/store', 'StoreCoupon')->name('coupon.store');
        Route::get('/edit/coupon/{id}', 'EditCoupon')->name('edit.coupon');
        Route::post('/coupon/update', 'CouponUpdate')->name('coupon.update');
        Route::get('/delete/coupon/{id}', 'DeleteCoupon')->name('delete.coupon');
    });

    //SHİPPİNG DİVİSİON ROUTE
    Route::controller(ShippingAreaController::class)->group(function () {
        Route::get('/all/division', 'AllDivision')->name('all.division');
        Route::get('/add/division', 'AddDivision')->name('add.division');
        Route::post('/division/store', 'StoreDivision')->name('division.store');
        Route::get('/edit/division/{id}', 'EditDivision')->name('edit.division');
        Route::post('/division/update', 'DivisionUpdate')->name('division.update');
        Route::get('/delete/division/{id}', 'DeleteDivision')->name('delete.division');
    });

    //SHİPPİNG DİSTRİCT ROUTE
    Route::controller(ShippingAreaController::class)->group(function () {
        Route::get('/all/district', 'AllDistrict')->name('all.district');
        Route::get('/add/district', 'AddDistrict')->name('add.district');
        Route::post('/district/store', 'StoreDistrict')->name('district.store');
        Route::get('/edit/district/{id}', 'EditDistrict')->name('edit.district');
        Route::post('/district/update', 'DistrictUpdate')->name('district.update');
        Route::get('/delete/district/{id}', 'DeleteDistrict')->name('delete.district');
    });

    //SHİPPİNG STATE ROUTE
    Route::controller(ShippingAreaController::class)->group(function () {
        Route::get('/all/state', 'AllState')->name('all.state');
        Route::get('/add/state', 'AddState')->name('add.state');
        Route::get('/district/ajax/{division_id}', 'GetDistrict');
        Route::post('/state/store', 'StoreState')->name('state.store');
        Route::get('/edit/state/{id}', 'EditState')->name('edit.state');
        Route::post('/state/update', 'StateUpdate')->name('state.update');
        Route::get('/delete/state/{id}', 'DeleteState')->name('delete.state');

    });
    
});//END ADMIN MİDDLEWARE


//FRONTEND PRODUCT DETAİLS ROUTE
Route::get('/product/details/{id}/{slug}', [IndexController::class, 'ProductDetails']);

//FRONTEND VENDOR DETAİLS ROUTE
Route::get('/vendor/details/{id}', [IndexController::class, 'VendorDetails'])->name('vendor.details');
Route::get('/vendor/all/', [IndexController::class, 'VendorAll'])->name('vendor.all');

//FRONTEND CATEGORY WİSE PRODUCT ROUTE
Route::get('/product/category/{id}/{slug}', [IndexController::class, 'CatWiseProduct']);
Route::get('/product/subcategory/{id}/{slug}', [IndexController::class, 'SubCatWiseProduct']);

//PRODUCT VİEW MODAL WİTH AJAX
Route::get('/product/view/modal/{id}', [IndexController::class, 'ProductViewAjax']);

//PRODUCT MİNİ CART
Route::get('/product/mini/cart', [CartController::class, 'AddMiniCart']);

//PRODUCT MİNİ CART REMOVE
Route::get('/minicart/product/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);

//ADD TO CART STORE DATA
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);

//ADD TO CART STORE DATA FOR PRODUCT DETAİLS PAGE
Route::post('/dcart/data/store/{id}', [CartController::class, 'AddToCartDetails']);

//ADD TO WİSHLİST
Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'AddToWishList']);

//ADD TO COMPARE
Route::post('/add-to-compare/{product_id}', [CompareController::class, 'AddToCompare']);


Route::middleware(['auth', 'role:user'])->group(function () {

    //WİSHLİST ROUTE
    Route::controller(WishlistController::class)->group(function () {
        Route::get('/wishlist', 'AllWishlist')->name('wishlist');
        Route::get('/get-wishlist-product', 'GetWishlistProduct');
        Route::get('/wishlist-remove/{id}', 'WishlistRemove');
    });

    //COMPARE ROUTE
    Route::controller(CompareController::class)->group(function () {
        Route::get('/compare', 'AllCompare')->name('compare');
        Route::get('/get-compare-product', 'GetCompareProduct');
        Route::get('/compare-remove/{id}', 'CompareRemove');
    });

    //MYCART ROUTE
    Route::controller(CartController::class)->group(function () {
        Route::get('/mycart', 'MyCart')->name('mycart');
        Route::get('/get-cart-product', 'GetCartProduct');
        Route::get('/cart-remove/{rowId}', 'CartRemove');
        Route::get('/cart-decrement/{rowId}', 'CartDecrement');
        Route::get('/cart-increment/{rowId}', 'CartIncrement');

    });

});//END USER MİDDLEWARE