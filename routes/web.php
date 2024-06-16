<?php

use App\Http\Controllers\BuscarFlujoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\TipoTramiteController;
use App\Http\Controllers\FlujoTramiteController;
use App\Http\Controllers\FlujoDocumentoController;
use App\Http\Controllers\DocumentosEnvController;
use App\Http\Controllers\DocumentosReciController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\DocumentosController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        // Crear una instancia del controlador
        $controller = new StatisticsController();
        // Obtener los datos llamando al método index
        $data = $controller->index();

        // Devolver la vista con los datos
        return view('dashboard', $data);
    })->name('dashboard');

    // Otras rutas autenticadas existentes
    Route::group(['middleware' => ['auth']], function () {
        Route::resource('permissions', App\Http\Controllers\PermissionController::class);
        Route::delete('permissions/{id}', [App\Http\Controllers\PermissionController::class, 'permissions.destroy']);

        Route::resource('roles', App\Http\Controllers\RoleController::class);
        Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
        Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
        Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

        Route::resource('users', App\Http\Controllers\UserController::class);
        Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);
        Route::post('users/{user}/toggleStatus', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggleStatus');

        Route::resource('documentos', DocumentosController::class);
        Route::get('documentos', [DocumentosController::class, 'index'])->name('documentos.index');
        Route::post('documentos', 'DocumentosController@store')->name('documentos.store');
        Route::get('documentos/{id}', [DocumentosController::class, 'show'])->name('documentos.show');
        Route::get('documentos/edit/{id}', [DocumentosController::class, 'edit'])->name('documentos.edit');
        Route::post('documentos', [DocumentosController::class, 'store'])->name('documentos.store');
        Route::put('documentos/update/{id}', [DocumentosController::class, 'update'])->name('documentos.update');
        Route::delete('documentos/{id}', [DocumentosController::class, 'destroy'])->name('documentos.destroy');
        Route::get('documentos/show/{id}', [DocumentosController::class, 'create'])->name('documentos.show');
        Route::get('documentos/download/{id}', [DocumentosController::class, 'downloadPdf'])->name('documentos.download');
        Route::get('/generate-cite', [DocumentosController::class, 'generateCite'])->name('generateCite');
        Route::resource('gestion', App\Http\Controllers\GestionController::class);

        Route::get('/dashboard/programas', [ProgramaController::class, 'index'])->name('programas.index');
        Route::get('/dashboard/programas/create', [ProgramaController::class, 'create'])->name('programas.create');
        Route::post('/dashboard/programas', [ProgramaController::class, 'store'])->name('programas.store');
        Route::get('/dashboard/programas/{id}', [ProgramaController::class, 'show'])->name('programas.show');
        Route::get('/dashboard/programas/{id}/edit', [ProgramaController::class, 'edit'])->name('programas.edit');
        Route::put('/dashboard/programas/{id}', [ProgramaController::class, 'update'])->name('programas.update');
        Route::delete('/dashboard/programas/destroy/{id}', [ProgramaController::class, 'destroy'])->name('programas.destroy');

    });


});

Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');
