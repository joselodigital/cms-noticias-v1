<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/news-sitemap.xml', [SitemapController::class, 'news'])->name('sitemap.news');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/noticias', [NewsController::class, 'index'])->name('news.index');
Route::get('/noticias/{post:slug}', [NewsController::class, 'show'])->name('news.show');
Route::post('/noticias/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/categoria/{category:slug}', [NewsController::class, 'category'])->name('news.category');
Route::get('/tag/{tag:slug}', [NewsController::class, 'tag'])->name('news.tag');
Route::get('/autor/{user}', [NewsController::class, 'author'])->name('news.author');
Route::get('/p/{slug}', [App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
Route::get('/contacto', [App\Http\Controllers\ContactController::class, 'show'])->name('contact.show');
Route::post('/contacto', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->hasAnyRole(['super-admin', 'admin', 'editor'])) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:super-admin|admin|editor'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::post('/posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload_image');
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('users', UserController::class)->middleware('role:super-admin|admin');
    
    // Rutas de Comentarios en Admin
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{comment}/toggle-approval', [AdminCommentController::class, 'toggleApproval'])->name('comments.toggle-approval');
    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
    
    // Rutas de Banners
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class);

    // Rutas de Configuración del Sitio
    Route::get('/settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('settings.update');

    // Rutas de Redes Sociales
    Route::resource('social_links', App\Http\Controllers\Admin\SocialLinkController::class);

    // Rutas de Páginas Estáticas
    Route::resource('pages', App\Http\Controllers\Admin\PageController::class);

    // Rutas de Mensajes de Contacto
    Route::resource('messages', App\Http\Controllers\Admin\ContactMessageController::class)->only(['index', 'show', 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
