@extends('shopify.layout.main')

@section('title', 'Library')

@section('content')
<div class="content_library antialiased">
    <div class="header_cart flex items-center gap-4">
        <h1 class="font-semibold text-5xl">Library</h1>
        <button class="mt-3" title="Refresh game library" onclick="window.location.reload()">@svg('go-sync-16', 'w-6
            h-6')</button>
    </div>
    <div class="href_cart_library py-1 pt-6 flex gap-4">
        <a href="/cart"
            class="font-medium {{ Request::is('cart') ? 'text-black underline underline-offset-2' : 'text-gray-600'}} text-2xl">Cart</a>
        <a href="/library"
            class="font-medium {{ Request::is('library') ? 'text-black underline underline-offset-2' : 'text-gray-600'}} text-2xl">Library</a>
    </div>
    <div class="category_list py-8">
        <h1 class="font-semibold text-xl py-2">Filters</h1>
        <div class="select_by_date">
            <form action="" class="flex items-center gap-2" id="myForm" method="get">
                <h5 class="font-semibold">Sort by:</h5>
                <select name="sortBy" onchange="submitForm()"
                    class="select_option_game text-black text-base font-semibold rounded-lg block w-auto py-1.5 px-2.5 hover:ring-white focus:outline-none">
                    <option selected class="capitalize text-black">All Games</option>
                    <option class="capitalize text-black">Latest</option>
                    <option class="capitalize text-black">Oldest</option>
                </select>
            </form>
        </div>
    </div>
    <div class="game_list">
        <hr>

        <div class="list_game mt-10 pb-10 grid grid-cols-4 gap-x-20 gap-y-6">
            @if (count($data) > 0)
            @foreach ($data as $index => $games)
            @foreach ($games->libraries as $game)
            <div class="group h-[30rem] max-h-[30rem]">
                <div
                    class="flex flex-col p-2 items-center w-72 max-w-72 bg-white rounded-lg hover:bg-gray-100 group-hover:transition-all duration-300 group-hover:ease-in-out group-hover:drop-shadow">

                    <img src="{{ $game->imageUrl }}" class="w-64 h-64 max-w-64 max-h-64 rounded-lg object-cover"
                        alt="pic">
                    <div class="content_card_game px-4 py-2 w-full">
                        <p
                            class="font-bold text-sm text-black text-opacity-80 capitalize px-2.5 py-1 bg-gradient-to-r from-green-300 to-green-200 rounded-full m-auto inline">
                            #{{ $game->developer }}
                        </p>
                        <h5 class="mb-2 mt-2 antialiased text-lg font-bold tracking-tight text-black/90 ">
                            {{$game->title}}</h5>

                        <div class="flex flex-col">

                            <a href="#"
                                class="hidden group-hover:flex transition-all duration-300 ease-in-out w-full mt-2 text-white bg-gradient-to-r from-gray-500 to-gray-400 focus:ring-4 focus:outline-none focus:ring-gray-300 font-bold rounded-lg text-base px-5 py-2.5 justify-center items-center gap-2">
                                @svg('polaris-minor-install', 'w-5 h-5') Install
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endforeach
            @else
            <div class="col-span-4">
                <h3
                    class="text-gray-600 font-semibold text-5xl text-nowrap flex justify-center py-20 items-center gap-3">
                    @svg('pixelarticons-gamepad' , 'w-16 h-16') No games</h3>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection