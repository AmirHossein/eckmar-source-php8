<?php

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
Route::get('/demo','HomeController@ShowDemo')->name('demo');
Route::get('/demo/money','HomeController@DemoMoney')->name('demomoney');
Route::get('/demo/admin','HomeController@DemoAdmin')->name('demoadmin');
Route::get('/demo/vendor','HomeController@DemoVendor')->name('demovendor');
/*
|--------------------------------------------------------------------------
| End of Demo routes
|--------------------------------------------------------------------------
*/



Route::get('register','AuthController@RegisterShow')->name('register');
Route::post('register','AuthController@RegisterPost')->name('registerpost');
Route::get('mnemonic','AuthController@ShowMnemonic')->name('showmnemonic');
Route::get('login','AuthController@ShowLogin')->name('login');
Route::post('login','AuthController@LoginPost')->name('loginpost');
Route::get('passwordreset','AuthController@PasswordResetShow')->name('passwordreset');
Route::post('passwordreset','AuthController@PasswordResetPost')->name('passwordresetpost');
Route::get('verify','AuthController@VerifyShow')->name('verify');
Route::post('verify','AuthController@VerifyPost')->name('verifypost');

Route::group(['middleware' => 'auth'],function(){
  Route::get('logout','AuthController@Logout')->name('logout');
  Route::get('/', 'HomeController@Index')->name('home');
  Route::get('myprofile','ProfileController@Index')->name('profile');

  Route::get('vendorapply','ProfileController@VendorApplyShow')->name('vendorapply');
  Route::post('vendorapply','ProfileController@VendorApplyPost')->name('vendorapplypost');
  Route::get('vendorapplysuccess','ProfileController@VendorApplySuccess')->name('vendorapplysuccess');
  Route::get('vendorpay','ProfileController@VendorPay')->name('vendorpay');
  Route::post('vendorpay','ProfileController@VendorPayPost')->name('vendorpaypost');
  Route::get('vendorpaysuccess','ProfileController@VendorPaySuccess')->name('vendorpaysuccess');

  Route::get('createproduct','ProductController@CreateProduct')->name('createproduct');
  Route::post('createproduct','ProductController@CreateProductPost')->name('createproductpost');

  Route::get('myproducts','ProfileController@ShowProducts')->name('products');
  Route::get('editproduct/{uniqueid}','ProfileController@EditProduct')->name('editproduct');
  Route::post('editproduct/{uniqueid}','ProductController@EditProductPost')->name('editproductpost');

  Route::get('mysales','ProfileController@ShowSales')->name('sales');

  Route::get('mypurchases','ProfileController@ShowPurchases')->name('purchases');

  Route::get('autofill/{uniqueid}','ProfileController@AutoFill')->name('autofill');
  Route::post('autofill/{uniqueid}','ProfileController@AutoFillPost')->name('autofillpost');

  Route::get('products/{cslug}','ProductController@ShowCategory')->name('showcat');
  Route::get('products/{cslug}/{uniqueid}/{item?}','ProductController@ViewProduct')->name('viewproduct');

  Route::get('sold','ProductController@Sold')->name('sold');

  Route::get('bid/{cslug}/{uniqueid}','ProductController@BidShow')->name('showbid');
  Route::post('bid/{cslug}/{uniqueid}','ProductController@BidShowPost')->name('postbid');

  Route::get('buy/{cslug}/{uniqueid}','ProductController@BuyShow')->name('showbuy');
  Route::post('buy/{cslug}/{uniqueid}','ProductController@BuyShowPost')->name('postbuy');

  Route::get('deliver/{uniqueid}','PurchaseController@DeliverShow')->name('deliver');
  Route::post('deliver/{uniqueid}','PurchaseController@DeliverPost')->name('deliverpost');

  Route::get('goods/{uniqueid}','PurchaseController@GoodsShow')->name('goods');
  Route::post('confirm/{uniqueid}','PurchaseController@ConfirmDelivery')->name('confirm');

  Route::get('newfeedback/{uniqueid}/{u}','PurchaseController@NewFeedback')->name('newfeedback');
  Route::post('newfeedback/{uniqueid}/{u}','PurchaseController@NewFeedbackPost')->name('newfeedbackpost');

  Route::get('feedback','ProfileController@ShowFeedback')->name('feedback');

  Route::get('dispute/create/{uniqueid}','DisputeController@Create')->name('createdispute');
  Route::post('dispute/create/{uniqueid}','DisputeController@CreatePost')->name('createdisputepost');

  Route::get('dispute/view/{uniqueid}','DisputeController@View')->name('dispute');
  Route::post('dispute/reply/{uniqueid}','DisputeController@AddReply')->name('addreply');

  Route::post('dispute/resolve/{uniqueid}','DisputeController@Resolve')->name('resolve');
  Route::get('dispute/resolved','DisputeController@Resolved')->name('resolved');

  Route::get('message/send/{username?}','MessageController@SendView')->name('sendmessage');
  Route::post('message/send','MessageController@SendPost')->name('sendmessagepost');

  Route::get('messages/received','MessageController@ViewReceived')->name('messages');
  Route::get('messages/sent','MessageController@ViewSent')->name('messagessent');

  Route::get('message/view/{uniqueid}','MessageController@ViewMessage')->name('viewmessage');

  Route::get('profile/view/{uniqueid}/{item?}','ProfileController@View')->name('viewprofile');

  Route::post('editprofile','ProfileController@EditProfile')->name('editprofile');
  Route::get('profile/store/{uniqueid}','ProfileController@ViewStore')->name('viewstore');

  Route::get('wallet','ProfileController@ShowWallet')->name('wallet');
  Route::get('wallet/depositaddress','WalletController@NewAddress')->name('generateaddress');
  Route::get('wallet/checkbalance','WalletController@CheckBalance')->name('checkbalance');
  Route::get('wallet/withdraw','WalletController@WithdrawShow')->name('withdraw');
  Route::post('wallet/withdraw','WalletController@WithdrawPost')->name('withdrawpost');

  Route::get('test','WalletController@Test');
});


Route::group(['middleware' => 'admin','prefix'=>'admin'],function(){

  Route::get('index','AdminController@Index')->name('admin');

  Route::post('index/editsettings','AdminController@SettingsEdit')->name('editsettings');

  Route::get('vendorapplications','AdminController@VendorApplications')->name('vendorapplications');
  Route::get('va/{uniqueid}','AdminController@VaShow')->name('va');
  Route::post('va/{uniqueid}','AdminController@VaPost')->name('vapost');

  Route::get('categories','AdminController@ShowCategories')->name('categories');
  Route::get('category/{uniqueid}','AdminController@EditCategory')->name('editcategory');
  Route::post('category/{uniqueid}','AdminController@EditCategoryPost')->name('editcategorypost');
  Route::get('createcategory','AdminController@CreateCategory')->name('createcategory');
  Route::post('createcategory','AdminController@CreateCategoryPost')->name('createcategorypost');

  Route::get('disputes','AdminController@DisputesShow')->name('disputes');

  Route::get('news','AdminController@News')->name('news');
  Route::get('news/create','AdminController@NewsCreate')->name('newscreate');
  Route::post('news/create','AdminController@NewsCreatePost')->name('newscreatepost');

  Route::get('news/edit/{uniqueid}','AdminController@EditNews')->name('editnews');
  Route::post('news/edit/{uniqueid}','AdminController@EditNewsPost')->name('editnewspost');


});
