@extends('shopify.layout.main')

@section('title', 'API')

@section('content')
<div class="antialiased">
    <div class="header_api">
        <h1 class="text-4xl font-bold">API</h1>
        <h5 class="font-thin text-lg text-gray-500 mb-3">API class for Games</h5>
        <hr>
    </div>
    <div class="generate_key py-5">
        <div class="mb-5">
            <label class="text-md font-mono p-1 bg-gray-200 rounded">Your token:</label>
            <input type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-gray-500 focus:border-gray-500 block w-min mt-2 p-2.5 font-mono"
                disabled value="{{$token}}">
        </div>
    </div>
    <div class="list_api py-4">
        <div class="container_list w-full h-auto rounded-lg bg-none border border-gray-200 p-3 px-4 mb-3">
            <div class="header_content flex gap-2">
                @svg('tabler-category', 'w-7 h-7 text-gray-700')
                <p class="px-1.5 py-0.5 text-sm bg-gray-200 rounded font-semibold items-center inline">HOW TO USAGE
                </p>
            </div>
            <div class="url_api p-2 mt-2">
                <div
                    class="inline relative rounded bg-muted px-[.3rem] py-[.2rem] font-mono text-sm font-semibold bg-gray-200">
                    <code>Accept: </code>
                    <code>application/json</code>
                </div>
            </div>
            <div class="url_api p-2">
                <div
                    class="inline relative rounded bg-muted px-[.3rem] py-[.2rem] font-mono text-sm font-semibold bg-gray-200">
                    <code>Authorization: </code>
                    <code>Bearer `{$token}`</code>
                </div>
            </div>
        </div>
        <div class="container_list w-full h-28 rounded-lg bg-none border border-gray-200 p-3 px-4">
            <div class="header_content flex gap-2">
                @svg('css-games', 'w-7 h-7 text-gray-700')
                <h3 class="font-semibold text-gray-700 text-lg">GET</h3>
                <p class="px-1.5 py-0.5 text-sm bg-gray-200 rounded font-semibold flex items-center">public</p>
                <p class="px-1.5 py-0.5 text-sm bg-gray-200 rounded font-semibold flex items-center">BASE_URL</p>
            </div>
            <div class="url_api p-2 mt-2">
                <code
                    class="relative rounded bg-muted px-[.3rem] py-[.2rem] font-mono text-sm font-semibold bg-gray-200">http://localhost:8000/api</code>
            </div>
        </div>
        <div class="container_list w-full h-28 rounded-lg bg-none border border-gray-200 p-3 px-4 my-3">
            <div class="header_content flex gap-2">
                @svg('css-games', 'w-7 h-7 text-gray-700')
                <h3 class="font-semibold text-gray-700 text-lg">GET</h3>
                <p class="px-1.5 py-0.5 text-sm bg-gray-200 rounded font-semibold flex items-center">public</p>
                <p class="px-1.5 py-0.5 text-sm bg-gray-200 rounded font-semibold flex items-center">ALL GAMES</p>
            </div>
            <div class="url_api p-2 mt-2">
                <code
                    class="relative rounded bg-muted px-[.3rem] py-[.2rem] font-mono text-sm font-semibold bg-gray-200">http://localhost:8000/api/games</code>
            </div>
        </div>
        <div class="container_list w-full h-28 rounded-lg bg-none border border-gray-200 p-3 px-4 my-3">
            <div class="header_content flex gap-2">
                @svg('css-games', 'w-7 h-7 text-gray-700')
                <h3 class="font-semibold text-gray-700 text-lg">GET</h3>
                <p class="px-1.5 py-0.5 text-sm bg-gray-200 rounded font-semibold flex items-center">public</p>
                <p class="px-1.5 py-0.5 text-sm bg-gray-200 rounded font-semibold flex items-center">DETAIL GAME</p>
            </div>
            <div class="url_api p-2 mt-2">
                <code
                    class="relative rounded bg-muted px-[.3rem] py-[.2rem] font-mono text-sm font-semibold bg-gray-200">http://localhost:8000/api/games/{id}</code>
            </div>
        </div>

        @if (Auth::user()->role === 'admin')
        <div class="container_list w-full h-auto rounded-lg bg-none border border-gray-200 p-3 px-4 my-3">
            <div class="header_content flex gap-2">
                @svg('css-games', 'w-7 h-7 text-gray-700')
                <h3 class="font-semibold text-gray-700 text-lg">POST</h3>
                <p class="px-1.5 py-0.5 text-sm bg-cyan-100 rounded font-semibold flex items-center">private</p>
                <p class="px-1.5 py-0.5 text-sm bg-red-100 rounded font-semibold flex items-center">POST GAME</p>
            </div>
            <div class="url_api p-2 mt-2">
                <code
                    class="relative rounded bg-muted px-[.3rem] py-[.2rem] font-mono text-sm font-semibold bg-gray-200">http://localhost:8000/api/games</code>
            </div>
            <div class="att p-2 mt-2">
                <code
                    class="relative rounded bg-muted px-[.3rem] py-[.2rem] font-mono text-sm font-semibold bg-gray-200">Attributes:</code>
                <div class="grid grid-cols-4 gap-4 mt-2">
                    <code
                        class="relative rounded bg-muted px-[.3rem] py-[.2rem] text-sm font-semibold">title: [VARCHAR (225)]:</code>
                    <code
                        class="relative rounded bg-muted px-[.3rem] py-[.2rem] text-sm font-semibold">description: [TEXT]:</code>
                    <code
                        class="relative rounded bg-muted px-[.3rem] py-[.2rem] text-sm font-semibold">image: [VARCHAR (225)]:</code>
                    <code
                        class="relative rounded bg-muted px-[.3rem] py-[.2rem] text-sm font-semibold">developer: [VARCHAR (225)]:</code>
                    <code
                        class="relative rounded bg-muted px-[.3rem] py-[.2rem] text-sm font-semibold">release_date: [DATE]:</code>
                    <code
                        class="relative rounded bg-muted px-[.3rem] py-[.2rem] text-sm font-semibold">category: [CHAR (36) (category_id)]:</code>
                    <code
                        class="relative rounded bg-muted px-[.3rem] py-[.2rem] text-sm font-semibold">price: [DECIMAL (10, 2)]:</code>
                </div>
            </div>
        </div>
        <div class="container_list w-full h-auto rounded-lg bg-none border border-gray-200 p-3 px-4 my-3">
            <div class="header_content flex gap-2">
                @svg('css-games', 'w-7 h-7 text-gray-700')
                <h3 class="font-semibold text-gray-700 text-lg">DELETE</h3>
                <p class="px-1.5 py-0.5 text-sm bg-cyan-100 rounded font-semibold flex items-center">private</p>
                <p class="px-1.5 py-0.5 text-sm bg-red-100 rounded font-semibold flex items-center">DELETE GAME</p>
            </div>
            <div class="url_api p-2 mt-2">
                <code
                    class="relative rounded bg-muted px-[.3rem] py-[.2rem] font-mono text-sm font-semibold bg-gray-200">http://localhost:8000/api/games/{id}/delete</code>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection