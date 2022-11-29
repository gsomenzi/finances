<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancialAccountController extends Controller
{
    public function list(Request $request) {
        return view("financial-accounts.list");
    }
}
