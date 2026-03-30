<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\NovelController as AdminNovelController;
use App\Http\Controllers\Admin\ReaderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\AuthController;

// Admin
use App\Http\Controllers\Author\ChapterController as AuthorChapterController;
use App\Http\Controllers\Author\CommentController as AuthorCommentController;
use App\Http\Controllers\Author\DashboardController as AuthorDashboardController;
use App\Http\Controllers\Author\NovelController as AuthorNovelController;
use App\Http\Controllers\Author\ProfileController as AuthorProfileController;
use App\Http\Controllers\BookmarkController;

// Author
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NovelController;
use App\Http\Controllers\Reader\AuthorRequestController;
use App\Http\Controllers\ReadingHistoryController;

// Reader
use Illuminate\Support\Facades\Route;

// ------------------------
// AUTH ROUTES
// ------------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ------------------------
// PUBLIC NOVEL ROUTES
// ------------------------
Route::get('/', [NovelController::class, 'index']);
Route::get('/novel/{id}', [NovelController::class, 'show'])->name('novel.show');
Route::get('/genre/{genre_id}', [NovelController::class, 'byGenre']);
Route::get('/chapter/{id}', [ChapterController::class, 'show'])->name('chapter.show');

// ------------------------
// AUTHENTICATED USER ROUTES
// ------------------------
Route::middleware('auth')->group(function () {
    Route::post('/comment', [CommentController::class, 'store']);
    Route::post('/bookmark/{novel_id}', [BookmarkController::class, 'toggle']);
    Route::get('/history', [ReadingHistoryController::class, 'index']);
});

// ------------------------
// ADMIN ROUTES
// ------------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Authors
        Route::get('/authors', [AdminAuthorController::class, 'index'])->name('author.index');
        Route::get('/authors/{id}', [AdminAuthorController::class, 'show'])->name('authors.show');
        Route::post('/authors/{id}/toggle', [AdminAuthorController::class, 'toggle'])->name('authors.toggle');
        Route::post('/authors/{id}/block', [AdminAuthorController::class, 'block'])->name('authors.block');
        Route::delete('/authors/{id}', [AdminAuthorController::class, 'destroy'])->name('authors.destroy');

        // Readers
        Route::get('/readers', [ReaderController::class, 'index'])->name('reader.index');
        Route::get('/readers/{id}', [ReaderController::class, 'show'])->name('reader.show');
        Route::get('/readers/{id}/edit', [ReaderController::class, 'edit'])->name('reader.edit');
        Route::put('/readers/{id}', [ReaderController::class, 'update'])->name('reader.update');
        Route::post('/readers/{id}/approve', [ReaderController::class, 'approve'])->name('reader.approve');
        Route::post('/readers/{id}/reject', [ReaderController::class, 'reject'])->name('reader.reject');
        Route::post('/readers/{id}/block', [ReaderController::class, 'block'])->name('reader.block');
        Route::delete('/readers/{id}', [ReaderController::class, 'destroy'])->name('reader.destroy');

        // Novels
        Route::get('/novels', [AdminNovelController::class, 'index'])->name('novels.index');
        Route::get('/novels/{id}', [AdminNovelController::class, 'show'])->name('novels.show');
        Route::delete('/novels/{id}', [AdminNovelController::class, 'destroy'])->name('novels.destroy');
        Route::post('/novels/{id}/status', [AdminNovelController::class, 'updateStatus'])->name('novels.updateStatus');

        // Genre
        Route::get('/genres', [AdminGenreController::class, 'index'])->name('genre.index');
        Route::get('/genres/create', [AdminGenreController::class, 'create'])->name('genre.create');
        Route::post('/genres', [AdminGenreController::class, 'store'])->name('genre.store');
        Route::get('/genres/{id}/edit', [AdminGenreController::class, 'edit'])->name('genre.edit');
        Route::put('/genres/{id}', [AdminGenreController::class, 'update'])->name('genre.update');
        Route::delete('/genres/{id}', [AdminGenreController::class, 'destroy'])->name('genre.destroy');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/{id}/{status}', [ReportController::class, 'updateStatus'])->name('reports.updateStatus');
    });

// ------------------------
// AUTHOR ROUTES
// ------------------------
Route::middleware(['auth', 'role:author'])
    ->prefix('author')
    ->name('author.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AuthorDashboardController::class, 'index'])->name('dashboard');

        // Novels
        Route::get('/novels', [AuthorNovelController::class, 'index'])->name('novel.index');
        Route::get('/novels/create', [AuthorNovelController::class, 'create'])->name('novel.create');
        Route::post('/novels', [AuthorNovelController::class, 'store'])->name('novel.store');
        Route::get('/novels/{id}/edit', [AuthorNovelController::class, 'edit'])->name('novel.edit');
        Route::put('/novels/{id}', [AuthorNovelController::class, 'update'])->name('novel.update');
        Route::delete('/author/novel/{novel}', [AuthorNovelController::class, 'destroy'])->name('novel.destroy');

        // Chapters per Novel
        Route::get('/novels/{novel}/chapters', [AuthorChapterController::class, 'index'])->name('chapter.index');
        Route::get('/novels/{novel}/chapters/create', [AuthorChapterController::class, 'create'])->name('chapter.create');
        Route::post('/novels/{novel}/chapters', [AuthorChapterController::class, 'store'])->name('chapter.store');
        Route::get('/novels/{novel}/chapters/{chapter}', [AuthorChapterController::class, 'show'])->name('chapter.show');
        Route::get('/novels/{novel}/chapters/{chapter}/edit', [AuthorChapterController::class, 'edit'])->name('chapter.edit');
        Route::put('/novels/{novel}/chapters/{chapter}', [AuthorChapterController::class, 'update'])->name('chapter.update');
        Route::delete('/novels/{novel}/chapters/{chapter}', [AuthorChapterController::class, 'destroy'])->name('chapter.destroy');
        Route::patch('/novels/{novel}/chapters/{chapter}/toggle', [AuthorChapterController::class, 'toggle'])->name('chapter.toggle');

        // Comments
        Route::get('/comments', [AuthorCommentController::class, 'index'])->name('comment.index');
        Route::get('/comment/{id}', [AuthorCommentController::class, 'show'])->name('comment.show');
        Route::delete('/comments/{id}', [AuthorCommentController::class, 'destroy'])->name('comment.destroy');
        Route::post('/comments/{comment}/reply', [AuthorCommentController::class, 'reply'])->name('comment.reply');

        // Profile
        Route::get('/profile', [AuthorProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [AuthorProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [AuthorProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [AuthorProfileController::class, 'updatePassword'])->name('profile.password');
    });

// ------------------------
// READER ROUTES (Author Request)
// ------------------------
Route::middleware(['auth', 'role:reader'])
    ->prefix('reader')
    ->name('reader.')
    ->group(function () {
        Route::get('/author-request', [AuthorRequestController::class, 'index'])->name('author-request');
        Route::post('/author-request', [AuthorRequestController::class, 'submit'])->name('author-request.submit');
        Route::post('/author-request/reapply', [AuthorRequestController::class, 'reapply'])->name('author-request.reapply');
        Route::post('/author-request/cancel', [AuthorRequestController::class, 'cancel'])->name('author-request.cancel');
    });

// Redirect /home → /
Route::get('/home', function () {
    return redirect('/');
});
