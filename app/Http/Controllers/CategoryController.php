<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Exceptions\CategoryHasTasksException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::withCount('task')
            ->where('user_id', Auth::user()->id)
            ->orderBy('name')
            ->get();

        return view('category.show', [
            'categorys' => $category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name,NULL,id,user_id,' . Auth::user()->id
            ],
        ], [
            'name.unique' => 'You already have a category with this name.'
        ]);

        DB::transaction(function () use ($validated) {
            Category::create([
                'name' => $validated['name'],
                'user_id' => Auth::user()->id,
            ]);
        });

        return redirect()->route('categorys.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // This method can be implemented if needed for individual category viewing
        return redirect()->route('categorys.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($catId)
    {
        $category = Category::where('user_id', Auth::user()->id)->findOrFail($catId);

        return view('category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $catId)
    {
        $category = Category::where('user_id', Auth::user()->id)->findOrFail($catId);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name,' . $catId . ',id,user_id,' . Auth::user()->id
            ],
        ], [
            'name.unique' => 'You already have a category with this name.'
        ]);

        DB::transaction(function () use ($category, $validated) {
            $category->update([
                'name' => $validated['name'],
            ]);
        });

        return redirect()->route('categorys.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($catId)
    {
        DB::transaction(function () use ($catId) {
            $category = Category::where('user_id', Auth::user()->id)->findOrFail($catId);

            // Check if category has associated tasks
            $taskCount = $category->task()->count();

            if ($taskCount > 0) {
                throw new CategoryHasTasksException($category, $taskCount);
            }

            $category->delete();
        });

        return redirect()->route('categorys.index')->with('success', 'Category deleted successfully!');
    }
}

