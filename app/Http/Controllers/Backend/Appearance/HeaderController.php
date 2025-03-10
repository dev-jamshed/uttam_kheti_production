<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;

class HeaderController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:header'])->only('index');
    }

    # website header configuration
    public function index()
    {

        $categories = Category::query()->parentId()
            ->orderBy('sorting_order_level', 'desc')
            ->with('childrenCategories')
            ->get();
         cacheClear();

        $pages = Page::latest()->get();
        return view('backend.pages.appearance.header', compact('categories', 'pages'));
    }
}
