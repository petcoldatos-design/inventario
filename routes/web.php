<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventarioController;
use App\Http\Controllers\Admin\InventarioProcesoController;
use App\Http\Controllers\Admin\ProduccionController;
use App\Http\Controllers\Admin\DespachoController;
use App\Http\Controllers\Admin\IniciarProcesoController;
use App\Http\Controllers\Admin\ProveedorBaseController;
use App\Http\Controllers\Admin\TrazabilidadController;

// ============================================
// RUTAS DE AUTENTICACIÓN
// ============================================
Route::get('/login', [CustomAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomAuthController::class, 'login']);
Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');

// ============================================
// RUTAS PÚBLICAS / REDIRECCIÓN
// ============================================
Route::get('/', fn() => redirect()->route('login'));

// ============================================
// RUTAS PROTEGIDAS (requieren autenticación)
// ============================================
Route::middleware(['auth'])->group(function () {

    // Dashboard por rol
    Route::get('/dashboard', [DashboardController::class, 'redirectByRole'])->name('dashboard');

    // Dashboards específicos (cada uno con su middleware de rol)
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('role:admin');
    Route::get('/inventario/dashboard', [DashboardController::class, 'inventarioDashboard'])->name('inventario.dashboard')->middleware('role:inventario');
    Route::get('/procesos/dashboard', [DashboardController::class, 'procesosDashboard'])->name('procesos.dashboard')->middleware('role:procesos');
    Route::get('/despachos/dashboard', [DashboardController::class, 'despachosDashboard'])->name('despachos.dashboard')->middleware('role:despachos');

    // ============================================
    // MÓDULO INVENTARIO (registro y listado para admin e inventario)
    // ============================================
    Route::middleware(['role:inventario,admin'])->group(function () {
        Route::get('/inventario/registrar', [InventarioController::class, 'create'])->name('inventario.create');
        Route::post('/inventario/guardar', [InventarioController::class, 'store'])->name('inventario.store');
        Route::post('/inventario/ajax-proveedor', [InventarioController::class, 'ajaxProveedor'])->name('inventario.ajax.proveedor');
        Route::get('/inventario/lista', [InventarioController::class, 'lista'])->name('inventario.lista');
    });
    // Búsqueda de proveedores (AJAX, cualquier autenticado)
    Route::get('/inventario/buscar-proveedores', [InventarioController::class, 'buscarProveedores'])->name('inventario.buscar.proveedores');

    // ============================================
    // MÓDULO PROCESO (admin y procesos)
    // ============================================
    Route::middleware(['role:admin,procesos'])->group(function () {
        Route::get('/procesos/iniciar', [IniciarProcesoController::class, 'index'])->name('procesos.iniciar');
        Route::post('/procesos/iniciar', [IniciarProcesoController::class, 'iniciarProceso'])->name('procesos.iniciar.guardar');
        Route::get('/procesos/lista', [InventarioProcesoController::class, 'lista'])->name('procesos.lista');
    });

    // ============================================
    // MÓDULO PRODUCCIÓN (admin y produccion)
    // ============================================
    Route::middleware(['role:admin,produccion'])->group(function () {
        Route::get('/produccion/registrar', [ProduccionController::class, 'create'])->name('produccion.registrar');
        Route::post('/produccion/guardar', [ProduccionController::class, 'store'])->name('produccion.guardar');
        Route::get('/producciones/lista', [ProduccionController::class, 'lista'])->name('producciones.lista');
    });

    // ============================================
    // MÓDULO DESPACHOS (admin, despachos e inventario)
    // ============================================
    Route::middleware(['role:admin,despachos,inventario'])->group(function () {
        Route::get('/despachos/registrar', [DespachoController::class, 'create'])->name('despachos.registrar');
        Route::post('/despachos/guardar', [DespachoController::class, 'store'])->name('despachos.guardar');
        Route::get('/despachos/lista', [DespachoController::class, 'lista'])->name('despachos.lista');
    });

    // ============================================
    // ADMINISTRACIÓN DE USUARIOS (solo admin)
    // ============================================
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::resource('usuarios', UsuarioController::class)->except(['show']);
        Route::get('usuarios/{usuario}/toggle-activo', [UsuarioController::class, 'toggleActivo'])->name('admin.usuarios.toggle.activo');
    });

    // ============================================
    // CATÁLOGO DE PROVEEDORES (admin e inventario)
    // ============================================
    Route::prefix('admin')->middleware(['role:admin,inventario'])->group(function () {
        Route::resource('proveedores', ProveedorBaseController::class)->names([
            'index'   => 'admin.proveedores.index',
            'store'   => 'admin.proveedores.store',
            'update'  => 'admin.proveedores.update',
            'destroy' => 'admin.proveedores.destroy',
        ]);
    });

    Route::resource('usuarios', UsuarioController::class)->except(['show']);
    
    Route::get('usuarios/{usuario}/toggle-activo', [UsuarioController::class, 'toggleActivo'])->name('admin.usuarios.toggle.activo');
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('profile.index');
    Route::get('/perfil', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/autoedit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.autoedit');
    Route::put('/autoedit', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');


    // ============================================
    // TRAZABILIDAD (solo admin)
    // ============================================
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/trazabilidad', [TrazabilidadController::class, 'index'])->name('admin.trazabilidad.index');
        Route::get('/trazabilidad/exportar', [TrazabilidadController::class, 'exportarCSV'])->name('admin.trazabilidad.exportar');
    });

    // ============================================
    // RECURSOS EDITAR/ELIMINAR (solo admin) - incluye todas las tablas
    // ============================================
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        // Inventario
        Route::get('inventarios/{id}/edit', [InventarioController::class, 'edit'])->name('inventario.edit');
        Route::put('inventarios/{id}', [InventarioController::class, 'update'])->name('inventario.update');
        Route::delete('inventarios/{id}', [InventarioController::class, 'destroy'])->name('inventario.destroy');

        // Procesos
        Route::get('procesos/{id}/edit', [InventarioProcesoController::class, 'edit'])->name('procesos.edit');
        Route::put('procesos/{id}', [InventarioProcesoController::class, 'update'])->name('procesos.update');
        Route::delete('procesos/{id}', [InventarioProcesoController::class, 'destroy'])->name('procesos.destroy');

        // Producción
        Route::get('producciones/{id}/edit', [ProduccionController::class, 'edit'])->name('producciones.edit');
        Route::put('producciones/{id}', [ProduccionController::class, 'update'])->name('producciones.update');
        Route::delete('producciones/{id}', [ProduccionController::class, 'destroy'])->name('producciones.destroy');

        // Despachos
        Route::get('despachos/{id}/edit', [DespachoController::class, 'edit'])->name('despachos.edit');
        Route::put('despachos/{id}', [DespachoController::class, 'update'])->name('despachos.update');
        Route::delete('despachos/{id}', [DespachoController::class, 'destroy'])->name('despachos.destroy');
        
        // Proveedores JSON (para autocompletado)
        Route::get('/proveedores/json', [ProveedorBaseController::class, 'json'])->name('admin.proveedores.json');
    });
});