<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EstrategiasPrevenir; 

class EstrategiasPrevenirController extends Controller
{
    public function index()
    {
        return view('estrategiasprevenir.index');
    }

    public function create()
    {
        return view('estrategiasprevenir.create');
    }

    public function store(Request $request)
    {
         
    }
    public function show($id)
    {
        
    }

    public function edit($id)
    {
          
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
    
    }
}
