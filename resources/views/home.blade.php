@extends('layouts/master')

@section('content')
    <div class="row text-center">

        @foreach ($products as $item)

            <div class="col-4 mb-3">
                <div class="card">
                    <img src="{{ asset('product-default.jpg')}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->name}}</h5>
                        <p class="card-text">{{ $item->description }}</p>
                        <a href="{{ route('addCart', $item->id) }}" class="btn btn-primary">Add To Cart</a>
                    </div>
                </div>
            </div>

        @endforeach

    </div>


@endsection
