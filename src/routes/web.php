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

Route::get('/mypage', [MypageController::class, 'create'])->name('mypage');

Route::get('/mypage/profile', [ProfileController::class, 'create'])->name('profile');

Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('update-profile');

Route::get('/sell', [SellController::class, 'showSellForm'])->name('show-sell');

Route::post('/sell', [SellController::class, 'sell'])->name('sell');

Route::get('/item/{id}', [ItemController::class, 'detail'])->name('detail');

Route::post('/mylist/toggle', [MylistController::class, 'toggle'])->name('mylist.toggle');

Route::get('/comment/{id}', [CommentController::class, 'showCommentForm'])->name('show-comment');

Route::post('/comment/{id}', [CommentController::class, 'comment'])->name('comment');

Route::get('/purchage/{id}', [PurchaseController::class, 'showPurchageForm'])
    ->name('show-purchage');

Route::get('/card/{id}', [PaymentController::class, 'showCardForm'])->name('card');

Route::get('/bank/{id}', [PaymentController::class, 'showBankForm'])->name('bank');

Route::get('/convenience/{id}', [PaymentController::class, 'showConvenienceForm'])->name('convenience');

Route::match(['get', 'post'], '/payment-success/{id}', [PaymentController::class, 'success'])->name('payment-success');


Route::get('/address/{id}', [AddressController::class, 'showChangeAddressForm'])->name('show-change-address');

Route::post('/address/{id}', [AddressController::class, 'changeAddress'])->name('change-address');

Route::get('/search', [SearchController::class,'search'])->name('search');
