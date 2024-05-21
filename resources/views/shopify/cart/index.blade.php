@extends('shopify.layout.main')

@section('title', 'Cart')

@section('content')
<div class="content_cart antialiased">
    <div class="header_cart flex items-center gap-4">
        <h1 class="font-semibold text-5xl">My Cart</h1>
        <button class="mt-3" title="Refresh game library" onclick="window.location.reload()">@svg('go-sync-16', 'w-6
            h-6')</button>
    </div>
    <div class="href_cart_library py-1 pt-6 flex gap-4">
        <a href="/cart"
            class="font-medium {{ Request::is('cart') ? 'text-black underline underline-offset-2' : 'text-gray-600'}} text-2xl">Cart</a>
        <a href="/library"
            class="font-medium {{ Request::is('library') ? 'text-black underline underline-offset-2' : 'text-gray-600'}} text-2xl">Library</a>
    </div>
    <div class="game_list mt-8">
        <hr>
        <div class="flex gap-10">
            <div class="list_game mt-10 pb-10 flex flex-col gap-x-20 gap-y-6 flex-1">
                @if (count($data) > 0)
                @foreach ($data as $index => $game)
                <div class="col-span-3 bg-white p-4 rounded-lg pb-10 flex gap-4 relative">
                    <img src="{{ $game->imageUrl }}" class="h-[10rem] max-h-[10rem] w-[8rem] max-w-[8rem] object-cover"
                        alt="">
                    <div class="content_card ">
                        <div class="c_left">
                            <h5
                                class="p-0.5 inline px-2 bg-gray-600 rounded-md text-white text-opacity-50 uppercase text-xs">
                                Category
                            </h5>
                            <h1 class="font-semibold text-xl">{{ $game->title }}</h1>
                            <p class="mt-4">{{ Str::limit($game->description, 40).'...' }}</p>
                        </div>
                        <div class="c_right absolute right-7 top-2 flex flex-col items-end">
                            <h1 class="font-bold text-xl">{{ '$' . $game->price }}</h1>
                            <p class="text-sm opacity-75">{{ $game->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div class="c_right_btn absolute right-4 bottom-2">
                            <button type="button"
                                class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-md text-sm px-5 py-2.5 text-center me-2 mb-2 uppercase">remove</button>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-span-4">
                    <h3
                        class="text-gray-600 font-semibold text-5xl text-nowrap flex justify-center py-20 items-center gap-3">
                        @svg('pixelarticons-gamepad' , 'w-16 h-16') No games</h3>
                </div>
                @endif
            </div>

            @if (!empty($cartTotal))
            <div class="total_price_games w-[25%] max-w-[25%] mt-10">
                <h1 class="font-semibold text-3xl pb-2">Games and Apps Summary</h1>
                <div class="total_games flex justify-between font-semibold text-base my-4">
                    <p>Total</p>
                    <p>{{ $cartTotal->total_games }}</p>
                </div>
                <hr>
                <div class="total_price flex justify-between font-semibold text-base my-4">
                    <p>Subtotal</p>
                    <p>{{ '$'.$cartTotal->subtotal }}</p>
                </div>
                <button type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-sm text-sm px-5 py-3.5 me-2 mb-2 uppercase w-full">checkout</button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection