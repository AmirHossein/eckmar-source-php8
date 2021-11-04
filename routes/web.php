<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisputeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\WalletController;

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


/*
|--------------------------------------------------------------------------
| Demo routes
|--------------------------------------------------------------------------
*/
Route::get('/demo', [HomeController::class, 'ShowDemo'])->name('demo');
Route::get('/demo/money', [HomeController::class, 'DemoMoney'])->name('demomoney');
Route::get('/demo/admin', [HomeController::class, 'DemoAdmin'])->name('demoadmin');
Route::get('/demo/vendor', [HomeController::class, 'DemoVendor'])->name('demovendor');
/*
|--------------------------------------------------------------------------
| End of Demo routes
|--------------------------------------------------------------------------
*/


Route::get('register', [AuthController::class, 'RegisterShow'])->name('register');
Route::post('register', [AuthController::class, 'RegisterPost'])->name('registerpost');
Route::get('mnemonic', [AuthController::class, 'ShowMnemonic'])->name('showmnemonic');
Route::get('login', [AuthController::class, 'ShowLogin'])->name('login');
Route::post('login', [AuthController::class, 'LoginPost'])->name('loginpost');
Route::get('passwordreset', [AuthController::class, 'PasswordResetShow'])->name('passwordreset');
Route::post('passwordreset', [AuthController::class, 'PasswordResetPost'])->name('passwordresetpost');
Route::get('verify', [AuthController::class, 'VerifyShow'])->name('verify');
Route::post('verify', [AuthController::class, 'VerifyPost'])->name('verifypost');

Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'Logout'])->name('logout');
    Route::get('/', [HomeController::class, 'Index'])->name('home');
    Route::get('myprofile', [ProfileController::class, 'Index'])->name('profile');

    Route::get('vendorapply', [ProfileController::class, 'VendorApplyShow'])->name('vendorapply');
    Route::post('vendorapply', [ProfileController::class, 'VendorApplyPost'])->name('vendorapplypost');
    Route::get('vendorapplysuccess', [ProfileController::class, 'VendorApplySuccess'])->name('vendorapplysuccess');
    Route::get('vendorpay', [ProfileController::class, 'VendorPay'])->name('vendorpay');
    Route::post('vendorpay', [ProfileController::class, 'VendorPayPost'])->name('vendorpaypost');
    Route::get('vendorpaysuccess', [ProfileController::class, 'VendorPaySuccess'])->name('vendorpaysuccess');

    Route::get('createproduct', [ProductController::class, 'CreateProduct'])->name('createproduct');
    Route::post('createproduct', [ProductController::class, 'CreateProductPost'])->name('createproductpost');

    Route::get('myproducts', [ProfileController::class, 'ShowProducts'])->name('products');
    Route::get('editproduct/{uniqueid}', [ProfileController::class, 'EditProduct'])->name('editproduct');
    Route::post('editproduct/{uniqueid}', [ProductController::class, 'EditProductPost'])->name('editproductpost');

    Route::get('mysales', [ProfileController::class, 'ShowSales'])->name('sales');

    Route::get('mypurchases', [ProfileController::class, 'ShowPurchases'])->name('purchases');

    Route::get('autofill/{uniqueid}', [ProfileController::class, 'AutoFill'])->name('autofill');
    Route::post('autofill/{uniqueid}', [ProfileController::class, 'AutoFillPost'])->name('autofillpost');

    Route::get('products/{cslug}', [ProductController::class, 'ShowCategory'])->name('showcat');
    Route::get('products/{cslug}/{uniqueid}/{item?}', [ProductController::class, 'ViewProduct'])->name('viewproduct');

    Route::get('sold', [ProductController::class, 'Sold'])->name('sold');

    Route::get('bid/{cslug}/{uniqueid}', [ProductController::class, 'BidShow'])->name('showbid');
    Route::post('bid/{cslug}/{uniqueid}', [ProductController::class, 'BidShowPost'])->name('postbid');

    Route::get('buy/{cslug}/{uniqueid}', [ProductController::class, 'BuyShow'])->name('showbuy');
    Route::post('buy/{cslug}/{uniqueid}', [ProductController::class, 'BuyShowPost'])->name('postbuy');

    Route::get('deliver/{uniqueid}', [PurchaseController::class, 'DeliverShow'])->name('deliver');
    Route::post('deliver/{uniqueid}', [PurchaseController::class, 'DeliverPost'])->name('deliverpost');

    Route::get('goods/{uniqueid}', [PurchaseController::class, 'GoodsShow'])->name('goods');
    Route::post('confirm/{uniqueid}', [PurchaseController::class, 'ConfirmDelivery'])->name('confirm');

    Route::get('newfeedback/{uniqueid}/{u}', [PurchaseController::class, 'NewFeedback'])->name('newfeedback');
    Route::post('newfeedback/{uniqueid}/{u}', [PurchaseController::class, 'NewFeedbackPost'])->name('newfeedbackpost');

    Route::get('feedback', [ProfileController::class, 'ShowFeedback'])->name('feedback');

    Route::get('dispute/create/{uniqueid}', [DisputeController::class, 'Create'])->name('createdispute');
    Route::post('dispute/create/{uniqueid}', [DisputeController::class, 'CreatePost'])->name('createdisputepost');

    Route::get('dispute/view/{uniqueid}', [DisputeController::class, 'View'])->name('dispute');
    Route::post('dispute/reply/{uniqueid}', [DisputeController::class, 'AddReply'])->name('addreply');

    Route::post('dispute/resolve/{uniqueid}', [DisputeController::class, 'Resolve'])->name('resolve');
    Route::get('dispute/resolved', [DisputeController::class, 'Resolved'])->name('resolved');

    Route::get('message/send/{username?}', [MessageController::class, 'SendView'])->name('sendmessage');
    Route::post('message/send', [MessageController::class, 'SendPost'])->name('sendmessagepost');

    Route::get('messages/received', [MessageController::class, 'ViewReceived'])->name('messages');
    Route::get('messages/sent', [MessageController::class, 'ViewSent'])->name('messagessent');

    Route::get('message/view/{uniqueid}', [MessageController::class, 'ViewMessage'])->name('viewmessage');

    Route::get('profile/view/{uniqueid}/{item?}', [ProfileController::class, 'View'])->name('viewprofile');

    Route::post('editprofile', [ProfileController::class, 'EditProfile'])->name('editprofile');
    Route::get('profile/store/{uniqueid}', [ProfileController::class, 'ViewStore'])->name('viewstore');

    Route::get('wallet', [ProfileController::class, 'ShowWallet'])->name('wallet');
    Route::get('wallet/depositaddress', [WalletController::class, 'NewAddress'])->name('generateaddress');
    Route::get('wallet/checkbalance', [WalletController::class, 'CheckBalance'])->name('checkbalance');
    Route::get('wallet/withdraw', [WalletController::class, 'WithdrawShow'])->name('withdraw');
    Route::post('wallet/withdraw', [WalletController::class, 'WithdrawPost'])->name('withdrawpost');

    Route::get('test', [WalletController::class, 'Test']);
});


Route::middleware('admin')->prefix('admin')->group(function () {

    Route::get('index', [AdminController::class, 'Index'])->name('admin');

    Route::post('index/editsettings', [AdminController::class, 'SettingsEdit'])->name('editsettings');

    Route::get('vendorapplications', [AdminController::class, 'VendorApplications'])->name('vendorapplications');
    Route::get('va/{uniqueid}', [AdminController::class, 'VaShow'])->name('va');
    Route::post('va/{uniqueid}', [AdminController::class, 'VaPost'])->name('vapost');

    Route::get('categories', [AdminController::class, 'ShowCategories'])->name('categories');
    Route::get('category/{uniqueid}', [AdminController::class, 'EditCategory'])->name('editcategory');
    Route::post('category/{uniqueid}', [AdminController::class, 'EditCategoryPost'])->name('editcategorypost');
    Route::get('createcategory', [AdminController::class, 'CreateCategory'])->name('createcategory');
    Route::post('createcategory', [AdminController::class, 'CreateCategoryPost'])->name('createcategorypost');

    Route::get('disputes', [AdminController::class, 'DisputesShow'])->name('disputes');

    Route::get('news', [AdminController::class, 'News'])->name('news');
    Route::get('news/create', [AdminController::class, 'NewsCreate'])->name('newscreate');
    Route::post('news/create', [AdminController::class, 'NewsCreatePost'])->name('newscreatepost');

    Route::get('news/edit/{uniqueid}', [AdminController::class, 'EditNews'])->name('editnews');
    Route::post('news/edit/{uniqueid}', [AdminController::class, 'EditNewsPost'])->name('editnewspost');
});
