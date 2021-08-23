<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Forest - A Project Management Tool For Small Teams</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

    </style>
</head>

<body class="antialiased">
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="mx-auto">
            <div class="flex justify-center pt-8 sm:pt-0">
                <x-application-logo class="w-40 h-40 fill-current text-gray-500" />
            </div>
            <h1 class="text-2xl text-center text-gray-700">Forest</h1>
            <h4 class="text-lg text-center text-gray-500">A Project Management Tool For Small Teams</h4>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <x-application-logo class="h-6 w-6" />
                            <div class="ml-4 text-lg leading-7 font-semibold"><a href="/register"
                                    class="text-gray-900 dark:text-white">Sign Up</a>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <x-application-logo class="h-6 w-6" />
                            <div class="ml-4 text-lg leading-7 font-semibold"><a href="/login"
                                    class="text-gray-900 dark:text-white">Login</a>
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
