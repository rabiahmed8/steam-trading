<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class FormController extends Controller {

    public function submitForm(Request $request){

        Item::create($request->all());

        $username = $request->input('username');
    }

}
