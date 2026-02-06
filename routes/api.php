<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\JokeController;

Route::group(["prefix" => "v1"], function () {
    Route::post("/register", [AuthController::class, "register"])->name(
        "api.register",
    );
    Route::post("/login", [AuthController::class, "login"])->name("api.login");
    Route::middleware("auth:sanctum")->group(function () {
        Route::post("/logout", [AuthController::class, "logout"]);
        Route::get("/random-jokes", [
            JokeController::class,
            "getRandomJoke",
        ])->name("api.jokes");
    });
});
