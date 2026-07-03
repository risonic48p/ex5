<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use App\Services\ShortLinksService;
use Illuminate\Support\Facades\Redirect;


final class ShortLinksController extends Controller
{

    public function index(Request $request, string $hash): RedirectResponse | string
    {
        $url = ShortLinksService::init($hash, $request->ip())->proceed()->getUrl();
        if($url){
            return Redirect::to($url);
        }
        return view('404', ['code' => 404, 'message' => 'Ссылка не найдена']);
    }
}
