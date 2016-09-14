<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Sintegra;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('search_cnpj');
    }
    
    /**
     * Mostra os dados salvos da consulta.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSintegra()
    {        
        $sintegras = Sintegra::select()->get();
        return view('show_sintegra')->with('sintegras', $sintegras);        
        
    }
    
    /**
     * Remove dados da consulta.
     *
     * @return \Illuminate\Http\Response
     */
    public function removeSintegra(Request $request){
        $sintegra = Sintegra::find($request->id);
        $sintegra->delete();    
    }
    
    

    
}
