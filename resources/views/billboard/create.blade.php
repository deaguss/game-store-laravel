@extends('layouts.main')

@section('title', 'Create')

@section('content')
<div class="py-5">
    {{ Breadcrumbs::render('admin.billboard.create') }}
</div>
<div class="p-4 px-4 md:p-8 mb-6">
    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
        <div class="text-gray-600">
            <p class="font-medium text-lg">Billboard Details</p>
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

            <form action="store" method="post" enctype="multipart/form-data" class="lg:col-span-2">
                @csrf

                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                    <div class="md:col-span-5">
                        <label for="label" class="block mb-2 text-sm font-medium text-gray-900">Label</label>
                        <input type="text" name="label" id="label"
                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            placeholder="Write the label here..." />
                    </div>
                    <div class="md:col-span-5">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                        <textarea id="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Write description here..." name="description"></textarea>
                    </div>
                    <div class="md:col-span-5 mt-5">
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900">Upload image</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 "><span class="font-semibold">Click to
                                            upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 ">PNG, JPG or JPEG</p>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" name="image" />
                            </label>
                        </div>
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