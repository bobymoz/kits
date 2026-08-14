<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\FileFormat;
use App\Models\Frontend;
use App\Models\Subcategory;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Products';
        $products = Product::searchable(['name', 'category:name'])->filter(['type'])->with('category')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'products'));
    }

    public function add()
    {
        $pageTitle = 'Add New Product';
        $categories = Category::active()->with(['subcategories' => function ($q) {
            $q->active()->with('formats')->whereHas('formats')->active();
        }])->orderBy('id', 'DESC')->get();
        return view('admin.product.form', compact('pageTitle', 'categories'));
    }

    public function getFormats($id)
    {
        $formats = FileFormat::where('subcategory_id', $id)->where('status', Status::ENABLE)->get();
        if (!$formats) {
            return response()->json([
                'success' => false,
            ]);
        }
        $formatNames = $formats->pluck('name');
        return response()->json([
            'success' => true,
            'acceptFormats' => '.' . $formatNames->implode(', .'),
        ]);
    }
    public function status($id)
    {
        return Product::changeStatus($id);
    }


    public function store(Request $request, $id = 0)
    {
        $isRequired = $id ? 'nullable' : 'required';
        $isRequiredFile = $id ? 'nullable' : 'required_if:file_link,2';
        $isRequiredLink = $id ? 'nullable' : 'required_if:file_link,1';
        $isRequiredPrice = $id ? 'nullable' : 'required_if:type,1';

        $subcategory = Subcategory::active()->find($request->subcategory_id);
        if (!$subcategory) {
            $notify[] = ['error', 'Subcategory is out rules!'];
            return back()->withNotify($notify);
        }
        $allowedFormats = $subcategory->formats->pluck('name')->toArray();
        $request->validate([
            'image'       => ["$isRequired", new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'name'        => 'required',
            'type'        => 'required|in:1,2',
            'category_id' => ['required', 'integer', 'gt:0', Rule::exists('categories', 'id')->where(function ($query) {
                $query->where('status', Status::YES);
            }),],
            'subcategory_id' => ['required', 'integer', 'gt:0', Rule::exists('subcategories', 'id')->where(function ($query) {
                $query->where('status', Status::YES);
            }),],
            'file_link'     => 'required|in:1,2',
            'link'          => [$isRequiredLink, 'nullable', 'url'],
            'file'          => [$isRequiredFile, 'nullable', 'file', new FileTypeValidate($allowedFormats)],
            'price'         => [$isRequiredPrice, 'nullable', 'numeric', 'gte:0'],
            'info'          => 'nullable|array',
            'info.*.title'  => 'required|string',
            'info.*.detail' => 'required|string'
        ], [
            'link.required_if'          => 'Link field is required when Link/File is Link',
            'file.required_if'          => 'File field is required when Link/File is File',
            'price.required_if'         => 'Price field is required when Type is Paid',
        ]);

        if ($id) {
            $product      = Product::findOrFail($id);
            $notification = 'Product updated Successfully!';
        } else {
            $product      = new Product();
            $notification = 'Product Added Successfully!';
        }

        if ($request->hasFile('image')) {
            try {
                $old = @$product->image;
                $thumb = '255x265';
                $product->image = fileUploader($request->image, getFilePath('product'), getFileSize('product'), $old, $thumb);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload product image'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('file')) {
            try {
                $old = @$product->file;
                $product->file = fileUploader($request->file, getFilePath('productFile'), null, $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload product file'];
                return back()->withNotify($notify);
            }
        }

        $product->name           = $request->name;
        $product->category_id    = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->description    = $request->description;

        $product->information = @$request->info;
        $product->type  = $request->type;
        $product->price = @$request->price;
        $product->link  = @$request->link;
        $product->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Product';
        $product = Product::findOrFail($id);
        $categories = Category::active()->with(['subcategories' => function ($q) {
            $q->active()->with('formats')->whereHas('formats')->active();
        }])->orderBy('id', 'DESC')->get();
        return view('admin.product.form', compact('pageTitle', 'product', 'categories'));
    }

    

    public function frontendSeo($id)
    { 
        $key = 'product';
        $data = Product::findOrFail($id);
        $pageTitle = 'SEO Configuration';
        return view('admin.product.frontend_seo', compact('pageTitle','key','data'));
    }

    public function frontendSeoUpdate(Request $request, $id)
    {

        $request->validate([
            'image' => ['nullable', new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ]);

        $data = Product::findOrFail($id);
        $image = @$data->seo_content->image;
        if ($request->hasFile('image')) {
            try {
                $path = 'assets/images/frontend/product' . '/seo';
                $image = fileUploader($request->image, $path, getFileSize('seo'), @$data->seo_content->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the image'];
                return back()->withNotify($notify);
            }
        }
        $data->seo_content = [
            'image' => $image,
            'description' => $request->description,
            'social_title' => $request->social_title,
            'social_description' => $request->social_description,
            'keywords' => $request->keywords,
        ];
        $data->save();

        $notify[] = ['success', 'SEO content updated successfully'];
        return back()->withNotify($notify);
    }
}
