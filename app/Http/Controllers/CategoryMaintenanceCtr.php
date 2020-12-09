<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\CategoryMaintenance;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class CategoryMaintenanceCtr extends Controller
{
    private $table_name = "tblcategory";
    private $table_emp = "tblemployee";
    private $this_module = "Maintenance";

    public function index(){
        if(!($this->isUserAuthorize())){
            dd('You are not authorized to access this module, please ask the administrator');
        }
    
        $category = DB::table($this->table_name)
        ->paginate(10);

        return view('maintenance/category/category', ['category' => $category]);
    }

    public function isUserAuthorize(){
        $emp = DB::table($this->table_emp)
        ->where([
            ['username', session()->get('emp-username')],
        ])
        ->value('auth_modules');

        $modules = explode(", ",$emp);

        if (!(in_array($this->this_module, $modules)))
        {
            return false;
        }
        else{
            return true;
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = DB::select('SELECT * FROM ' . $this->table_name . ' WHERE id = ?', [$id]);
        return $category;
    }

    public function updateCategory($category_id)
    {
        $category_name = Input::get('category_name');

        DB::update('UPDATE '. $this->table_name .' 
        SET category_name = ?
        WHERE id = ?',
        [
            $category_name,
            $category_id
        ]);
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
