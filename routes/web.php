<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NovelController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ReadingHistoryController;
use App\Http\Controllers\Reader\AuthorRequestController;
use App\Http\Controllers\Admin\AdminController as AdminController;
use App\Http\Controllers\Admin\AuthorController as AdminAuthorController; 
use App\Http\Controllers\Admin\NovelController as AdminNovelController;
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\ReaderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Author\DashboardController as AuthorDashboardController;
use App\Http\Controllers\Author\NovelController as AuthorNovelController;
use App\Http\Controllers\Author\ChapterController as AuthorChapterController;
use App\Http\Controllers\Author\CommentController as AuthorCommentController;
use App\Http\Controllers\Author\ProfileController as AuthorProfileController;
use Illuminate\Support\Facades\Route;

//login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

//register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

//logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// halaman utama → daftar novel
Route::get('/', [NovelController::class, 'index']);

// detail novel
Route::get('/novel/{id}', [NovelController::class, 'show'])->name('novel.show');

// filter genre
Route::get('/genre/{genre_id}', [NovelController::class, 'byGenre']);

// baca chapter
Route::get('/chapter/{id}', [ChapterController::class, 'show'])->name('chapter.show');

// komentar (harus login)
Route::post('/comment', [CommentController::class, 'store'])
    ->middleware('auth');

// bookmark (harus login)
Route::post('/bookmark/{novel_id}', [BookmarkController::class, 'toggle'])
    ->middleware('auth');

// riwayat baca
Route::get('/history', [ReadingHistoryController::class, 'index'])
    ->middleware('auth');

Route::get('/home', function () {
    return redirect('/');
});

// ADMIN
Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        //DASHBOARD
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');
        // AUTHOR
        Route::get('/authors', [AdminAuthorController::class, 'index'])
            ->name('author.index');
        Route::post('/authors/{id}/toggle', [AdminAuthorController::class, 'toggle'])
            ->name('authors.toggle');
        Route::post('/authors/{id}/block', [AdminAuthorController::class, 'block'])
            ->name('authors.block');
        Route::delete('/authors/{id}', [AdminAuthorController::class, 'destroy'])
            ->name('authors.destroy');
        Route::get('/authors/{id}', [AdminAuthorController::class, 'show'])
            ->name('authors.show');
        // READER 
        Route::get('/readers', [ReaderController::class, 'index'])->name('reader.index');
        Route::get('/readers/{id}', [ReaderController::class, 'show'])->name('reader.show');
        Route::get('/readers/{id}/edit', [ReaderController::class, 'edit'])->name('reader.edit');
        Route::put('/readers/{id}', [ReaderController::class, 'update'])->name('reader.update');
        Route::post('/readers/{id}/approve', [ReaderController::class, 'approve'])->name('reader.approve');
        Route::post('/readers/{id}/reject', [ReaderController::class, 'reject'])->name('reader.reject');
        Route::post('/readers/{id}/block', [ReaderController::class, 'block'])->name('reader.block');
        Route::delete('/readers/{id}', [ReaderController::class, 'destroy'])->name('reader.destroy');
        // NOVEL
        Route::get('/novels', [AdminNovelController::class, 'index'])
            ->name('novels.index');
        Route::get('/novels/{id}/edit', [AdminNovelController::class, 'edit'])
            ->name('novels.edit');
        Route::put('/novels/{id}', [AdminNovelController::class, 'update'])
            ->name('novels.update');
        Route::delete('/novels/{id}', [AdminNovelController::class, 'destroy'])
            ->name('novels.destroy');
        Route::post('/novels/{id}/status', [AdminNovelController::class, 'updateStatus'])
            ->name('novels.updateStatus');
        // GENRE
        Route::get('/genres', [AdminGenreController::class, 'index'])
            ->name('genre.index');
        Route::get('/genres/create', [AdminGenreController::class, 'create'])
            ->name('genre.create');
        Route::post('/genres', [AdminGenreController::class, 'store'])
            ->name('genre.store');
        Route::get('/genres/{id}/edit', [AdminGenreController::class, 'edit'])
            ->name('genre.edit');
        Route::put('/genres/{id}', [AdminGenreController::class, 'update'])
            ->name('genre.update');
        Route::delete('/genres/{id}', [AdminGenreController::class, 'destroy'])
            ->name('genre.destroy');
        // REPORT
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');
        Route::post('/reports/{id}/{status}', [ReportController::class, 'updateStatus'])
            ->name('reports.updateStatus');
    });

    Route::middleware(['auth','role:author'])
    ->prefix('author')
    ->name('author.')
    ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [AuthorDashboardController::class, 'index'])
            ->name('dashboard');
        // NOVEL
        Route::get('/novels', [AuthorNovelController::class, 'index'])
            ->name('novel.index');
        Route::get('/novels/create', [AuthorNovelController::class, 'create'])
            ->name('novel.create');
        Route::post('/novels', [AuthorNovelController::class, 'store'])
            ->name('novel.store');
        Route::get('/novels/{id}/edit', [AuthorNovelController::class, 'edit'])
            ->name('novel.edit');
        Route::put('/novels/{id}', [AuthorNovelController::class, 'update'])
            ->name('novel.update');
        // CHAPTER (per novel)
        Route::get('/novels/{novel_id}/chapters', [AuthorChapterController::class, 'index'])
            ->name('chapter.index');
        Route::get('/novels/{novel_id}/chapters/create', [AuthorChapterController::class, 'create'])
            ->name('chapter.create');
        Route::post('/chapters', [AuthorChapterController::class, 'store'])
            ->name('chapter.store');
        Route::get('/chapters/{id}/edit', [AuthorChapterController::class, 'edit'])
            ->name('chapter.edit');
        Route::put('/chapters/{id}', [AuthorChapterController::class, 'update'])
            ->name('chapter.update');
        Route::delete('/chapters/{id}', [AuthorChapterController::class, 'destroy'])
            ->name('chapter.destroy');
        // KOMENTAR
        Route::get('/comments', [AuthorCommentController::class, 'index'])
            ->name('comment.index');
        Route::delete('/comments/{id}', [AuthorCommentController::class, 'destroy'])
            ->name('comment.destroy');
        // PROFILE
        Route::get('/profile', [AuthorProfileController::class, 'index'])
            ->name('profile.index');
        Route::post('/profile', [AuthorProfileController::class, 'update'])
            ->name('profile.update');
    });

// READER - Author Request
Route::middleware(['auth','role:reader'])
    ->prefix('reader')
    ->name('reader.')
    ->group(function () {
        // Author Request
        Route::get('/author-request', [AuthorRequestController::class, 'index'])->name('author-request');
        Route::post('/author-request', [AuthorRequestController::class, 'submit'])->name('author-request.submit');
        Route::post('/author-request/reapply', [AuthorRequestController::class, 'reapply'])->name('author-request.reapply');
        Route::post('/author-request/cancel', [AuthorRequestController::class, 'cancel'])->name('author-request.cancel');
    });

