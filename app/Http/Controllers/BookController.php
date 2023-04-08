<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models\ModelBook;

class BookController extends Controller
{
    public function store(Request $request)
    {
        $crud = new ModelBook;
        $crud->name = $request->name;
        $crud->description = $request->description;
        $crud->price = $request->price;

        $crud->save();

        return redirect()->route('crud.index');
    }
}
