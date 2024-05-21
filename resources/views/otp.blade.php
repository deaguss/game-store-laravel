<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Otp verification</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="relative py-16 bg-gradient-to-br from-sky-50 to-gray-200 h-screen">
        <div class="relative container m-auto px-3 text-gray-500 md:px-12 xl:px-40">
            <div class="m-auto md:w-8/12 lg:w-6/12 xl:w-6/12">
                <div class="rounded-xl bg-white shadow-xl">
                    <div class="p-6 sm:p-16">
                        <div class="space-y-4">
                            <h2 class="mb-8 text-2xl text-cyan-900 font-bold">Otp Verification.
                            </h2>
                        </div>
                        @if ($errors->any())
                        <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                @foreach ($errors->all() as $error)
                                <span class="font-medium">Danger alert!</span> {{ $error }}
                                @endforeach
                            </div>
                        </div>

                        @endif
                        <div class="mt-16">
                            <form class="max-w-sm mx-auto" action="otp-validation" method="POST">
                                @csrf
                                <div class="mb-5">
                                    <label for="otp" class="block mb-2 text-sm font-medium text-gray-900">Otp
                                        code</label>
                                    <input type="otp" id="otp" name="otp"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="G5HVGK" required>
                                </div>

                                <button type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
                            </form>
                        </div>
                        <div class="mt-24 space-y-4 text-gray-600 text-center sm:-mb-8">
                            <p class="text-xs">By proceeding, you agree to our <a href="#" class="underline">Terms of
                                    Use</a> and confirm you have read our <a href="#" class="underline">Privacy and
                                    Cookie Statement</a>.</p>
                            <p class="text-xs">This site is protected by reCAPTCHA and the <a href="#"
                                    class="underline">Google Privacy Policy</a> and <a href="#" class="underline">Terms
                                    of Service</a> apply.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>