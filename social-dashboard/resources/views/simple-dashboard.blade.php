<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Use Tailwind CDN for immediate zero-config styling as requested -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-indigo-600">Laravel Dashboard</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, {{ auth()->check() ? auth()->user()->name : 'Guest' }}</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 mb-2">Social Media Analytics</h1>
                <p class="text-gray-600">Real-time Reddit engagement monitoring for <span class="font-bold text-indigo-500">r/{{ $current_subreddit }}</span>.</p>
            </div>
            
            <form action="{{ route('dashboard') }}" method="GET" class="mt-4 md:mt-0 flex">
                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm font-medium">r/</span>
                    </div>
                    <input type="text" name="subreddit" value="{{ $current_subreddit }}" 
                        class="block w-full pl-8 pr-4 py-2.5 sm:text-sm rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition shadow-sm" 
                        placeholder="webdev">
                </div>
                <button type="submit" 
                    class="relative -ml-px inline-flex items-center px-5 py-2.5 border border-transparent text-sm leading-5 font-semibold rounded-r-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm">
                    Fetch
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="text-gray-500 text-sm font-semibold uppercase">Total Likes</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($metrics['total_likes']) }}</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="text-gray-500 text-sm font-semibold uppercase">Total Comments</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($metrics['total_comments']) }}</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="text-gray-500 text-sm font-semibold uppercase">Avg Engagement</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">{{ $metrics['avg_engagement'] }}</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="text-gray-500 text-sm font-semibold uppercase">Posts Tracked</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">{{ $metrics['total_posts'] }}</div>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Top Performing Posts</h2>
        <div class="space-y-4">
            @foreach($posts as $post)
            <a href="{{ $post->permalink }}" target="_blank" class="block bg-white rounded-xl shadow hover:shadow-lg hover:-translate-y-1 transition duration-200 p-4 border border-gray-100 group">
                <div class="flex items-start space-x-4">
                    @if($post->thumbnail && !in_array($post->thumbnail, ['self', 'default', '']))
                        <img src="{{ $post->thumbnail }}" alt="Thumbnail" class="w-16 h-16 rounded-md object-cover flex-shrink-0">
                    @endif
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition">{{ $post->title }}</h4>
                        <div class="flex items-center space-x-3 mt-2 text-sm text-gray-500">
                            <span>By u/{{ $post->author }}</span>
                            <span>&bull;</span>
                            <span class="text-red-500 font-semibold">&uarr; {{ $post->score }}</span>
                            <span class="text-blue-500 font-semibold">💬 {{ $post->num_comments }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</body>
</html>
