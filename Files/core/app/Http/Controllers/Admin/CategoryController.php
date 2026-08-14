<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FileFormat;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Categories';
        $categories = Category::searchable(['name'])->withCount('subcategories')->orderByDesc('id')->paginate(getPaginate());
        return view('admin.category.index', compact('pageTitle', 'categories'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name'        => 'required|unique:categories,name,' . $id,
        ]);
        if ($id) {
            $category           = Category::findOrFail($id);
            $notification       = 'Category updated successfully';
        } else {
            $category           = new Category();
            $notification       = 'Category added successfully';
        }
        $category->name = $request->name;
        $category->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Category::changeStatus($id);
    }

    public function subcategories($id)
    {
        $category = Category::findOrFail($id);
        $pageTitle = 'Subcategories of - ' . $category->name;
        $subcategories = $category->subcategories()->withCount('formats')->orderByDesc('id')->paginate(getPaginate());
        return view('admin.category.subcategory', compact('pageTitle', 'subcategories', 'category'));
    }


    public function subcategoryStore(Request $request, $id = 0)
    {
        $request->validate([
            'name'        => 'required',
        ]);

        $category = Category::findOrFail($request->category_id);

        if ($id) {
            $subcategory           = Subcategory::findOrFail($id);
            $notification       = 'Subcategory updated successfully';
        } else {
            $subcategory           = new Subcategory();
            $notification       = 'Subcategory added successfully';
        }
        $subcategory->name = $request->name;
        $subcategory->category_id = $category->id;
        $subcategory->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function subcategoryStatus($id)
    {
        return Subcategory::changeStatus($id);
    }

    public function formats($id)
    {
        $subcategory = Subcategory::with('category')->findOrFail($id);
       
        $pageTitle = 'File Formats of - ' . $subcategory->name;
        $formats = $subcategory->formats()->orderByDesc('id')->paginate(getPaginate());
        return view('admin.category.format', compact('pageTitle', 'formats', 'subcategory'));
    }

    public function formatStore(Request $request, $id = 0)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('file_formats')->where(function ($query) use ($request) {
                    return $query->where('subcategory_id', $request->subcategory_id);
                })->ignore($id)
            ],
        ]);

        $subcategory = Subcategory::findOrFail($request->subcategory_id);

        if ($id) {
            $format           = FileFormat::findOrFail($id);
            $notification       = 'File format updated successfully';
        } else {
            $format           = new FileFormat();
            $notification       = 'File format added successfully';
        }
        $format->name = strtolower($request->name);
        $format->subcategory_id = $subcategory->id;
        $format->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function formatStatus($id)
    {
        return FileFormat::changeStatus($id);
    }
}
