@extends('layouts/master')

@section('content')

    <h2>My Cart</h2>


    <table class="table">
        <thead class="thead-light">
        <tr>

            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cartItem as $item)
            <tr>
                <td>{{$item->name}}</td>
                <td>
                    {{ Cart::session(auth()->id())->get($item->id)->getPriceSum() }}
                </td>
                <td>
                    <form class="d-flex" action="{{ route('cart.addQuantity', $item->id) }}">
                        <input style="width: 100px;" type="number" class="form-control" name="quantity" value="{{$item->quantity}}">
                        <button class="btn btn-primary btn-sm">Save</button>
                    </form>
                </td>
                <td><a class="btn btn-primary" href="{{ route('cart.destroy', $item->id) }}">Delete</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h3>Total Price : {{ \Cart::session(auth()->id())->getTotal() }}</h3>
    <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-sm">Proceed to Checkout</a>
    <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Continue Shopping.</a>
@endsection

