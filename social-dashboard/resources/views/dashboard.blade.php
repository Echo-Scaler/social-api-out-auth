<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Social Media Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h1 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 mb-1">Live Dashboard</h1>
                        <p class="text-gray-600 text-sm">Real-time Reddit engagement monitoring for <span class="font-bold text-indigo-500">r/{{ $current_subreddit }}</span>.</p>
                    </div>
                    
                    <form action="{{ route('dashboard') }}" method="GET" class="mt-4 md:mt-0 flex">
                        <div class="relative flex items-stretch flex-grow focus-within:z-10">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm font-medium">r/</span>
                            </div>
                            <input type="text" name="subreddit" value="{{ $current_subreddit }}" 
                                class="block w-full pl-8 pr-4 py-2 sm:text-sm border-gray-300 rounded-l-md focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm" 
                                placeholder="webdev">
                        </div>
                        <button type="submit" 
                            class="relative -ml-px inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-semibold rounded-r-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm">
                            Fetch
                        </button>
                    </form>
                </div>
            </div>

            <!-- Metrics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Total Likes</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($metrics['total_likes']) }}</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Total Comments</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($metrics['total_comments']) }}</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Avg Engagement</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $metrics['avg_engagement'] }}</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Posts Tracked</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $metrics['total_posts'] }}</div>
                </div>
            </div>

            <!-- Posts List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Top Performing Posts</h2>
                    <div class="space-y-4">
                        @foreach($posts as $post)
                        <a href="{{ $post->permalink }}" target="_blank" class="block bg-gray-50 rounded-xl hover:bg-gray-100 transition duration-150 p-4 border border-gray-200 group">
                            <div class="flex items-start space-x-4">
                                @if($post->thumbnail && filter_var($post->thumbnail, FILTER_VALIDATE_URL))
                                    <img src="{{ html_entity_decode($post->thumbnail) }}" alt="Thumbnail" class="w-16 h-16 rounded-md object-cover flex-shrink-0 shadow-sm border border-gray-200">
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

                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
