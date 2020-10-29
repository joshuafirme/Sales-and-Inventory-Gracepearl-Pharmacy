<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\CategoryMaintenance;
use Illuminate\Http\Request;

class CategoryMaintenanceCtr extends Controller
{
    private $table_name = "tblcategory";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = DB::table($this->table_name)
        ->paginate(10);

        return view('maintenance/category/category', ['category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        $category = new CategoryMaintenance;
        $category->category_name = $request->input('category_name');
        $category->save();

        return redirect('/maintenance/category')->with('success', 'Data Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = DB::select('SELECT * FROM ' . $this->table_name . ' WHERE id = ?', [$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = CategoryMaintenance::findOrFail($id);
        $category->delete();
        return $category;
    }
}
