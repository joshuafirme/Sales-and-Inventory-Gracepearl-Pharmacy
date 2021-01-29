@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Backup and Restore Database</h3>
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

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-2">
  
          <div class="card">
            <div class="card-body">

                <p class="ml-2">Your database is automatically backup hourly.</p>

                <div class="row ml-1">

                    <form method="POST" action="{{ action('Utilities\BackupAndRestoreCtr@backup') }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-sm btn-primary m-2"><i class="fas fa-database"></i> Backup</button>
                    </form>

                    <form method="POST" action="{{ action('Utilities\BackupAndRestoreCtr@restore') }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-sm btn-primary m-2"><i class="fas fa-redo-alt"></i> Restore</button>
                    </form>

                </div>
                    
                  </div>
                </div>
                
            </div>
        </div>

        <!-- /.row (main row) -->
        
     
    </section>
    <!-- /.content -->


@endsection



