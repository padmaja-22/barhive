<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory;
use App\Product;
use App\Inventory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }

    public function inventory()
    {
        $oCategories = ProductCategory::all();
        $oProducts = Product::all();

        return view('inventory.overview', ['oCategories' => $oCategories, 'oProducts' => $oProducts]);
    }

    public function category()
    {
        return view('inventory.addCategory');
    }

    public function addProduct($id)
    {

        $oCategory = ProductCategory::where('id', $id)->first();

        return view('inventory.addProduct', ['oCategory' => $oCategory]);
    }

    public function editProduct($id)
    {
        $oProduct = Product::where('id', $id)->first();
        $oCategory = ProductCategory::where('id', $oProduct->iCategoryId)->first();
        $oInventory = Inventory::where('iProductId', $id)->first();

        return view('inventory.editProduct', ['oCategory' => $oCategory, 'oProduct' => $oProduct, 'oInventory' => $oInventory]);
    }

    public function posTable()
    {
        return view('pos.table');
    }

    public function pos($iTable)
    {
        $oCategories = ProductCategory::all();

        return view('pos.overview', ['oCategories' => $oCategories, 'iTable' => $iTable]);
    }

    public function posCategory($iTable, $iCat)
    {
        $oProducts = Product::all()->where('iCategoryId', $iCat);

        return view('pos.categoryOverview', ['oProducts' => $oProducts, 'iTable' => $iTable]);
    }

    public function posProduct($iTable, $iCat, $iProd)
    {
        $oProduct = Product::all()->where('id', $iProd)->first();

        return view('pos.productOverview', ['oProduct' => $oProduct, 'iTable' => $iTable]);
    }

    public function tickets()
    {
        return view('tickets.all');
    }

    public function kitchen()
    {
        return view('tickets.kitchen');
    }

    public function bar()
    {
        return view('tickets.bar');
    }

    public function tableSettings()
    {
        return view('settings.table');
    }

    public function managementSettings()
    {

    }

    public function posSettings()
    {

    }

    public function userPreferences()
    {
        return view('user.preferences');
    }

    public function userProfile()
    {
        return view('user.profile');
    }

    public function analyticsSales()
    {
        return view('analytics.sales');
    }

    public function analyticsProducts()
    {
        return view('analytics.products');
    }

    public function analyticsTables()
    {
        return view('analytics.tables');
    }
}
