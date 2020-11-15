@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Category Maintenance</h3>
          <hr>
      </div>

        @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
    
                <li>{{$error}}</li>
                    
                @endforeach
            </ul>
        </div>
        @endif
    
        @if(\Session::has('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> </h5>
          {{ \Session::get('success') }}
        </div>

       
        @endif

        

        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCategoryModal"><span class='fa fa-plus'></span> Add Category</button>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card" style="width: 500px">
                <div class="card-body">
                    <p class="card-title"></p>
                    <table class="table table-hover" id="category-table">
                      @if(count($category) > 0)
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th >Action</th>
                            </tr>
                        </thead>
           
                        <tbody>
                            <tr>    
                              @foreach ($category as $data)                        
                              <td class="td-cat-name">{{ $data->category_name }}</td>                                                           
                                <td>
                                  <a class="btn" id="btn-edit-category-maintenance" category-id="{{ $data->id }}" data-toggle="modal" data-target="#editCategoryModal"><i class="fa fa-edit"></i></a>
                                  <a class="btn" name="id" id="deleteCategory" delete-id="{{ $data->id }}"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach 
                            @else
                            <div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <h5><i class="icon fas fa-exclamation-triangle"></i> </h5>No data found
                            </div>  
                      @endif                       
                        </tbody>
                    </table>
                    <div class="pl-2">
                      {{ $category->links() }}
                  </div>
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @extends('maintenance.category.category_modals')
    @section('modals')
    @endsection

@endsection


