<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/scope_profile', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://localhost:8080/callback',
        'response_type' => 'code',
        'scope' => 'profile',
    ]);
    return redirect('http://localhost:8000/oauth/authorize?'.$query);
});

Route::get('/scope_profile_test', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://localhost:8080/callback',
        'response_type' => 'code',
        'scope' => 'profile test',
    ]);
    return redirect('http://localhost:8000/oauth/authorize?'.$query);
});

use Illuminate\Http\Request;

Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;
    $response = $http->post('http://localhost:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '3',
            'client_secret' => 'pLwECxZixJn51HHkNVECniw3snLmPQuCb6gY8UJs',
            'redirect_uri' => 'http://localhost:8080/callback',
            'code' => $request->code,
        ],
    ]);
    return json_decode((string) $response->getBody(), true);
});

Route::get('/refreshtoken', function (Request $request) {
    $http = new GuzzleHttp\Client;
    $response = $http->post('http://localhost:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'refresh_token',
            'refresh_token' => 'Us/F6AxQ2rPxcL+AdFS3oDGICUBYbv1BKIRfc4XMEA2pgB7eTTFMHLJaQLSRp/Yx2sRvMU7fu7NqockJ8U6K1Xgd0lNa3yvRGZIYLNAaGoexsjVeJ057PdDOji3d/YPoBgrcxo30YB8Mb529UOQXCRQMykjmkTLbUoCWXfSAmTVuDfUmsnHexWTTK6dTMKiq1DLutwPOKprb2l0mBOMeL0/sZpNg9NAzRl24kMyUpYJF3LaBYzTm+z954jmqJQPDnHc8+/hbghrCTeMcJeL2icoAiJs59ynsJEfrr0MaTEKaEAeo8keqwlEPzgKIkapdgKUO2cVvXLa3RzMYtpXR9rtYp099pMuZNM8w4GIG7ahyi3gGH0Dst/+0FQPg2oiFhWnDno+WlHNra5ueVl2m4EdmUM3X9iV34lQFX9uFMocRRJFvmE9wF82UALnaiYzScW/UMT+1EvERhXdUoELSHywbCpGrePq8s0iXUcgK0NL+KCN43C0JsM8Y0YT2QDq2NN3TdK6k21T+7FBg7Ds53JQOrPDpzz37E73TCI0+++AAumX/eskV2tGZfdH6oMVrVZ5LIXusLG17WE0VsLPrDVLBMALt1Sh23DGIml5p3LiFkpRTZnRscm7FEfzDSAawq3X94rO+T0br3jnKf8P5xyOhBmA1bp2sGstl6Ilnx5Y=',
            'client_id' => '3',
            'client_secret' => 'pLwECxZixJn51HHkNVECniw3snLmPQuCb6gY8UJs',
            'scope' => 'profile',
        ],
    ]);
    return json_decode((string) $response->getBody(), true);//['access_token'];
});