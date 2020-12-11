@extends('customer.layouts.main')

@section('content')

<div class="container-fluid center-items">


    <div class="row">
        <div class="card-columns">
    @foreach ($products as $data)      

    <div class="card" style="width: 230px;">
        @if(!$data->image)
        <img style="height:150px" src="../assets/gracepearl-bg.jpg" class="card-img-top" alt="...">
        @else
        <img style="height:150px" src="../../storage/{{$data->image}}" class="card-img-top" alt="...">
        @endif
        <div class="card-body">
            <p class="card-title">{{ $data->description }}</p>
            <p class="card-text"></p>
            <a href="#" class="btn btn-sm btn-primary">Add to Cart</a>
            <a href="#" class="btn btn-sm btn-success">Buy Now</a>
        </div>
      </div>
      @endforeach  

    </div>
</div>

</div>

@endsection