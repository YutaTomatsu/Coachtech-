<?php

use App\Models\Item;
use App\Models\Mylist;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MylistController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminEmailController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserEmailController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopSellController;
use App\Http\Controllers\ShopEditController;

Route::get('/', function () {
    $items = Item::get();
    $user_id = Auth::id();
    $mylists = Mylist::select('mylists.id', 'mylists.user_id', 'mylists.item_id', 'items.price', 'items.image')
        ->leftJoin('items', 'items.id', '=', 'mylists.item_id')
        ->where('mylists.user_id', $user_id)
        ->get();

    $purchasedItemIds = Purchase::pluck('item_id')->toArray();

    return view('dashboard', compact('items', 'mylists', 'purchasedItemIds'));
})->name('home');

Route::get('/dashboard', function () {
    $items = Item::get();
    $user_id = Auth::id();
    $mylists = Mylist::select('mylists.id', 'mylists.user_id', 'mylists.item_id', 'items.price', 'items.image')
        ->leftJoin('items', 'items.id', '=', 'mylists.item_id')
        ->where('mylists.user_id', $user_id)
        ->get();

    $purchasedItemIds = Purchase::pluck('item_id')->toArray();

    return view('dashboard', compact('items', 'mylists', 'purchasedItemIds'));
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/admin', function () {return view('admin.admin_dashboard');})->middleware(['can:admin'])->name('admin.dashboard');

Route::get('/mypage', [MypageController::class, 'showMypage'])->name('mypage');

Route::get('/mypage/profile', [ProfileController::class, 'create'])->name('profile');

Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('update-profile');

Route::get('/sell', [SellController::class, 'showSellForm'])->name('show-sell');

Route::post('/sell', [SellController::class, 'sell'])->name('sell');

Route::get('/sell/done', [SellController::class, 'sellDone'])->name('sell-done');


Route::get('/item/{id}', [ItemController::class, 'detail'])->name('detail');

Route::post('/mylist/toggle', [MylistController::class, 'toggle'])->name('mylist.toggle');

Route::get('/comment/{id}', [CommentController::class, 'showCommentForm'])->name('show-comment');

Route::post('/comment/{id}', [CommentController::class, 'comment'])->name('comment');

Route::post('comment//delete/{id}', [CommentController::class, 'delete'])->name('comment-delete');

Route::get('/purchage/{id}', [PurchaseController::class, 'showPurchageForm'])
    ->name('show-purchage');

Route::get('/card/{id}', [PaymentController::class, 'showCardForm'])->name('card');

Route::get('/bank/{id}', [PaymentController::class, 'showBankForm'])->name('bank');

Route::get('/convenience/{id}', [PaymentController::class, 'showConvenienceForm'])->name('convenience');

Route::match(['get', 'post'], '/payment-success/{id}', [PaymentController::class, 'success'])->name('payment-success');


Route::get('/address/{id}', [AddressController::class, 'showChangeAddressForm'])->name('show-change-address');

Route::post('/address/{id}', [AddressController::class, 'changeAddress'])->name('change-address');

Route::get('/search', [SearchController::class,'search'])->name('search');

Route::get('/admins/create-email', [AdminEmailController::class, 'showEmailForm'])->name('admin-show-email');
Route::post('/admins/send-email', [AdminEmailController::class, 'sendEmail'])->name('admins.send-email');

Route::get('/seller/{id}', [SellerController::class, 'showSeller'])->name('show-seller');

Route::get('/review/{id}', [ReviewController::class, 'showReviewForm'])->name('write-review');

Route::post('/review/{id}', [ReviewController::class, 'review'])->name('review');

Route::get('/reviews/{id}', [ReviewController::class, 'showReviews'])->name('show-reviews');

Route::post('/follow', [FollowController::class, 'follow'])->name('follow');

Route::post('/unfollow', [FollowController::class, 'unfollow'])->name('unfollow');

Route::get('/following/{id}', [FollowController::class, 'showFollowing'])->name('following');

Route::get('/follower/{id}', [FollowController::class, 'showFollower'])->name('follower');

Route::get('/following/seller/{id}', [SellerController::class, 'showFollowingSeller'])->name('show-following-seller');

Route::post('/logout', function () {Auth::logout();return redirect('/');})
->name('logout');

Route::get('/staff/{id}', [UserEmailController::class, 'showStaff'])->middleware('auth')
    ->name('show-staff');


Route::get('/user-emails/{id}', [UserEmailController::class, 'create'])->middleware('auth')
->name('show-create-staff');

Route::post('/user-emails', [UserEmailController::class, 'store'])->middleware('auth');

Route::get('/shop', [ShopController::class, 'showShopForm'])->name('show-create-shop');

Route::post('/shop', [ShopController::class, 'createShop'])->name('create-shop');

Route::get('/shop/dashboard/{id}', [ShopController::class, 'showShop'])->name('show-shop');

Route::get('/shop/sell/{id}', [ShopSellController::class, 'showShopSellForm'])->name('show-shop-sell');

Route::post('/shop/sell/{id}', [ShopSellController::class, 'shopSell'])->name('shop-sell');

Route::get('/shop/edit/{id}', [ShopEditController::class, 'showShopEditForm'])->name('show-shop-edit');

Route::post('/shop/edit/{id}', [ShopEditController::class, 'shopEdit'])->name('shop-edit');