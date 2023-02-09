<?php

// FRONT-END ROUTES
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Http\Controllers\Agent\PropertyController as AgentPropertyController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\FrontpageController;
use App\Http\Controllers\PagesController;


Route::get('/',  [FrontpageController::class, 'index'])->name('home');
Route::get('/slider',  [FrontpageController::class, 'slider'])->name('slider.index');

Route::get('/search',  [FrontpageController::class, 'search'])->name('search');

Route::get('/property',  [PagesController::class, 'properties'])->name('property');
Route::get('/property/{id}',  [PagesController::class, 'propertieshow'])->name('property.show');
Route::post('/property/message',  [PagesController::class, 'messageAgent'])->name('property.message');
Route::post('/property/comment/{id}',  [PagesController::class, 'propertyComments'])->name('property.comment');
Route::post('/property/rating',  [PagesController::class, 'propertyRating'])->name('property.rating');
Route::get('/property/city/{cityslug}',  [PagesController::class, 'propertyCities'])->name('property.city');

Route::get('/agents',  [PagesController::class, 'agents'])->name('agents');
Route::get('/agents/{id}',  [PagesController::class, 'agentshow'])->name('agents.show');

Route::get('/gallery',  [PagesController::class, 'gallery'])->name('gallery');

Route::get('/blog',  [PagesController::class, 'blog'])->name('blog');
Route::get('/blog/{id}',  [PagesController::class, 'blogshow'])->name('blog.show');
Route::post('/blog/comment/{id}',  [PagesController::class, 'blogComments'])->name('blog.comment');

Route::get('/blog/categories/{slug}',  [PagesController::class, 'blogCategories'])->name('blog.categories');
Route::get('/blog/tags/{slug}',  [PagesController::class, 'blogTags'])->name('blog.tags');
Route::get('/blog/author/{username}',  [PagesController::class, 'blogAuthor'])->name('blog.author');

Route::get('/contact',  [PagesController::class, 'contact'])->name('contact');
Route::post('/contact',  [PagesController::class, 'messageContact'])->name('contact.message');


Auth::routes();

// ADMIN
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth','admin'],'as'=>'admin.'], function(){

    Route::get('dashboard',  [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('tags', TagController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
    Route::resource('features', FeatureController::class);
    Route::resource('properties', PropertyController::class);
    Route::post('properties/gallery/delete',  [PropertyController::class, 'galleryImageDelete'])->name('gallery-delete');

    Route::resource('sliders', SliderController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('testimonials', TestimonialController::class);

    Route::get('galleries/album',  [GalleryController::class, 'album'])->name('album');
    Route::post('galleries/album/store',  [GalleryController::class, 'albumStore'])->name('album.store');
    Route::get('galleries/{id}/gallery',  [GalleryController::class, 'albumGallery'])->name('album.gallery');
    Route::post('galleries',  [GalleryController::class, 'Gallerystore'])->name('galleries.store');

    Route::get('settings',  [DashboardController::class, 'settings'])->name('settings');
    Route::post('settings',  [DashboardController::class, 'settingStore'])->name('settings.store');

    Route::get('profile',  [DashboardController::class, 'profile'])->name('profile');
    Route::post('profile',  [DashboardController::class, 'profileUpdate'])->name('profile.update');

    Route::get('message',  [DashboardController::class, 'message'])->name('message');
    Route::get('message/read/{id}',  [ DashboardController::class, 'messageRead'])->name('message.read');
    Route::get('message/replay/{id}',  [DashboardController::class, 'messageReplay'])->name('message.replay');
    Route::post('message/replay',  [DashboardController::class, 'messageSend'])->name('message.send');
    Route::post('message/readunread',  [DashboardController::class, 'messageReadUnread'])->name('message.readunread');
    Route::delete('message/delete/{id}',  [DashboardController::class, 'messageDelete'])->name('messages.destroy');
    Route::post('message/mail',  [DashboardController::class, 'contactMail'])->name('message.mail');

    Route::get('changepassword',  [DashboardController::class, 'changePassword'])->name('changepassword');
    Route::post('changepassword',  [DashboardController::class, 'changePasswordUpdate'])->name('changepassword.update');

});

Route::group(['prefix'=>'agent','namespace'=>'Agent','middleware'=>['auth','agent'],'as'=>'agent.'], function(){

    Route::get('dashboard',  [AgentDashboardController::class, 'index'])->name('dashboard');
    Route::get('profile',  [AgentDashboardController::class, 'profile'])->name('profile');
    Route::post('profile',  [AgentDashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::get('changepassword',  [AgentDashboardController::class, 'changePassword'])->name('changepassword');
    Route::post('changepassword',  [AgentDashboardController::class, 'changePasswordUpdate'])->name('changepassword.update');
    Route::resource('properties', AgentPropertyController::class);
    Route::post('properties/gallery/delete',  [AgentPropertyController::class, 'galleryImageDelete'])->name('gallery-delete');

    Route::get('message',  [AgentDashboardController::class, 'message'])->name('message');
    Route::get('message/read/{id}',  [AgentDashboardController::class, 'messageRead'])->name('message.read');
    Route::get('message/replay/{id}',  [AgentDashboardController::class, 'messageReplay'])->name('message.replay');
    Route::post('message/replay',  [AgentDashboardController::class, 'messageSend'])->name('message.send');
    Route::post('message/readunread',  [AgentDashboardController::class, 'messageReadUnread'])->name('message.readunread');
    Route::delete('message/delete/{id}',  [AgentDashboardController::class, 'messageDelete'])->name('messages.destroy');
    Route::post('message/mail',  [AgentDashboardController::class, 'contactMail'])->name('message.mail');

});

Route::group(['prefix'=>'user','namespace'=>'User','middleware'=>['auth','user'],'as'=>'user.'], function(){

    Route::get('dashboard',  [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('profile',  [UserDashboardController::class, 'profile'])->name('profile');
    Route::post('profile',  [UserDashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::get('changepassword',  [UserDashboardController::class, 'changePassword'])->name('changepassword');
    Route::post('changepassword',  [UserDashboardController::class, 'changePasswordUpdate'])->name('changepassword.update');

    Route::get('message',  [UserDashboardController::class, 'message'])->name('message');
    Route::get('message/read/{id}',  [UserDashboardController::class, 'messageRead'])->name('message.read');
    Route::get('message/replay/{id}',  [UserDashboardController::class, 'messageReplay'])->name('message.replay');
    Route::post('message/replay',  [UserDashboardController::class, 'messageSend'])->name('message.send');
    Route::post('message/readunread',  [UserDashboardController::class, 'messageReadUnread'])->name('message.readunread');
    Route::delete('message/delete/{id}',  [UserDashboardController::class, 'messageDelete'])->name('messages.destroy');

});
