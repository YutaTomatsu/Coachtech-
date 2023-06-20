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
use App\Http\Controllers\UserEmailController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopSellController;
use App\Http\Controllers\ShopEditController;
use App\Http\Controllers\ShopItemController;
use App\Http\Controllers\ShopCommentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ShopContactController;

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
})->middleware(['auth', 'check.user.staff'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/admin', function () {return view('admin.admin_dashboard');})->middleware(['can:admin'])->name('admin.dashboard');

Route::get('/mypage', [MypageController::class, 'showMypage'])
->middleware(['auth', 'check.user.staff'])
->name('mypage');

Route::get('/mypage/profile', [ProfileController::class, 'create'])
->middleware(['auth', 'check.user.staff'])
->name('profile');

Route::post('/mypage/profile', [ProfileController::class, 'update'])
->middleware(['auth', 'check.user.staff'])
->name('update-profile');

Route::get('/sell', [SellController::class, 'showSellForm'])
->middleware(['auth', 'check.user.staff'])
->name('show-sell');

Route::post('/sell', [SellController::class, 'sell'])
->middleware(['auth', 'check.user.staff'])
->name('sell');

Route::get('/sell/done', [SellController::class, 'sellDone'])
->middleware(['auth', 'check.user.staff'])
->name('sell-done');

Route::get('/item/{id}', [ItemController::class, 'detail'])
->middleware(['check.user.staff'])
->name('detail');

Route::post('/mylist/toggle', [MylistController::class, 'toggle'])
->middleware(['auth', 'check.user.staff'])
->name('mylist.toggle');

Route::get('/comment/{id}', [CommentController::class, 'showCommentForm'])
->middleware(['check.user.staff'])
->name('show-comment');

Route::get('shop/comment/{id}', [ShopCommentController::class, 'showCommentForm'])
->middleware(['auth', 'check.user.staff'])
->name('shop-show-comment');

Route::post('/comment/{id}', [CommentController::class, 'comment'])->middleware(['auth', 'check.user.staff'])
->name('comment');

Route::post('comment//delete/{id}', [CommentController::class, 'delete'])
->middleware(['auth', 'check.user.staff'])
->name('comment-delete');

Route::get('/purchage/{id}', [PurchaseController::class, 'showPurchageForm'])
    ->middleware(['auth', 'check.user.staff'])
    ->name('show-purchage');

Route::get('/card/{id}', [PaymentController::class, 'showCardForm'])
->middleware(['auth', 'check.user.staff'])
->name('card');

Route::get('/bank/{id}', [PaymentController::class, 'showBankForm'])
->middleware(['auth', 'check.user.staff'])
->name('bank');

Route::get('/convenience/{id}', [PaymentController::class, 'showConvenienceForm'])
->middleware(['auth', 'check.user.staff'])
->name('convenience');

Route::match(['get', 'post'], '/payment-success/{id}', [PaymentController::class, 'success'])
->middleware(['auth', 'check.user.staff'])
->name('payment-success');

Route::get('/payment/success', [PaymentController::class, 'showSuccessPage'])
->middleware(['auth', 'check.user.staff'])
->name('show-success-page');

Route::get('/address/{id}', [AddressController::class, 'showChangeAddressForm'])
->middleware(['auth', 'check.user.staff'])
->name('show-change-address');

Route::post('/address/{id}', [AddressController::class, 'changeAddress'])
->middleware(['auth', 'check.user.staff'])
->name('change-address');

Route::get('/search', [SearchController::class,'search'])
->middleware(['check.user.staff'])
->name('search');

Route::get('/admins/create-email', [AdminEmailController::class, 'showEmailForm'])
->name('admin-show-email');

Route::post('/admins/send-email', [AdminEmailController::class, 'sendEmail'])->name('admins.send-email');

Route::get('/seller/{id}', [SellerController::class, 'showSeller'])
->middleware(['check.user.staff'])
->name('show-seller');

Route::get('/review/{id}', [ReviewController::class, 'showReviewForm'])
->middleware(['auth', 'check.user.staff'])
->name('write-review');

Route::get('/review/shop/{id}', [ReviewController::class, 'showShopReviewForm'])
->middleware(['auth', 'check.user.staff'])
->name('write-shop-review');

Route::post('/review/{id}', [ReviewController::class, 'review'])
->middleware(['auth', 'check.user.staff'])
->name('review');

Route::post('/review/shop/{id}', [ReviewController::class, 'shopReview'])
->middleware(['auth', 'check.user.staff'])
->name('shop-review');

Route::get('/reviews/{id}', [ReviewController::class, 'showReviews'])
->middleware(['check.user.staff'])
->name('show-reviews');

Route::get('/reviews/shop/{id}', [ReviewController::class, 'showShopReviews'])
->middleware(['check.user.staff'])
->name('show-shop-reviews');

Route::post('/follow', [FollowController::class, 'follow'])
->middleware(['auth', 'check.user.staff'])
->name('follow');

Route::post('/follow/shop', [FollowController::class, 'shopFollow'])
->middleware(['auth', 'check.user.staff'])
->name('shop-follow');

Route::post('/unfollow', [FollowController::class, 'unfollow'])
->middleware(['auth', 'check.user.staff'])
->name('unfollow');

Route::post('/unfollow/shop', [FollowController::class, 'shopUnfollow'])
->middleware(['auth', 'check.user.staff'])
->name('shop-unfollow');

Route::get('/following/{id}', [FollowController::class, 'showFollowing'])
->middleware(['check.user.staff'])
->name('following');

Route::get('/follower/{id}', [FollowController::class, 'showFollower'])
->middleware(['check.user.staff'])
->name('follower');

Route::get('/follower/shop/{id}', [FollowController::class, 'showShopFollower'])
->middleware(['check.user.staff'])
->name('shop-follower');

Route::get('/following/seller/{id}', [SellerController::class, 'showFollowingSeller'])
->middleware(['check.user.staff'])
->name('show-following-seller');

Route::post('/logout', function () {Auth::logout();return redirect('/');})
->name('logout');

Route::get('/staff/{id}', [UserEmailController::class, 'showStaff'])->middleware('auth')
    ->name('show-staff');

Route::get('/user-emails/{id}', [UserEmailController::class, 'create'])->middleware('auth')
->middleware(['auth', 'check.user.staff'])
->name('show-create-staff');

Route::delete('/shop/staff/delete/{staff}', [UserEmailController::class, 'staffDestroy'])
->middleware(['auth', 'check.user.staff'])
->name('staff-destroy');

Route::post('/user-emails', [UserEmailController::class, 'store'])->middleware(['auth', 'check.user.staff']);

Route::get('/shop/staff/redirect', [UserEmailController::class, 'staffRedirect'])->name('staff-redirect');

Route::get('/shop', [ShopController::class, 'showShopForm'])
->middleware(['auth', 'check.user.staff'])
->name('show-create-shop');

Route::post('/shop', [ShopController::class, 'createShop'])
->middleware(['auth', 'check.user.staff'])
->name('create-shop');

Route::get('/shop/edit/{id}', [ShopEditController::class, 'showShopEditForm'])->name('show-shop-edit');

Route::post('/shop/edit/{id}', [ShopEditController::class, 'shopEdit'])->name('shop-edit');

Route::get('/shop/dashboard/{id}', [ShopController::class, 'showShop'])
    ->name('show-shop');

Route::get('/shop/sell/{id}', [ShopSellController::class, 'showShopSellForm'])
    ->name('show-shop-sell');

Route::post('/shop/sell/{id}', [ShopSellController::class, 'shopSell'])
    ->name('shop-sell');

Route::get('/shop/coupons/{id}', [CouponController::class, 'showCoupons'])->name('show-coupons');

Route::get('/shop/coupon/{id}', [CouponController::class, 'showCouponForm'])->name('show-create-coupon');

Route::post('/shop/coupon/{id}', [CouponController::class, 'createCoupon'])->name('create-coupon');

Route::delete('/shop/coupon/delete/{coupon}', [CouponController::class, 'couponDestroy'])->name('coupon-destroy');

Route::get('/shop/{id}', [ShopController::class, 'showShopToppage'])
->middleware(['auth', 'check.user.staff'])
->name('shop-toppage');

Route::get('/shop/item/{id}', [ShopItemController::class, 'showShopItem'])->name('shop-item');

Route::delete('/shop/item/delete/{item}', [ShopItemController::class, 'shopItemDestroy'])
->middleware(['auth', 'check.user.staff'])
->name('shop-item-destroy');

Route::get('/contact/{id}', [ContactController::class, 'showContactForm'])
->middleware(['auth', 'check.user.staff'])
->name('contact');

Route::post('/contact/{id}', [ContactController::class, 'sendEmail'])
->middleware(['auth', 'check.user.staff'])
->name('shop-send-mail');

Route::post('/shop/contact/{id}', [ShopContactController::class, 'sendEmailToUser'])->name('shop-send-mail-to-user');

Route::get('/shop/contact/{id}', [ShopContactController::class, 'showContact'])->name('show-mails');

Route::get('/shop/contact/user/{id}', [ShopContactController::class, 'showContactForm'])->name('user-contents');

Route::get('/shop/contact/done/{id}', [ShopContactController::class, 'shopContactDone'])->name('contact-done');

Route::get('/items/sale', [ItemController::class, 'getSaleItems']);