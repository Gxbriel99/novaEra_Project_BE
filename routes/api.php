<?php

use App\Http\Controllers\AssistenceRequestController;
use App\Http\Controllers\AssistentChatController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;


//Questa Route gestisce l'invio di una request d'assistenza
Route::post('/sendRequest', [AssistenceRequestController::class, 'addRequest']);

//Questa Route gestisce la response a un ticket da parte dell'assistenza
Route::post('/sendResponse', [AssistentChatController::class, 'sendResponse']);


//Questa Route gestisce l'invio di un messaggio da parte dell'utente
Route::post('/sendMessage', [AssistentChatController::class, 'sendMessage']);


//Questa Route ritorna tutti i ticket aperti dall'utente
Route::get('/allTicketsAssistence', [UserController::class, 'allTicketAssistence']);

//Questa Route ritorna tutti i ticket aperti dall'utente
Route::post('/allTickets', [UserController::class, 'allTicket']);

//
Route::get('/Ticket/{idTicket}', [UserController::class, 'getTicket']);


Route::get('/allChat/{idTicket}', [AssistentChatController::class, 'allChat']);




