<?php

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\PkwtController;

Route::POST('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::POST('/logout', [AuthController::class, 'logout']);

    Route::GET('/Dashboard', [DashboardController::class, 'showDashboard']);

    Route::GET('/Departments', [DepartmentsController::class, 'showDepartments']);
    Route::POST('/Departments', [DepartmentsController::class, 'createDepartment']);
    Route::PUT('/Departments/{id}', [DepartmentsController::class, 'updateDepartment']);
    Route::DELETE('/Departments/{id}', [DepartmentsController::class, 'deleteDepartment']);

    Route::GET('/Positions', [PositionsController::class, 'showPositions']);
    Route::POST('/Positions', [PositionsController::class, 'createPosition']);
    Route::PUT('/Positions/{id}', [PositionsController::class, 'updatePosition']);
    Route::DELETE('/Positions/{id}', [PositionsController::class, 'deletePosition']);

    Route::GET('/Employees', [EmployeesController::class, 'showEmployees']);
    Route::POST('/Employees', [EmployeesController::class, 'createEmployee']);
    Route::PUT('/Employees/{id}', [EmployeesController::class, 'updateEmployee']);
    Route::DELETE('/Employees/{id}', [EmployeesController::class, 'deleteEmployee']);

    Route::GET('/Pkwts', [PkwtController::class, 'showPkwt']);
    Route::POST('/Pkwts', [PkwtController::class, 'createPkwt']);
    Route::PUT('/Pkwts/{id}', [PkwtController::class, 'editPkwt']);
    Route::DELETE('/Pkwts/{id}', [PkwtController::class, 'deletePkwt']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/health', function () {
    return response()->json([
        'ok' => true,
        'app' => config('app.name'),
    ]);
});
