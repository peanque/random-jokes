<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Random Jokes Viewer</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');
        </style>
    @endif
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 min-h-screen p-4">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-semibold text-slate-900 dark:text-white mb-2">Random Jokes Viewer</h1>
            <p class="text-slate-600 dark:text-slate-400">Enjoy some programming humor!</p>
        </div>

        <div class="mb-6 flex justify-center">
            <form action="{{ route('jokes') }}" method="GET" class="inline-block">
                <button 
                    type="submit"
                    class="flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl hover:cursor-pointer transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <span>Get New Random Jokes</span>
                </button>
            </form>
        </div>

        <div id="jokesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($jokes as $joke)
                <div class="joke-card bg-white dark:bg-slate-800 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-200 p-6 border border-slate-200 dark:border-slate-700">
                    <div class="flex items-start mb-4">
                        <p class="text-green-500 dark:text-green-200 text-lg font-medium leading-relaxed">
                            <span class="text-blue-500 dark:text-blue-200 text-lg font-medium leading-relaxed">Category:</span>
                            <br>
                            {{ ucfirst($joke['type']) }}
                        </p>
                    </div>
                    <div class="space-y-3">
                        <p class="text-slate-800 dark:text-slate-200 text-lg font-medium leading-relaxed">
                            <span class="text-blue-500 dark:text-blue-200 text-lg font-medium leading-relaxed">Question:</span>
                            <br>
                            {{ $joke['setup'] }}
                        </p>
                        <div class="pt-3 border-t border-slate-200 dark:border-slate-700">
                            <span class="text-blue-500 dark:text-blue-200 text-lg font-medium leading-relaxed">Answer:</span>
                            <br>
                            <p class="text-blue-600 dark:text-blue-400 text-base font-semibold">
                                {{ $joke['punchline'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</body>
</html>