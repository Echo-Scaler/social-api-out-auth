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
        <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 mb-2">Social Media Analytics</h1>
        <p class="text-gray-600 mb-8">Real-time Reddit engagement monitoring using standard Laravel Blade and Tailwind.</p>

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
