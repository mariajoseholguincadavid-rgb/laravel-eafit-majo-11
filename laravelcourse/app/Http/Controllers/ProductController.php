<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData["title"] = "Products - Online Store";
        $viewData["subtitle"] = "List of products";
        $viewData["products"] = Product::all();

        return view('product.index')->with("viewData", $viewData);
    }

    public function show(string $id): View
    {
        $viewData = [];
        $product = Product::findOrFail($id);

        $viewData["title"] = $product["name"] . " - Online Store";
        $viewData["subtitle"] = $product["name"] . " - Product information";
        $viewData["product"] = $product;

        return view('product.show')->with("viewData", $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData["title"] = "Create product";

        return view('product.create')->with("viewData", $viewData);
    }

    public function save(Request $request)
    {
        $request->validate([
            "name" => "required",
            "price" => "required"
        ]);

        Product::create($request->only(["name", "price"]));

        return back();
    }

    public function saveComment(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            "description" => "required|string|max:2000"
        ]);

        $product->comments()->create([
            "description" => $validated["description"]
        ]);

        return redirect()
            ->route("product.show", ["id" => $product->id])
            ->with("success", "¡Comentario agregado correctamente!");
    }
}
