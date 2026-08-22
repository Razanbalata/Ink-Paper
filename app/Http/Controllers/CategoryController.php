<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query()
            ->withCount('posts')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->string('search');

            $query->where(function ($query) use ($search) {
                $query
                    ->where(
                        'name',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'description',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        $categories = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'dashboard.categories.index',
            compact('categories')
        );
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
         $data = $request->validated();

    $data['slug'] = Str::slug($data['name']);

    Category::create($data);

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view(
            'dashboard.categories.show',
            compact('category')
        );
    }

    public function edit(Category $category)
    {
        return view(
            'dashboard.categories.edit',
            compact('category')
        );
    }

    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ) {
        $category->update(
            $request->validated()
        );

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
