@component('mail::message')
# Incoive paid

Thanks for the Purchase.

Here is your Receipt.

<table class="table">
    <thead>
    <tr>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->items as $item)
    <tr>
        <td>
            {{ $item->name }}
        </td>
        <td>
            {{ $item->pivot->quantity }}
        </td>
        <td>
            {{ $item->pivot->price }}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
Total: {{ $order->grand_total }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
