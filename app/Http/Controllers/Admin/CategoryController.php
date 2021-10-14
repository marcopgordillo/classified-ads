<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::simplePaginate(12);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()
            ->filter(function($value, $key) {
                return $this->max_parents($value, 2);
            });

        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = [
                'name'  =>  $request->name,
                'slug'  =>  Str::slug($request->name),
                'parent_id' => $request->parent_id !== 'null'? $request->parent_id : NULL,
        ];

        if ($request->hasFile('image')) {
            try {
                $path = $request->file('image')->store('categories', 'public');

                $data['image'] = $path;
            } catch (\Throwable $th) {
                return redirect()->route('categories.index')->with('error', 'Sorry there was a problem!');
            }
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $children_ids = $this->find_ids($category, []);

        $categories = Category::where([
            ['id', '<>', $category->id],
        ])->whereNotIn('id', $children_ids)
            ->get()
            ->filter(function($value, $key) {
                return $this->max_parents($value, 2);
            });

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data_updated = [
                    'name'  =>  $request->name,
                    'slug'  =>  Str::slug($request->name),
                    'parent_id' => $request->parent_id !== 'null'? $request->parent_id : NULL,

        ];

        if ($request->hasFile('image')) {
            try {
                $path = $request->file('image')->store('categories', 'public');

                Storage::disk('public')->delete($category->image);

                $data_updated['image'] = $path;

            } catch (\Throwable $th) {
                return redirect()->route('categories.index')->with('error', 'Sorry there was a problem');
            }
        }

        $category->update($data_updated);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            try {
                Storage::disk('public')->delete($category->image);
            } catch (\Throwable $th) {
                return redirect()->route('categories.index')->with('error', 'Sorry there was a problem');
            }
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }

    private function find_ids($child, $ids) {
        if (isset($child->children)) {
            if ($child->children->count() > 0) {
                $ids = $child->children->flatMap(function($value, $key) {
                    $ids = $this->find_ids($value, []);
                    return [$value->id, ...$ids];
                });
            }
        }

        return $ids;
    }

    private function max_parents($object, $max) {

        $parents = 0;

        while (isset($object->parent)) {
                $object = $object->parent;
                ++$parents;
        }

        return $parents < $max;
    }
}
