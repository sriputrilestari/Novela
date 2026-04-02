<?php

use App\Http\Controllers\Admin\AdminController;

// =============================================================================
// CONTROLLERS
// =============================================================================

// Auth
use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;

// Public / Reader
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\NovelController as AdminNovelController;
use App\Http\Controllers\Admin\ReaderController as AdminReaderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Author\ChapterController as AuthorChapterController;

// Admin
use App\Http\Controllers\Author\DashboardController as AuthorDashboardController;
use App\Http\Controllers\Author\NovelController as AuthorNovelController;
use App\Http\Controllers\Author\ProfileController as AuthorProfileController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ChapterController;

// Author
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NovelController;
use App\Http\Controllers\Reader\AuthorRequestController;
use App\Http\Controllers\Reader\ProfileController as ReaderProfileController;
use App\Http\Controllers\ReadingHistoryController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

// =============================================================================
// AUTH
// =============================================================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// =============================================================================
// PUBLIC (READER VIEW)
// =============================================================================
Route::get('/', [NovelController::class, 'index'])->name('home');

// 🔍 Search
Route::get('/jelajahi', [NovelController::class, 'search'])->name('search');

// 🏷️ Genre
Route::get('/genre', [NovelController::class, 'genres'])->name('genres');
Route::get('/genre/{genre_id}', [NovelController::class, 'byGenre'])->name('genre.show');

// 📖 Novel & Chapter
Route::get('/novel/{id}', [NovelController::class, 'show'])->name('novel.show');
Route::get('/novel/{id}/baca', [NovelController::class, 'reader'])->name('reader.read');
Route::get('/chapter/{id}', [ChapterController::class, 'show'])->name('chapter.show');

Route::post('/novel/{id}/rate', [NovelController::class, 'rate'])->name('novel.rate');

// redirect home
Route::get('/home', fn() => redirect('/'));

// =============================================================================
// AUTHENTICATED (SEMUA ROLE)
// =============================================================================
Route::middleware('auth')->group(function () {

    // 💬 Comment
    Route::post('/comment', [CommentController::class, 'store']);

    // ⭐ Bookmark
    Route::post('/bookmark/{novel_id}', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    Route::get('/favorit', [BookmarkController::class, 'index'])->name('favorites');

    // 📚 History
    Route::get('/history', [ReadingHistoryController::class, 'index'])->name('history');

    // 👤 Profile
    Route::get('/profil', [ReaderProfileController::class, 'index'])->name('profile');
    Route::post('/profil/update', [ReaderProfileController::class, 'update'])->name('profile.update');
    Route::post('/profil/password', [ReaderProfileController::class, 'updatePassword'])->name('profile.password');
});

// =============================================================================
// ADMIN
// =============================================================================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Authors
        Route::get('/authors', [AdminAuthorController::class, 'index'])->name('authors.index');
        Route::get('/authors/{id}', [AdminAuthorController::class, 'show'])->name('authors.show');
        Route::post('/authors/{id}/toggle', [AdminAuthorController::class, 'toggle'])->name('authors.toggle');
        Route::post('/authors/{id}/block', [AdminAuthorController::class, 'block'])->name('authors.block');
        Route::delete('/authors/{id}', [AdminAuthorController::class, 'destroy'])->name('authors.destroy');

        // Readers
        Route::get('/readers', [AdminReaderController::class, 'index'])->name('reader.index');
        Route::get('/readers/{id}', [AdminReaderController::class, 'show'])->name('reader.show');
        Route::get('/readers/{id}/edit', [AdminReaderController::class, 'edit'])->name('reader.edit');
        Route::put('/readers/{id}', [AdminReaderController::class, 'update'])->name('reader.update');
        Route::post('/readers/{id}/approve', [AdminReaderController::class, 'approve'])->name('reader.approve');
        Route::post('/readers/{id}/reject', [AdminReaderController::class, 'reject'])->name('reader.reject');
        Route::post('/readers/{id}/block', [AdminReaderController::class, 'block'])->name('reader.block');
        Route::delete('/readers/{id}', [AdminReaderController::class, 'destroy'])->name('reader.destroy');

        // Novels
        Route::get('/novels', [AdminNovelController::class, 'index'])->name('novels.index');
        Route::get('/novels/{id}', [AdminNovelController::class, 'show'])->name('novels.show');
        Route::delete('/novels/{id}', [AdminNovelController::class, 'destroy'])->name('novels.destroy');
        Route::post('/novels/{id}/status', [AdminNovelController::class, 'updateStatus'])->name('novels.updateStatus');

        // Genres
        Route::get('/genres', [AdminGenreController::class, 'index'])->name('genre.index');
        Route::get('/genres/create', [AdminGenreController::class, 'create'])->name('genre.create');
        Route::post('/genres', [AdminGenreController::class, 'store'])->name('genre.store');
        Route::get('/genres/{id}/edit', [AdminGenreController::class, 'edit'])->name('genre.edit');
        Route::put('/genres/{id}', [AdminGenreController::class, 'update'])->name('genre.update');
        Route::delete('/genres/{id}', [AdminGenreController::class, 'destroy'])->name('genre.destroy');

        // Reports
        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    });

// =============================================================================
// AUTHOR
// =============================================================================
Route::middleware(['auth', 'role:author'])
    ->prefix('author')
    ->name('author.')
    ->group(function () {

        Route::get('/dashboard', [AuthorDashboardController::class, 'index'])->name('dashboard');

        // Novel
        Route::get('/novels', [AuthorNovelController::class, 'index'])->name('novel.index');
        Route::get('/novels/create', [AuthorNovelController::class, 'create'])->name('novel.create');
        Route::post('/novels', [AuthorNovelController::class, 'store'])->name('novel.store');
        Route::get('/novels/{id}/edit', [AuthorNovelController::class, 'edit'])->name('novel.edit');
        Route::put('/novels/{id}', [AuthorNovelController::class, 'update'])->name('novel.update');
        Route::delete('/novel/{novel}', [AuthorNovelController::class, 'destroy'])->name('novel.destroy');

        // Chapter
        Route::get('/novels/{novel}/chapters', [AuthorChapterController::class, 'index'])->name('chapter.index');
        Route::get('/novels/{novel}/chapters/create', [AuthorChapterController::class, 'create'])->name('chapter.create');
        Route::post('/novels/{novel}/chapters', [AuthorChapterController::class, 'store'])->name('chapter.store');

        // Profile
        Route::get('profile', [AuthorProfileController::class, 'index'])->name('profile.index');
    });

// =============================================================================
// READER (KHUSUS ROLE)
// =============================================================================
Route::middleware(['auth', 'role:reader'])
    ->prefix('reader')
    ->name('reader.')
    ->group(function () {

        // 🔥 Author Request
        Route::get('author-request', [AuthorRequestController::class, 'index'])->name('author-request');
        Route::post('author-request', [AuthorRequestController::class, 'submit'])->name('author-request.submit');
        Route::post('author-request/reapply', [AuthorRequestController::class, 'reapply'])->name('author-request.reapply');
        Route::post('author-request/cancel', [AuthorRequestController::class, 'cancel'])->name('author-request.cancel');

        // 👤 Profile
        Route::get('profile', [ReaderProfileController::class, 'index'])->name('profile.index');
        Route::post('profile/update', [ReaderProfileController::class, 'update'])->name('profile.update');
    });
