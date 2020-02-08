<?php

// use App\Models\Order;
use Illuminate\Http\Request;
// use Illuminate\Routing\Route;

// Route::group(['middleware' => 'check.ip'], function () {
    Route::resource('categories', 'Categories\CategoryController');
    Route::resource('categoryproduct', 'CategoryProduct\CategoryProductController');
    Route::post('searchproductcategory', 'CategoryProduct\CategoryProductController@search');
    Route::get('categorylist', 'Categories\CategoryController@categorylist');
    Route::resource('products', 'Products\ProductController');
    Route::get('latest', 'Products\ProductController@latest');
    Route::post('activateproduct', 'Products\ProductController@activateproduct');
    Route::post('products-search', 'Products\ProductController@search');
    Route::get('getbrans/{id}', 'Products\ProductController@getbrans');
    
    Route::resource('addresses', 'Addresses\AddressController');
    Route::resource('brands', 'Brands\BrandsController');
    Route::resource('shippingmethods', 'ShippingMethods\ShippingMethodsController');
    Route::resource('countryshippingmethod', 'CountryShippingMethodController');
    Route::resource('countries', 'Countries\CountryController');
    Route::resource('orders', 'Orders\OrderController');
    
    Route::get('allorders', 'Orders\OrderController@allorders');
    Route::post('execute_payment', 'Orders\OrderController@execute_payment');
    Route::post('retrypayment', 'Orders\OrderController@retrypayment');
    Route::get('order/{id}', 'Mpesa\MpesaController@show');
    Route::resource('payment-methods', 'PaymentMethods\PaymentMethodController');
    Route::resource('slider', 'Slider\SliderController');
    Route::resource('adverts', 'Adverts\AdvertsController');
    Route::resource('wavesection', 'Wavesection\WavesectionControllers');
    Route::resource('comments', 'Comments\CommentsController');
    Route::resource('locations', 'Locations\LocationsController');

    Route::resource('shippingid-addressid', 'Shippingdata\ShippingdataController');
    Route::resource('icons', 'Images\ProductIconController');
    Route::resource('productvariation', 'ProductVariation\ProductVariationController');
    Route::resource('images', 'Images\ProductImagesController');
    Route::resource('offerimages', 'Images\OfferimagesController');
    Route::resource('bannerimages', 'Images\BannerimagesController');
    Route::resource('saveimages', 'Images\SaveimagesController');
    Route::resource('waveimages', 'Images\WaveimagesController');

    Route::resource('product-variation-type', 'ProductVariationType\ProductVariationTypeController');
    Route::get('variationlist', 'ProductVariationType\ProductVariationTypeController@variationlist');

    Route::post('message', 'Clinic\SendmessageController@message');
    Route::post('booking', 'Clinic\BookappointmentController@book');

    Route::post('validation', 'Mpesa\MpesaController@mpesaupdate');
    Route::get('getspec', 'Mpesa\MpesaController@getspec');

    Route::get('register', 'Mpesa\MpesaController@index');

    Route::get('pesapaltest', function(Request $request){
        // 
    });

    Route::get('addresses/{address}/shipping', 'Addresses\AddressShippingController@action');

    Route::group(['prefix' => 'auth'], function () {
        Route::resource('promocode', 'Promocode\PromocodeController');
        Route::post('register', 'Auth\RegisterController@action');
        Route::post('reset', 'Auth\ForgotCredentialsController@reset');
        Route::put('passwordreset/{id}', 'Auth\ForgotCredentialsController@passwordreset');
        Route::post('login', 'Auth\LoginController@action');
        Route::post('logout', 'Auth\LoginController@logout');
        Route::get('me', 'Auth\MeController@action');
        Route::resource('wishlist', 'Wishlist\WishlistController');
        Route::resource('users', 'Users\UsersController');
        Route::resource('stock', 'Stock\StockController');
        Route::get('annualsales', 'Orders\OrderController@annualsales');
        Route::get('allwishlist', 'Wishlist\WishlistController@allwishlist');
        Route::put('userupdate/{id}', 'Auth\MeController@update');
        Route::post('imageupload', 'Auth\MeController@store');
        Route::post('productupload', 'Products\ProductController@productupload');
        Route::resource('points', 'Points\PointsController');
    });
    
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('products', 'Admin\AllproductsController');
        Route::resource('orders', 'Admin\OrderschangesController');
        Route::resource('logs', 'Logs\LogsController');
        Route::resource('admin', 'Auth\AdminController');
        
        Route::resource('ordersreports', 'Ordersreports\OrdersreportsController');
        Route::post('login', 'Auth\AdminLoginController@action');
        Route::get('me', 'Auth\AdminController@me');
        Route::get('totalusers', 'Users\UsersController@totalusers');
        Route::get('weeklysales', 'Orders\OrderController@weeklysales');

        Route::post('/r01pdf', 'Reports\Orders\R01Controller@r01pdf');
        Route::post('/r01xlsx', 'Reports\Orders\R01Controller@r01xlsx');
    });

    Route::resource('cart', 'Cart\CartController', [
        'parameters' => [
            'cart' => 'productVariation'
        ]
    ]);
// });