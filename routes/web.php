<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PencarianController;
use App\Http\Controllers\InputPetaController;
use App\Http\Controllers\EditPetaController;
use App\Http\Controllers\InputKegiatanController;
use App\Http\Controllers\ExampleController;

Route::get('/', function () {
    // return view('welcome');
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    return redirect()->route('dashboard');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/kondisi-wb', [DashboardController::class, 'getKondisiWB']);
    Route::get('/dashboard/kondisi-ws', [DashboardController::class, 'getKondisiWS']);
    
    Route::get('/input-kegiatan', [InputKegiatanController::class, 'index'])->name('input-kegiatan');
    Route::post('input-kegiatan', [InputKegiatanController::class, 'store']);

    Route::get('/input-peta', [InputPetaController::class, 'index'])->name('input-peta');
    Route::post('/input-peta/preview', [InputPetaController::class, 'showPreview'])->name('input-peta.preview');
    Route::post('/input-peta/store', [InputPetaController::class, 'store'])->name('input-peta.store');

    Route::get('/pencarian-peta', [PencarianController::class, 'index'])->name('pencarian-peta');
    Route::get('/pencarian-peta/cari', [PencarianController::class, 'searchPeta'])->name('pencarian-peta.cari');

    Route::get('/edit-peta', [EditPetaController::class, 'index'])->name('edit-peta');
    Route::get('/edit-peta/get-kegiatan/{jenis_peta}', [EditPetaController::class, 'getKegiatan']);
    Route::get('/edit-peta/get-bulan/{jenis_peta}/{kode_kegiatan}', [EditPetaController::class, 'getBulan']);
    Route::get('/edit-peta/get-tahun/{jenis_peta}/{kode_kegiatan}/{bulan_kegiatan}', [EditPetaController::class, 'getTahun']);
    Route::get('/edit-peta/get-link/{jenis_peta}/{kode_kegiatan}/{bulan_kegiatan}/{tahun_kegiatan}', [EditPetaController::class, 'getLink']);
    Route::get('/edit-peta/get-prev-baru', [EditPetaController::class, 'getPrevBaru']);
    Route::post('/edit-peta/submit', [EditPetaController::class, 'submit']);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changepassword'])->name('profile.change-password');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::get('/blank-page', [App\Http\Controllers\HomeController::class, 'blank'])->name('blank');

    Route::get('/hakakses', [App\Http\Controllers\HakaksesController::class, 'index'])->name('hakakses.index')->middleware('superadmin');
    Route::get('/hakakses/edit/{id}', [App\Http\Controllers\HakaksesController::class, 'edit'])->name('hakakses.edit')->middleware('superadmin');
    Route::put('/hakakses/update/{id}', [App\Http\Controllers\HakaksesController::class, 'update'])->name('hakakses.update')->middleware('superadmin');
    Route::delete('/hakakses/delete/{id}', [App\Http\Controllers\HakaksesController::class, 'destroy'])->name('hakakses.delete')->middleware('superadmin');

    Route::get('/table-example', [App\Http\Controllers\ExampleController::class, 'table'])->name('table.example');
    Route::get('/clock-example', [App\Http\Controllers\ExampleController::class, 'clock'])->name('clock.example');
    Route::get('/chart-example', [App\Http\Controllers\ExampleController::class, 'chart'])->name('chart.example');
    Route::get('/form-example', [App\Http\Controllers\ExampleController::class, 'form'])->name('form.example');
    Route::get('/map-example', [App\Http\Controllers\ExampleController::class, 'map'])->name('map.example');
    Route::get('/calendar-example', [App\Http\Controllers\ExampleController::class, 'calendar'])->name('calendar.example');
    Route::get('/gallery-example', [App\Http\Controllers\ExampleController::class, 'gallery'])->name('gallery.example');
    Route::get('/todo-example', [App\Http\Controllers\ExampleController::class, 'todo'])->name('todo.example');
    Route::get('/contact-example', [App\Http\Controllers\ExampleController::class, 'contact'])->name('contact.example');
    Route::get('/faq-example', [App\Http\Controllers\ExampleController::class, 'faq'])->name('faq.example');
    Route::get('/news-example', [App\Http\Controllers\ExampleController::class, 'news'])->name('news.example');
    Route::get('/about-example', [App\Http\Controllers\ExampleController::class, 'about'])->name('about.example');
});