<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AdoptionMatchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Org\OrganizationController;
use App\Http\Controllers\Org\OrgAuthController;
use App\Http\Controllers\Org\OrgChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ChatController as UserChatController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\UserMatchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/animals', [AnimalController::class, 'index'])
    ->middleware(['auth:web,org'])
    ->name('animals');
Route::get('/animals/{id}', [AnimalController::class, 'show'])
    ->middleware(['auth:web,org'])
    ->name('animals.show');

Route::middleware('auth:org')->group(function () {
    Route::post('org/logout', [OrgAuthController::class, 'logout'])->name('org.logout');
    Route::get('/org/mypage', [OrganizationController::class, 'mypage'])->name('org.mypage');
    Route::get('/org/mypage/edit', [OrganizationController::class, 'edit'])->name('org.mypage.edit');
    Route::post('/org/mypage/update', [OrganizationController::class, 'update'])->name('org.mypage.update');
    Route::get('dashboard', [OrganizationController::class, 'index'])->name('dashboard');

    Route::get('/org/animals/create', [AnimalController::class, 'create'])->name('org.animals.create');
    Route::post('/org/animals', [AnimalController::class, 'store'])->name('org.animals.store');

    Route::get('/org/animals/{animal}/edit', [AnimalController::class, 'edit'])->name('org.animals.edit');
    Route::put('/org/animals/{animal}', [AnimalController::class, 'update'])->name('org.animals.update');
    Route::delete('/org/animals/{animal}', [AnimalController::class, 'destroy'])->name('org.animals.destroy');

    Route::get('/org/favorite', [AdoptionMatchController::class, 'favoriteIndex'])->name('org.favorite.index');
    Route::get('/org/match', [AdoptionMatchController::class, 'matchIndex'])->name('org.match.index');
    Route::post('/org/match/{favorite}', [AdoptionMatchController::class, 'approve'])->name('org.match.approve');
    Route::patch('/match/{match}/status', [AdoptionMatchController::class, 'updateStatus'])->name('org.match.status.update');

    Route::get('/org/chat', [OrgChatController::class, 'index'])->name('org.chat.index');
    Route::get('/org/chat/{match}', [OrgChatController::class, 'show'])->name('org.chat.show');
    Route::post('/org/chat/{match}', [OrgChatController::class, 'store'])->name('org.chat.store');

    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth:web')->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');
    Route::get('/mypage', [UserController::class, 'mypage'])->name('user.mypage');
    Route::get('/mypage/edit', [UserController::class, 'edit'])->name('mypage.edit');
    Route::post('/mypage/update', [UserController::class, 'update'])->name('mypage.update');

    Route::post('/favorites/{animal}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::delete('/matches/{match}', [AdoptionMatchController::class, 'destroy'])->name('matches.destroy');

    Route::get('/chat', [UserChatController::class, 'index'])->name('user.chat.index');
    Route::get('/chat/{match}', [UserChatController::class, 'show'])->name('user.chat.show');
    Route::post('/chat/{match}', [UserChatController::class, 'store'])->name('user.chat.store');
});

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register'); 
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/org/register', [HomeController::class, 'orgRegister']);

Route::post('/user/login', [UserAuthController::class, 'login'])->name('user.login');
Route::post('/org/login', [OrgAuthController::class, 'login'])->name('org.login');

require __DIR__.'/auth.php';