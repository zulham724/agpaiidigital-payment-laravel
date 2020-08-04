<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['middleware'=>'api','prefix'=>'api/v1','namespace'=>'API\\v1'],function()use($router){
    $router->get('/user', function (Request $request) use ($router) {
        return $request->user();
    });

    $router->post('/payment/notification/handler', 'PaymentController@notificationHandler'); // PAYMENT NOTIFICATION HANDLER

    $router->post('/payment/notification/queuehandler', 'PaymentController@notificationQueueHandler'); // NOT FOR PRODUCTION NOTIFICATION HANDLER WITH QUEUE

    $router->get('/test/{id}','PaymentController@test');
});
