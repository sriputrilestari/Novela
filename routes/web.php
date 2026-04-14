<?php

use App\Http\Controllers\Admin\AdminController;

// =============================================================================
// CONTROLLERS
// =============================================================================

// Auth
use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;

// admin
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\NovelController as AdminNovelController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReaderController as AdminReaderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\AuthController;

// author
use App\Http\Controllers\Author\ChapterController as AuthorChapterController;
use App\Http\Controllers\Author\DashboardController as AuthorDashboardController;
use App\Http\Controllers\Author\NovelController as AuthorNovelController;
use App\Http\Controllers\Author\ProfileController as AuthorProfileController;
use App\Http\Controllers\Author\ReportController as AuthorReportController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ChapterController;

// reader
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NovelController;
use App\Http\Controllers\Reader\AuthorRequestController;
use App\Http\Controllers\Reader\ProfileController as ReaderProfileController;
use App\Http\Controllers\Reader\ReportController as ReaderReportController;
use App\Http\Controllers\ReadingHistoryController;
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
Route::get('/', [NovelController::class, 'home'])->name('home');
Route::get('/jelajahi', [NovelController::class, 'search'])->name('search');
Route::get('/genre', [NovelController::class, 'genres'])->name('genres');
Route::get('/genre/{genre_id}', [NovelController::class, 'byGenre'])->name('genre.show');
Route::get('/novel/{id}', [NovelController::class, 'show'])->name('novel.show');
Route::get('/novel/{id}/baca', [NovelController::class, 'reader'])->name('reader.read');
Route::post('/novel/{id}/rate', [NovelController::class, 'rate'])->name('novel.rate');
Route::get('/chapter/{id}', [ChapterController::class, 'show'])->name('chapter.show');

// redirect home
Route::get('/home', fn() => redirect('/'));

// =============================================================================
// AUTHENTICATED (SEMUA ROLE)
// =============================================================================
Route::middleware('auth')->group(function () {

    Route::post('/comment', [CommentController::class, 'store']);

    Route::post('/bookmark/{novel_id}', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    Route::get('/favorit', [BookmarkController::class, 'index'])->name('favorites');

    Route::get('/history', [ReadingHistoryController::class, 'index'])->name('history');
    Route::post('/novel/{id}/report', [ReaderReportController::class, 'store'])->name('novel.report');
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
        Route::get('/author', [AdminAuthorController::class, 'index'])->name('author.index');
        Route::get('/author/{id}', [AdminAuthorController::class, 'show'])->name('author.show');
        Route::post('/author/{id}/toggle', [AdminAuthorController::class, 'toggle'])->name('author.toggle');
        Route::post('/author/{id}/block', [AdminAuthorController::class, 'block'])->name('author.block');
        Route::delete('/author/{id}', [AdminAuthorController::class, 'destroy'])->name('author.destroy');

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

        // REPORTS
        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
        Route::post('reports/{report}/review', [AdminReportController::class, 'review'])->name('reports.review');
        Route::post('reports/{report}/warn', [AdminReportController::class, 'warn'])->name('reports.warn');
        Route::post('reports/{report}/reject', [AdminReportController::class, 'reject'])->name('reports.reject');
        Route::delete('reports/{report}/novel', [AdminReportController::class, 'deleteNovel'])->name('reports.deleteNovel');

        // Profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });

// =============================================================================
// AUTHOR
// =============================================================================
Route::middleware(['auth', 'role:author'])
    ->prefix('author')
    ->name('author.')
    ->group(function () {

        Route::get('/dashboard', [AuthorDashboardController::class, 'index'])->name('dashboard');

        // NOVEL
        Route::get('/novels', [AuthorNovelController::class, 'index'])->name('novel.index');
        Route::get('/novels/create', [AuthorNovelController::class, 'create'])->name('novel.create');
        Route::post('/novels', [AuthorNovelController::class, 'store'])->name('novel.store');
        Route::get('/novels/{novel}/edit', [AuthorNovelController::class, 'edit'])->name('novel.edit');
        Route::put('/novels/{novel}', [AuthorNovelController::class, 'update'])->name('novel.update');
        Route::delete('/novels/{novel}', [AuthorNovelController::class, 'destroy'])->name('novel.destroy');

        // CHAPTER
        Route::prefix('/novels/{novel}/chapters')->group(function () {
            Route::get('/', [AuthorChapterController::class, 'index'])->name('chapter.index');
            Route::get('/create', [AuthorChapterController::class, 'create'])->name('chapter.create');
            Route::post('/', [AuthorChapterController::class, 'store'])->name('chapter.store');

            Route::get('/{chapter}', [AuthorChapterController::class, 'show'])->name('chapter.show');
            Route::get('/{chapter}/edit', [AuthorChapterController::class, 'edit'])->name('chapter.edit');
            Route::put('/{chapter}', [AuthorChapterController::class, 'update'])->name('chapter.update');
            Route::delete('/{chapter}', [AuthorChapterController::class, 'destroy'])->name('chapter.destroy');
            Route::post('/{chapter}/toggle', [AuthorChapterController::class, 'toggle'])->name('chapter.toggle');
        });

        // PROFILE
        Route::get('profile', [AuthorProfileController::class, 'index'])->name('profile.index');
        Route::post('profile/update', [AuthorProfileController::class, 'update'])->name('profile.update');
        Route::post('profile/password', [AuthorProfileController::class, 'updatePassword'])->name('profile.password');

        // COMMENT
        Route::get('/comments', [\App\Http\Controllers\Author\CommentController::class, 'index'])->name('comment.index');
        // Route::get('/comments/{id}', [\App\Http\Controllers\Author\CommentController::class, 'show'])->name('comment.show');
        Route::post('/comments/{id}/reply', [\App\Http\Controllers\Author\CommentController::class, 'reply'])->name('comment.reply');
        Route::patch('/comments/{id}/toxic', [\App\Http\Controllers\Author\CommentController::class, 'markToxic'])->name('comment.toxic');
        Route::delete('/comments/{id}', [\App\Http\Controllers\Author\CommentController::class, 'destroy'])->name('comment.destroy');

        // REPORTS
        Route::get('/reports', [AuthorReportController::class, 'index'])->name('report.index');
        Route::get('/reports/{id}', [AuthorReportController::class, 'show'])->name('report.show');
    });

// =============================================================================
// READER
// =============================================================================
Route::middleware(['auth', 'role:reader'])
    ->prefix('reader')
    ->name('reader.')
    ->group(function () {

        Route::get('author-request', [AuthorRequestController::class, 'index'])->name('author-request');
        Route::post('author-request', [AuthorRequestController::class, 'submit'])->name('author-request.submit');
        Route::post('author-request/reapply', [AuthorRequestController::class, 'reapply'])->name('author-request.reapply');
        Route::post('author-request/cancel', [AuthorRequestController::class, 'cancel'])->name('author-request.cancel');

        Route::get('profile', [ReaderProfileController::class, 'index'])->name('profile.index');
        Route::post('profile/update', [ReaderProfileController::class, 'update'])->name('profile.update');
        Route::post('profile/password', [ReaderProfileController::class, 'updatePassword'])->name('profile.password');

    });
