<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::middleware("guest")->group(function ()
{
    Route::get("/login", [AuthController::class, "loginForm"])->name("login");
    Route::get("/register", [AuthController::class, "registerForm"])->name("register");

    Route::post("/login", [AuthController::class, "login"])->name("loginSubmit");
    Route::post("/register", [AuthController::class, "register"])->name("registerSubmit");
});

