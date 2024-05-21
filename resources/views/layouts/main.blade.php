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
    <nav class="border-gray-200 bg-gray-900 fixed z-50 w-full">
        <div class="max-w-screen-2xl flex flex-wrap items-center justify-between mx-auto p-4 px-6">
            <a href="/admin" class="flex items-center">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">Game Center</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm  rounded-lg md:hidden focus:outline-none focus:ring-2 text-gray-400 hover:bg-gray-700 focus:ring-gray-600"
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
                        <a href="#"
                            class="block py-2 px-3 rounded md:border-0 ext-blue-700 md:p-0 text-white md:hover:text-blue-500 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Settings</a>
                    </li>
                    <li>
                        <button id="dropdownToggleMail" data-dropdown-toggle="dropdownMail" type="button"
                            class="block py-2 px-3 rounded md:border-0 ext-blue-700 md:p-0 text-white md:hover:text-blue-500 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">@svg('feathericon-mail')</button>

                        <div id="dropdownMail"
                            class="z-10 hidden fixed divide-y divide-gray-100 rounded shadow w-60 bg-gray-700 h-min right-20 top-16">
                            <ul class="py-2 px-4 text-sm text-gray-200">
                                <li class="py-2 pb-3">
                                    <h1>Notification</h1>
                                </li>
                                <hr class="opacity-30">
                                <li class="py-2">
                                    @isset($otpCodes)

                                    @foreach($otpCodes as $otpCode)
                                    <div class="text-sm flex gap-4 items-center py-2">
                                        <div class="border-r border-white px-2 border-opacity-30">
                                            @svg('feathericon-mail', 'h-6 w-6')
                                        </div>
                                        <div>
                                            <h1 class="font-normal">{{ $otpCode->email }}</h1>
                                            <h2>Otp: <code>{{ $otpCode->otp_code }}</code> </h2>
                                            <p class="text-xs font-normal">{{ $otpCode->expired_at }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endisset
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <button id="dropdownToggle" data-dropdown-toggle="dropdown" type="button">
                            <img class="w-10 h-10 p-1 rounded-full ring-2 ring-gray-500"
                                src="{{ Auth::user()->image_url ?? asset('img/pic.png') }}">
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdown"
                            class="z-10 hidden fixed divide-y divide-gray-100 rounded-lg shadow w-44 bg-gray-700 right-10">
                            <ul class="py-2 text-sm text-gray-200" aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="/admin/profile"
                                        class="block px-4 py-2  hover:bg-gray-600 hover:text-white">Edit
                                        profile</a>
                                </li>
                                <li>
                                    <a href="/logout" class="block px-4 py-2  hover:bg-gray-600 hover:text-white">Sign
                                        out</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container flex">
        <div class="sidebar w-96 max-w-96 max-h-full">
            <button data-drawer-target="cta-button-sidebar" data-drawer-toggle="cta-button-sidebar"
                aria-controls="cta-button-sidebar" type="button"
                class="inline-flex items-center p-2 mt-2 ms-3 text-sm rounded-lg sm:hidden focus:outline-none focus:ring-2 text-gray-400 hover:bg-gray-700 focus:ring-gray-600">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                    </path>
                </svg>
            </button>

            <aside id="cta-button-sidebar"
                class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
                aria-label="Sidebar">
                <div class="h-full px-3 py-4 overflow-y-auto bg-gray-900">
                    <ul class="space-y-2 font-medium mt-20">
                        <li>
                            <a href="/admin"
                                class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                                <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 22 21">
                                    <path
                                        d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                    <path
                                        d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                                </svg>
                                <span class="ms-3">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/billboard"
                                class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                                @svg('mdi-billboard', 'w-5 h-5 transition duration-75 text-gray-400
                                group-hover:text-white', ['stroke-width' => '2'])

                                <span class="ms-3">Billboards</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/category"
                                class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                                @svg('tabler-category', 'w-5 h-5 transition duration-75 text-gray-400
                                group-hover:text-white', ['stroke-width' => '2'])

                                <span class="ms-3">Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/game"
                                class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                                <svg class="flex-shrink-0 w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 18">
                                    <path
                                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Games</span>
                                <span
                                    class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium rounded-full bg-gray-700 text-gray-300">All</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/users"
                                class="flex items-center p-2 rounded-lg text-white  hover:bg-gray-700 group">
                                <svg class="flex-shrink-0 w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 20 18">
                                    <path
                                        d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
        <div class="content py-16 px-10">
            @yield('content')
        </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        var dropdownToggle = document.getElementById("dropdownToggle");
        var dropdownMenu = document.getElementById("dropdown");

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

    document.addEventListener("DOMContentLoaded", function () {
        var dropdownToggle = document.getElementById("dropdownToggleMail");
        var dropdownMenu = document.getElementById("dropdownMail");

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