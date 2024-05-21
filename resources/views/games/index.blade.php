@extends('layouts.main')

@section('title', 'Games')

@section('content')
<div class="container">
    <div class="py-5">
        {{ Breadcrumbs::render('admin.game') }}
    </div>
    <div class="grid grid-flow-col gap-5">
        <a href="/admin/game"
            class="block max-w-xs py-8 ps-10 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
            <div class="flex gap-5">
                <div class="w-[4.5rem] h-[4.5rem] bg-blue-200 rounded-full flex items-center justify-center">
                    @svg('css-games', 'w-8 h-8 text-blue-600')
                </div>
                <div class="flex flex-col">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">
                        {{ count($games) ?? '0' }}
                    </h5>
                    <p class="font-normal text-gray-700 ">Total Games</p>
                </div>
            </div>
        </a>
        <a href="/admin/game/create"
            class="block max-w-xs py-8 ps-10 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
            <div class="flex gap-5">
                <div class="w-[4.5rem] h-[4.5rem] bg-green-200 rounded-full flex items-center justify-center">
                    @svg('sui-create', 'w-8 h-8 text-green-600')
                </div>
                <div class="flex flex-col">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">Create
                    </h5>
                    <p class="font-normal text-gray-700 ">Create a new billboard</p>
                </div>
            </div>
        </a>
        <a href="/admin/game"
            class="block max-w-xs py-8 ps-10 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
            <div class="flex gap-5">
                <div class="w-[4.5rem] h-[4.5rem] bg-yellow-200 rounded-full flex items-center justify-center">
                    @svg('bi-award', 'w-8 h-8 text-yellow-600')
                </div>
                <div class="flex flex-col">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">COC
                    </h5>
                    <p class="font-normal text-gray-700 ">
                        Popular Games
                    </p>
                </div>
            </div>
        </a>
        <a href="/admin/game/deleted"
            class="block max-w-xs py-8 ps-10 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
            <div class="flex gap-5">
                <div class="w-[4.5rem] h-[4.5rem] bg-red-200 rounded-full flex items-center justify-center">
                    @svg('heroicon-s-trash', 'w-8 h-8 text-red-600')
                </div>
                <div class="flex flex-col">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">
                        {{ $deletedGames ?? '0'}}
                    </h5>
                    <p class="font-normal text-gray-700 ">Total deleted</p>
                </div>
            </div>
        </a>
    </div>

    <div class="h-12 py-2">

    </div>

    <div class="py-2 mt-2">
        <form action="" method="get">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search"
                    class="block w-full p-4 ps-10 text-base text-gray-900 border-2 border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500 focus:border-2 outline-none"
                    placeholder="Search label, created by..." required name="search">
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-4 py-2">Search</button>
            </div>
        </form>
    </div>
    <div class="relative overflow-x-auto sm:rounded-lg mt-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 p-2">
            <thead class="text-xs text-gray-700 uppercase bg-white border-b-2 border-b-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Image
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Developer
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Release
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Create Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $data)
                <tr class="bg-white border-bhover:bg-gray-50 text-zinc-900">
                    <td class="px-6 py-4 font-semibold">
                        #{{ $loop->iteration }}
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        <a href="{{ $data->imageUrl }}">
                            <img src="{{ $data->imageUrl }}" alt="pic" class="w-10 h-10 rounded-full">
                        </a>
                    </th>
                    <td class="px-6 py-4 font-semibold">
                        {{ $data->title }}
                    </td>
                    <td class="px-6 py-4 font-semibold">
                        {{ Str::limit($data->description, 40).'...' }}
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium
                            text-green-600 bg-green-200 p-1 rounded-xl flex items-center justify-center">
                            {{'@'.$data->developer }}
                        </p>
                    </td>
                    <td class="px-6 py-4 font-semibold">
                        <a href="/admin/category" class="font-medium text-blue-600 hover:underline">
                            {{ $data->categories->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <p
                            class="font-medium {{ $data->price == null ? 'text-red-600 bg-red-200' : 'text-yellow-600 bg-yellow-200' }} p-1 rounded-xl flex items-center justify-center">
                            {{ $data->price == null ? 'Free' : '$'.$data->price }}
                        </p>
                    </td>
                    <td class="px-6 py-4 font-medium">
                        {{ $data->release_date}}
                    </td>
                    <td class="px-6 py-4">
                        {{ $data->created_at->format('Y-m-d') }}
                    </td>
                    <td class="px-6 py-4 text-right flex gap-4">
                        <a href="game/edit/{{ $data->id }}" class="font-medium text-blue-600 hover:underline">Edit</a>

                        <form action="game/delete/{{$data->id}}" method="POST" class="inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="font-medium text-red-600 hover:underline"
                                onclick="return confirm('Are you sure?') ? window.location.href='game/delete/{{$data->id}}' : false">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-1 py-2">
        {{ $games->withQueryString()->links() }}
    </div>
    <div class="absolute bottom-0 right-5">
        @if ($errors->any() || session('status'))
        <div class="flex items-center p-4 mb-4 text-sm {{ session('status') ? (session('status') === 'success' ? 'text-green-800' : 'text-red-800') : 'text-red-800' }} rounded-lg {{ session('status') ? (session('status') === 'success' ? 'bg-green-50' : 'bg-red-50') : 'bg-red-50' }}"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                @if ($errors->any())
                <span class="font-medium">Danger alert!</span>
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
                @endif

                @if (session('status'))
                <span class="font-medium">{{ ucfirst(session('status')) }} alert!</span>
                {{ session('message') }}
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection