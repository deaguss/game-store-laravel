@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="welcome pt-8 text-2xl">
        <h1><strong>Welcome Back</strong>, {{ Auth::user()->name }}🗿</h1>
        <h1 class="text-sm pb-4">{{Auth::user()->email}}</h1>
        <hr>
    </div>
    <div class="py-5">
        {{ Breadcrumbs::render('admin') }}
    </div>
    <div class="grid grid-flow-col gap-5">
        <a href="/admin/billboard"
            class="block max-w-xs py-8 ps-10 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
            <div class="flex gap-5">
                <div class="w-[4.5rem] h-[4.5rem] bg-blue-200 rounded-full flex items-center justify-center">
                    @svg('mdi-billboard', 'w-8 h-8 text-blue-600')
                </div>
                <div class="flex flex-col">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">{{ $billboardsCount ?? '0' }}
                    </h5>
                    <p class="font-normal text-gray-700 ">Total Billboards</p>
                </div>
            </div>
        </a>
        <a href="/admin/game"
            class="block max-w-xs py-8 ps-10 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
            <div class="flex gap-5">
                <div class="w-[4.5rem] h-[4.5rem] bg-red-200 rounded-full flex items-center justify-center">
                    @svg('css-games', 'w-8 h-8 text-red-600')
                </div>
                <div class="flex flex-col">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">
                        {{ $gamesCount ?? '0' }}
                    </h5>
                    <p class="font-normal text-gray-700 ">Total Games</p>
                </div>
            </div>
        </a>
        <a href="/admin/category"
            class="block max-w-xs py-8 ps-10 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
            <div class="flex gap-5">
                <div class="w-[4.5rem] h-[4.5rem] bg-green-200 rounded-full flex items-center justify-center">
                    @svg('tabler-category', 'w-8 h-8 text-green-600')
                </div>
                <div class="flex flex-col">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">
                        {{ $categoriesCount ?? '0' }}
                    </h5>
                    <p class="font-normal text-gray-700 ">Total Categories</p>
                </div>
            </div>
        </a>
        <a href="/admin"
            class="block max-w-xs py-8 ps-10 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
            <div class="flex gap-5">
                <div class="w-[4.5rem] h-[4.5rem] bg-yellow-200 rounded-full flex items-center justify-center">
                    @svg('bxs-user-detail', 'w-8 h-8 text-yellow-600')
                </div>
                <div class="flex flex-col">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">{{ count($data) ?? '0' }}
                    </h5>
                    <p class="font-normal text-gray-700 ">Total Cart</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="bg-white mt-4 rounded-lg shadow-sm py-6">
    <h1 class="uppercase font-semibold text-2xl ms-5">overview</h1>
    <div class="flex gap-5 px-5">
        <div id="chartContainerUser" style="height: 370px; width:100%;"></div>

        <div id="chartContainerGame" style="height: 370px; width: 100%;"></div>
    </div>
</div>

<div class="flex gap-5 mt-5">
    <div class="relative overflow-x-auto sm:rounded-lg  py-3 bg-white rounded-lg h-min">
        <h1 class="py-3 uppercase font-semibold ps-6">recent order</h1>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 p-2">
            <thead class="text-xs text-gray-700 uppercase border-b-2 border-b-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Game Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Order Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Payment Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Costumers
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $cart)

                <tr class="bg-white border-bhover:bg-gray-50 text-zinc-900">
                    <td class="px-6 py-4 font-semibold">
                        #{{ $loop->iteration }}
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        <a href="{{ $cart->imageUrl }}" class="flex gap-2">
                            <img src="{{ $cart->imageUrl }}" alt="pic" class="w-10 h-10 rounded-sm object-cover">
                            {{ $cart->title }}
                        </a>
                    </th>
                    <td class="px-6 py-4 font-semibold">
                        {{ $cart->created_at->format('Y-m-d') }}
                    </td>
                    <td class="px-6 py-4 font-semibold">
                        <p
                            class="p-1 rounded-xl flex items-center justify-center {{ $cart->payment_status ?  'text-green-600 bg-green-200' : 'text-red-600 bg-red-200' }}">
                            {{ $cart->payment_status ? 'Lunas' : 'belum' }}
                        </p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium
                            text-green-600 bg-green-200 p-1 rounded-xl flex items-center justify-center">
                            ${{ $cart->price }}
                        </p>
                    </td>
                    <td class="px-6 py-4 font-semibold lowercase">
                        {{ $cart->name ? '@'.$cart->name : $cart->email }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-1 py-2">
            {{ $data->withQueryString()->links() }}
        </div>
    </div>


    <div class="cart bg-white w-72 h-max rounded">
        <div class="px-4 py-6">
            <div class="flex items-center justify-start pb-4 gap-2">
                @svg('codicon-library',
                'w-5 h-5 text-gray-500
                ', ['stroke-width' => '4'])
                <h1 class="font-semibold text-xl  text-gray-500">Total games In Library </h1>
            </div>
            <hr>
            <h1 class="font-semibold text-5xl py-4">{{ $libraryCount . '+'}}</h1>
        </div>
        <div class="most_game px-4">
            <div class="flex items-center justify-start pb-4 gap-2 text-gray-500">
                @svg('css-games',
                'w-6 h-6 text-gray-500
                ', ['stroke-width' => '4'])
                <h1 class="font-semibold text-xl">Top 3 Games</h1>
            </div>
            <hr>
            <div class="games py-4">
                @foreach ($mostGamesLibrary as $games)
                <div class="flex gap-3 py-2">
                    <img src="{{ $games->imageUrl }}" alt=""
                        class="w-28 max-w-28 h-32 max-h-32 object-cover rounded-md">
                    <h1 class="font-semibold">{{ $games->title }}</h1>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function () {
    fetch('/admin/chart-data')
        .then(response => response.json())
        .then(data => {
            var chart = new CanvasJS.Chart("chartContainerGame", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light2",
                title: {
                    text: "Game publishers"
                },
                axisY: {
                    includeZero: true
                },
                data: [{
                    type: "column",
                    indexLabelFontColor: "#5A5757",
                    indexLabelFontSize: 16,
                    indexLabelPlacement: "outside",
                    dataPoints: data.map(item => ({
                        x: item.month,
                        y: item.total_games
                    }))
                }]
            });
            chart.render();
        });


        fetch('/admin/chart-data-user')
        .then(response => response.json())
        .then(data => {

            var chart = new CanvasJS.Chart("chartContainerUser", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Users Registration"
                },
                data: [{
                    type: "line",
                    indexLabelFontSize: 16,
                    dataPoints: data.map(point => ({
                        y: point.count,
                        label: point.date,
                        indexLabel: point.indexLabel,
                        markerColor: point.markerColor,
                        markerType: point.markerType
                    }))
                }]
            });

            chart.render();
        })
    }

</script>


<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
@endsection