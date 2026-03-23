<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    {{ __('Social Hub') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1 font-medium">Manage and track your social engagements</p>
            </div>
            <div class="flex items-center gap-3">
                <x-ui.button :href="route('social-posts.create')" tag="a" class="bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-100 px-6">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Create Post
                    </span>
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search & Filter Bar -->
            <div class="mb-8 p-4 bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-gray-100">
                <form action="{{ route('social-posts.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, author, or subreddit..." 
                            class="block w-full pl-10 pr-3 py-2.5 bg-white/50 border border-gray-100 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    </div>
                    
                    <div class="w-full md:w-64">
                        <select name="category_id" onchange="this.form.submit()" 
                            class="block w-full px-3 py-2.5 bg-white/50 border border-gray-100 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if(request()->anyFilled(['search', 'category_id']))
                        <a href="{{ route('social-posts.index') }}" class="px-4 py-2.5 text-sm font-bold text-gray-500 hover:text-indigo-600 transition flex items-center justify-center">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            @if(session('success'))
                <x-ui.alert type="success" :message="session('success')" class="mb-8" />
            @endif

            <!-- Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <div class="group bg-white rounded-3xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                        <!-- Post Image/Thumbnail -->
                        <div class="relative h-48 bg-slate-100 overflow-hidden">
                            @if($post->thumbnail && $post->thumbnail != 'self' && $post->thumbnail != 'default')
                                <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50">
                                    <svg class="w-16 h-16 text-indigo-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            
                            <!-- Category Badge -->
                            @if($post->category)
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-white/90 backdrop-blur shadow-sm rounded-full text-[10px] font-black text-indigo-600 uppercase tracking-widest border border-indigo-50">
                                        {{ $post->category->name }}
                                    </span>
                                </div>
                            @endif

                            <!-- Overlay Actions -->
                            <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('social-posts.edit', $post) }}" class="p-2 bg-white/90 backdrop-blur rounded-xl text-gray-600 hover:text-indigo-600 shadow-sm transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('social-posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-white/90 backdrop-blur rounded-xl text-gray-600 hover:text-red-600 shadow-sm transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">r/{{ $post->subreddit }}</span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ format_date($post->created_utc) }}</span>
                            </div>
                            
                            <h3 class="text-sm font-bold text-gray-900 leading-snug mb-4 min-h-[40px] line-clamp-2 hover:text-indigo-600 transition">
                                <a href="{{ route('social-posts.show', $post) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                <span class="text-xs font-medium text-gray-500">by <span class="text-gray-900 font-bold">u/{{ $post->author }}</span></span>
                                
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-1 text-red-500">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" /></svg>
                                        <span class="text-xs font-black">{{ format_number($post->score) }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-blue-500">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" /></svg>
                                        <span class="text-xs font-black">{{ format_number($post->num_comments) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 bg-white rounded-3xl border border-dashed border-gray-200 flex flex-col items-center justify-center text-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">No social posts found</h3>
                        <p class="text-gray-500 max-w-xs mx-auto mt-2">We couldn't find any posts matching your criteria. Try adjusting your search or create a new custom post.</p>
                        <x-ui.button :href="route('social-posts.create')" tag="a" class="mt-8">
                            Create First Post
                        </x-ui.button>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
