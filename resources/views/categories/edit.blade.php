@extends('layouts.main')

@section('title', 'Edit')

@section('content')
<div class="py-5">
    {{ Breadcrumbs::render('admin.category.edit', $category->id) }}
</div>
<div class="p-4 px-4 md:p-8 mb-6">
    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
        <div class="text-gray-600">
            <p class="font-medium text-lg">Category Details</p>
            <p>Please fill out all the fields.</p>
        </div>

        <div class="lg:col-span-2">
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

            <form action="{{ $category->id }}/update" method="post" class="lg:col-span-2">
                @csrf
                @method('PUT')
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                    <div class="md:col-span-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">name</label>
                        <input type="text" name="name" id="name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            placeholder="Write the name here..." value="{{ $category->name }}" />
                    </div>
                    <div class="md:col-span-5">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                        <textarea id="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Write description here..."
                            name="description">{{ $category->description }}</textarea>
                    </div>
                    <div class="md:col-span-5 mt-5">
                        <div class="md:col-span-5 text-right mt-3">
                            <div class="inline-flex items-end">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection