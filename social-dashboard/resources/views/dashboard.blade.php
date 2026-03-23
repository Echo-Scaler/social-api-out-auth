<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Social Analytics Dashboard') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm font-medium text-gray-500 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span>Live Monitoring: r/{{ $current_subreddit }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <x-ui.card>
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Real-time Feed</h1>
                        <p class="text-gray-500 font-medium mt-1">Aggregating the latest engagement metrics from Reddit.</p>
                    </div>
                    
                    <form action="{{ route('dashboard') }}" method="GET" class="w-full md:w-auto">
                        <div class="flex gap-2">
                            <div class="relative flex-grow">
                                <span class="absolute inset-y-0 left-4 flex items-center text-gray-400 font-bold">r/</span>
                                <input type="text" name="subreddit" value="{{ $current_subreddit }}" 
                                    class="block w-full pl-9 pr-4 py-2.5 bg-gray-50 border-none rounded-xl text-gray-900 font-bold shadow-inner focus:ring-2 focus:ring-indigo-500 transition outline-none" 
                                    placeholder="webdev">
                            </div>
                            <x-ui.button type="submit" size="md">Fetch</x-ui.button>
                        </div>
                    </form>
                </div>
            </x-ui.card>

            <!-- Metrics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <x-ui.card class="border-b-4 border-b-blue-500">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-widest">Total Likes</div>
                    <div class="mt-2 text-4xl font-black text-gray-900">{{ format_number($metrics['total_likes']) }}</div>
                    <div class="mt-1 text-xs text-blue-500 font-bold">+12% from last fetch</div>
                </x-ui.card>

                <x-ui.card class="border-b-4 border-b-purple-500">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-widest">Comments</div>
                    <div class="mt-2 text-4xl font-black text-gray-900">{{ format_number($metrics['total_comments']) }}</div>
                    <div class="mt-1 text-xs text-purple-500 font-bold">High engagement</div>
                </x-ui.card>

                <x-ui.card class="border-b-4 border-b-emerald-500">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-widest">Avg Engagement</div>
                    <div class="mt-2 text-4xl font-black text-gray-900">{{ $metrics['avg_engagement'] }}</div>
                    <div class="mt-1 text-xs text-emerald-500 font-bold">Trending up</div>
                </x-ui.card>

                <x-ui.card class="border-b-4 border-b-amber-500">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-widest">Posts Tracked</div>
                    <div class="mt-2 text-4xl font-black text-gray-900">{{ $metrics['total_posts'] }}</div>
                    <div class="mt-1 text-xs text-amber-500 font-bold">Last 24 hours</div>
                </x-ui.card>
            </div>

            <!-- Posts List -->
            <x-ui.card title="Top Performing Posts">
                <div class="space-y-4">
                    @forelse($posts as $post)
                        <div class="group relative bg-white border border-gray-100 rounded-2xl p-5 hover:shadow-lg hover:border-indigo-100 transition-all duration-300">
                            <div class="flex items-start gap-5">
                                @if($post->thumbnail && filter_var($post->thumbnail, FILTER_VALIDATE_URL))
                                    <div class="relative flex-shrink-0">
                                        <img src="{{ html_entity_decode($post->thumbnail) }}" alt="Thumbnail" class="w-20 h-20 rounded-xl object-cover shadow-sm group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute -top-2 -right-2 bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-lg">New</div>
                                    </div>
                                @endif
                                <div class="flex-grow">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-[10px] font-black uppercase tracking-tighter text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded-md">
                                            {{ $post->subreddit }}
                                        </span>
                                        <span class="text-xs text-gray-400 font-medium">{{ format_date($post->created_at) }}</span>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition leading-snug">
                                        <a href="{{ $post->permalink }}" target="_blank" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            {{ $post->title }}
                                        </a>
                                    </h4>
                                    <div class="flex items-center gap-6 mt-4">
                                        <div class="flex items-center gap-1.5">
                                            <div class="p-1 px-2 rounded-lg bg-red-50 text-red-600">
                                                <span class="text-xs font-black">&uarr; {{ format_number($post->score) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <div class="p-1 px-2 rounded-lg bg-blue-50 text-blue-600">
                                                <span class="text-xs font-black">💬 {{ format_number($post->num_comments) }}</span>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-400 font-medium ml-auto">
                                            Posted by <span class="text-gray-700 font-bold">u/{{ $post->author }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-500 font-medium">
                            No posts found for this subreddit.
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            </x-ui.card>
            
        </div>
    </div>
</x-app-layout>
