<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BingoController extends Controller
{
    public function index(Request $request)
    {
        $userAgent = $request->header('User-Agent', '');
        $isMobile = (bool) preg_match('/(android|iphone|ipad|mobile)/i', $userAgent);
        $isPlayer = $request->query('role') === 'player';

        if ($isMobile && !$isPlayer) {
            return redirect()->route('bingo.mobile_host');
        }

        return view('bingo.index', ['isPlayer' => $isPlayer]);
    }

    public function mobileHost()
    {
        return view('bingo.mobile_host');
    }
}
