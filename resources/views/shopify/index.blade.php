@extends('shopify.layout.main')

@section('title', 'Dashboard')

@section('content')
<div class="container_main">
    <div class="container_banner flex gap-4">
        <a href="/" class="banner_game relative">
            <img src="{{ $billboard->imageUrl }}" alt="{{ $billboard->label }}"
                class="w-[54rem] h-[35rem] max-w-[54rem] max-h-[35rem] object-cover rounded-xl">
            <div class="absolute top-28 left-20 text-white me-[30rem]">
                <h5 class="font-semibold text-2xl capitalize text-gray-300">{{ $billboard->label }}</h5>
                <h1 class="font-bold text-7xl text-balance capitalize">{{ $billboard->description}}</h1>
                <button type="button"
                    class="text-white hover:text-black border-2 border-white hover:bg-white focus:ring-4 focus:outline-none focus:ring-gray-400 font-medium rounded-full text-base px-6 py-3.5 text-center me-2 mb-2 mt-20 flex items-center gap-5 hover:transition-all hover:ease-in-out">View
                    offers @svg('bxs-right-arrow', 'w-3 h-3')</button>
            </div>
        </a>
        <div class="category_list relative">
            <div class="grid grid-cols-2
            gap-x-56 absolute top-28 gap-y-16">
                @foreach ($data as $index => $category)
                @php
                $bgColors = [
                'from-orange-300 to-orange-200',
                'from-blue-300 to-blue-200',
                'from-green-300 to-green-200',
                'from-purple-300 to-purple-200'
                ];
                $bgClass = $bgColors[$index % count($bgColors)];
                @endphp

                <a href="#"
                    class="block w-48 h-48 max-w-sm bg-gradient-to-r {{ $bgClass }} rounded-lg drop-shadow-lg hover:bg-orange-600 relative group">
                    @if ($category->games->isNotEmpty())
                    <img src="{{{ $category->games[0]->imageUrl }}}"
                        class="rounded-xl w-40 h-40 max-w-40 max-h-40 object-cover absolute -top-10 left-4 group-hover:-top-12 group-hover:transition-all duration-300 group-hover:ease-in-out">
                    @endif
                    <div class="absolute bottom-3 left-4 font-semibold text-white">
                        <h5 class="capitalize">{{ $category->name }}</h5>
                        <p class="text-sm font-medium text-gray-100 text-opacity-75">{{count($category->games) ?? '0'}}
                            games</p>
                    </div>
                </a>
                @endforeach
                <div class="relative mt-16 group ">
                    <a href="#"
                        class="block w-48 h-32 max-w-sm bg-gradient-to-r from-red-300 to-red-200 rounded-lg drop-shadow-lg hover:bg-orange-600">
                        <div class="absolute bottom-3 left-4 font-semibold text-white">
                            <h5>Show All</h5>
                            <p class="text-sm font-medium text-gray-100 text-opacity-75">10+ Categories</p>
                        </div>
                    </a>
                    <div
                        class="block w-48 h-32 max-w-sm bg-gradient-to-r from-green-300 to-green-200 rounded-lg -z-10 hover:bg-orange-600 absolute -top-2 -left-2 group-hover:-top-3 group-hover:-left-3 group-hover:transition-all duration-300 group-hover:ease-in-out">
                    </div>
                    <div
                        class="block w-48 h-32 max-w-sm bg-gradient-to-r from-blue-300 to-blue-200 rounded-lg -z-20 hover:bg-orange-600 absolute -top-4 -left-4 group-hover:-top-5 group-hover:-left-5 group-hover:transition-all duration-300 group-hover:ease-in-out">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="game_with_category mt-10">
        <div class="category_for_game_list">
            <h1 class="font-bold text-4xl">Game Publishers</h1>
            <div class="flex gap-5 items-center justify-between">
                <div class="form_select_games mt-5">
                    <form action="" class="inline" id="myForm" method="get">
                        <select name="category" id="countries" onchange="submitForm()"
                            class="select_option_game bg-gradient-to-r from-red-500 to-red-400 border-2 border-white shadow-md text-white text-lg font-semibold rounded-lg block w-56 p-3 hover:ring-white focus:outline-none">
                            <option selected class="capitalize text-black">All Games</option>
                            @foreach ($getCategories as $category)
                            <option value="{{ $category->name}}" class="capitalize text-black">{{ $category->name}}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="free_games mt-7">
                    <form action="" class="inline" method="get">
                        <input type="hidden" name="price" value="free">
                        <button type="submit"
                            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white focus:ring-4 focus:outline-none focus:ring-pink-200">
                            <span
                                class="relative px-4 py-3 transition-all ease-in duration-75 bg-[#F8F8F8] text-base rounded-md group-hover:bg-opacity-0 font-bold flex items-center capitalize">
                                free games @svg('bx-dollar', 'w-5 h-5')
                            </span>
                        </button>

                    </form>
                </div>
            </div>
        </div>

        <div class="list_game mt-10 pb-10 grid grid-cols-4 gap-x-20 gap-y-6">
            @if (count($games) > 0)
            @foreach ($games as $index => $game)
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
                        <h5 class="text-xl font-bold {{$game->price == null ? 'text-red-400' : 'text-orange-400'}}">
                            {{$game->price == null ? 'Free' : '$'.$game->price}}
                        </h5>

                        <div class="flex flex-col">
                            <form action="library/{{ $game->id }}" method="post" class="inline">
                                @csrf
                                @method("post")
                                <button type="submit"
                                    class="flex w-full mt-2 text-white bg-gradient-to-r from-gray-500 to-gray-400 focus:ring-4 focus:outline-none focus:ring-gray-300 font-bold rounded-lg text-base px-5 py-2.5 justify-center items-center gap-2">
                                    @svg('simpleline-plus', 'w-5 h-5') Add to Libary
                                </button>
                            </form>

                            <form action="cart/{{ $game->id }}" method="post" class="inline">
                                @csrf
                                @method("post")
                                <button type="submit"
                                    class="hidden group-hover:flex transition-all duration-300 ease-in-out w-full mt-2 text-white bg-gradient-to-r from-red-500 to-red-400 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-lg text-base px-5 py-2.5 justify-center items-center gap-2">
                                    @svg('grommet-shop', 'w-5 h-5') Add to cart
                                </button>
                            </form>
                        </div>
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
        @if($games->hasPages() && count($games) > 0)
        <div id="load-more-container" class="py-16 flex justify-center items-center">
            <a href="{{ url('/?page=' . ($games->currentPage() + 1)) }}"
                class="text-orange-400 hover:text-white border border-orange-300 hover:bg-orange-500 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-full text-lg px-10 py-5 text-center me-2 mb-2 flex items-center justify-center gap-2">Load
                More @svg('ri-arrow-drop-down-fill', 'w-8 h-8')</a>
        </div>
        @endif
    </div>
    @if (Session::has('status') && Session::has('message'))
    <div
        class="{{Session::get('status') == 'success' ? 'bg-green-500 ' : 'bg-red-500 ' }}text-white p-4 mb-4 rounded-md fixed bottom-5 right-0">
        <div class="flex justify-between">
            <div>
                <strong>{{ Session::get('status') }}</strong> - {{ Session::get('message') }}
            </div>
            <div>
            </div>
        </div>
    </div>
    @endif

</div>

@endsection