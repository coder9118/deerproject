<div>
    @foreach($this->orders as $order)

        <div class="container mx-auto my-8 px-24 py-3 shadow bg-gray-800 rounded-xl flex flex-row justify-between items-center">
            <div class="left-side">
                <h2 class="text-lg font-semibold mb-2">Order Information</h2>
                <p class="text-sm text-gray-500 mb-2">Order ID: #{{$order->id}}</p>
                <p class="text-sm text-gray-500 mb-2">Date: {{$order->created_at}}</p>
                <p class="text-sm text-gray-500 mb-4">Total: ${{$order->total_amount}}</p>
            </div>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-md">Track Order</button>
        </div>
    @endforeach
</div>
