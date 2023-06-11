<?php

namespace App\Http\Controllers;

use App\Models\MenuPackagePivots;
use App\Models\MenuPackages;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class MenuPackagesController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:paket-menu-list', ['only' => 'index']);
        $this->middleware('permission:paket-menu-create', ['only' => ['create','store']]);
        $this->middleware('permission:paket-menu-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:paket-menu-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Paket Menu';
        $data['menu_packages'] = MenuPackages::orderBy('id', 'ASC')->get();
        return view('management-toko-online.paket-menu.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Paket Menu';
        $data['menu_package_pivots'] = MenuPackagePivots::get();
        $data['restaurants'] = Restaurant::get();
        $data['menu_package'] = MenuPackages::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuPackages  $menuPackages
     * @return \Illuminate\Http\Response
     */
    public function show(MenuPackages $menuPackages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuPackages  $menuPackages
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuPackages $menuPackages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuPackages  $menuPackages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuPackages $menuPackages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuPackages  $menuPackages
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuPackages $menuPackages)
    {
        //
    }
}
