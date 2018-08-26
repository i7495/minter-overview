<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Candidate;
use PHP\Math\BigInteger\BigInteger;
use Minter\MinterAPI;

class AppController extends Controller
{

    public function app() {
        $api = new MinterAPI('127.0.0.1:8841');

        return view('app');
    }

    public function validators() {
        $candidates = Candidate::orderBy('status', 'desc')->orderBy('delegates', 'desc')->get();
        return $candidates;
    }

    public function network() {
        $api = new MinterAPI('127.0.0.1:8841');
        $network = $api->getStatus();

        return response()->json($network);
    }

}
