@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="py-5">
    {{ Breadcrumbs::render('admin.profile') }}
</div>
<div class="p-4 px-4 md:p-8 mb-6">
    <div class="grid gap-16 gap-y-2 grid-cols-1 lg:grid-cols-3">
        <div>
            <p class="font-medium text-xl py-2">User Settings</p>
            <hr class="h-2">
            <ul class="text-gray-700 py-1">
                <li class="py-2">
                    <a href="#" class="font-medium hover:text-gray-900 hover:underline flex gap-2 items-center">
                        @svg('antdesign-setting',
                        'w-5 h-5')
                        Settings
                    </a>
                </li>
                <li class="py-2 font-medium hover:text-gray-900 hover:underline flex gap-2 items-center">
                    <a href="#" class="font-medium hover:text-gray-900 hover:underline flex gap-2 items-center">
                        @svg('carbon-password',
                        'w-5 h-5')
                        Change Password
                    </a>
                </li>
                <li class="py-2 font-medium hover:text-gray-900 hover:underline flex gap-2 items-center">
                    <a href="#" class="font-medium hover:text-gray-900 hover:underline flex gap-2 items-center">
                        @svg('bxs-user-detail',
                        'w-5 h-5')
                        Account Details
                    </a>
                </li>
                <li class="py-2 font-medium hover:text-gray-900 hover:underline flex gap-2 items-center">
                    <a href="/logout" class="font-medium hover:text-gray-900 hover:underline flex gap-2 items-center">
                        @svg('ri-logout-box-line',
                        'w-5 h-5')
                        Log out
                    </a>
                </li>
            </ul>
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

            <form action="profile/update" method="post" enctype="multipart/form-data" class="lg:col-span-2">
                @csrf
                @method('PUT')
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                    <div class="md:col-span-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" id="email"
                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            placeholder="Write the email here..." value="{{ Auth::user()->email}}" disabled />
                    </div>
                    <div class="md:col-span-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                        <input type="name" name="name" id="name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            placeholder="Write the name here..." value="{{ Auth::user()->name}}" />

                        <div class="md:col-span-5 mt-5">
                            <label for="" class="block mb-2 text-sm font-medium text-gray-900">Upload Photo
                                profile</label>
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
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection