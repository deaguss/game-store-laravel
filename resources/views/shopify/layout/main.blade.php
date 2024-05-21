<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-[#F8F8F8]">
    <nav class="border-y-2 border-gray-200 bg-white">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto py-4">
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-zinc-800">
                    <img src="{{ asset('img/shop-logo.jpg')}}" class="w-full h-12 max-h-12" alt="logo">
                </span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm  rounded-lg md:hidden focus:outline-none focus:ring-2 text-gray-400 hover:bg-gray-200 focus:ring-gray-200"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col items-center md:p-0 border rounded-lg md:flex-row md:space-x-8 rtl:space-x-reverse md:border-0 bg-gray-800md:bg-gray-900 border-gray-700">
                    <li>
                        <div class="px-4 block">
                            <form>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="search" id="default-search"
                                        class="block w-full p-4 px-16 ps-10 text-sm text-black rounded-full bg-gray-200 outline-none"
                                        placeholder="Search" required>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li>
                        <a href="/cart"
                            class="block py-2 px-3 rounded md:border-0 ext-blue-700 md:p-0 text-black md:hover:text-zinc-800">@svg('grommet-shop',
                            'w-7 h-7')</a>
                    </li>
                    <li>
                        @if (!empty(Auth::user()))
                        <button id="dropdownToggleUser" data-dropdown-toggle="dropdown" type="button">
                            <img class="w-10 h-10 p-1 rounded-full ring-2 ring-gray-300"
                                src="{{ Auth::user()->image_url ?? asset('img/pic.png') }}">
                        </button>

                        <div id="dropdown"
                            class="z-10 hidden fixed bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="/profile" class="block px-4 py-2 hover:bg-gray-100">Edit
                                        profile</a>
                                </li>
                                <li>
                                    <a href="/api" class="block px-4 py-2 hover:bg-gray-100">API</a>
                                </li>
                                <li>
                                    <a href="/logout" class="block px-4 py-2 hover:bg-gray-100">Sign
                                        out</a>
                                </li>
                            </ul>
                        </div>
                        @else
                        <a href="/login"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-4 py-2.5 me-2 mb-2 flex items-center gap-1">@svg('heroicon-o-user',
                            'w-4 h-4') Login</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container px-32 py-6">
        @yield('content')
    </div>
    <script>
        function submitForm() {
            document.getElementById("myForm").submit();
        }

        document.addEventListener("DOMContentLoaded", function () {
        let dropdownToggle = document.getElementById("dropdownToggleUser");
        let dropdownMenu = document.getElementById("dropdown");

        dropdownToggle.addEventListener("click", function () {
            dropdownMenu.classList.toggle("hidden");
        });

        document.addEventListener("click", function (event) {
            if (
                !dropdownToggle.contains(event.target) &&
                !dropdownMenu.contains(event.target)
            ) {
                dropdownMenu.classList.add("hidden");
            }
        });
    });
    </script>
</body>

</html>