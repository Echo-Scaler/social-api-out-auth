<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Post Detail') }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('social-posts.index') }}" class="text-sm font-bold text-gray-500 hover:text-indigo-600 transition">
                    &larr; Back to Hub
                </a>
                <x-ui.button :href="route('social-posts.edit', $socialPost)" tag="a" class="bg-white border-gray-200 text-gray-700 hover:bg-gray-50">
                    Edit Post
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100/50 border border-gray-100 overflow-hidden">
                <!-- Post Hero Section -->
                <div class="relative h-80 bg-slate-900 overflow-hidden">
                    @if($socialPost->thumbnail && $socialPost->thumbnail != 'self' && $socialPost->thumbnail != 'default')
                        <img src="{{ $socialPost->thumbnail }}" alt="{{ $socialPost->title }}" class="w-full h-full object-cover opacity-60">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                    
                    <div class="absolute bottom-10 left-10 right-10">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-4 py-1.5 bg-indigo-600 text-white rounded-full text-[10px] font-black uppercase tracking-widest">
                                {{ $socialPost->category ? $socialPost->category->name : 'Uncategorized' }}
                            </span>
                            <span class="text-white/80 text-xs font-bold uppercase tracking-widest">r/{{ $socialPost->subreddit }}</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white leading-tight">
                            {{ $socialPost->title }}
                        </h1>
                    </div>
                </div>

                <!-- Post Content & Meta -->
                <div class="p-10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 mb-12">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-xl font-black shadow-lg shadow-indigo-200">
                                {{ strtoupper(substr($socialPost->author, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-0.5">Posted by</div>
                                <div class="text-lg font-black text-gray-900">u/{{ $socialPost->author }}</div>
                                <div class="text-gray-400 text-xs font-medium">{{ format_date($socialPost->created_utc) }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-black text-red-500">{{ format_number($socialPost->score) }}</div>
                                <div class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">Upvotes</div>
                            </div>
                            <div class="w-px h-10 bg-gray-100"></div>
                            <div class="text-center">
                                <div class="text-3xl font-black text-blue-500">{{ format_number($socialPost->num_comments) }}</div>
                                <div class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">Comments</div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions & External Links -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ $socialPost->url }}" target="_blank" class="flex items-center gap-4 p-6 bg-slate-50 rounded-3xl border border-gray-100 hover:border-indigo-200 hover:bg-white hover:shadow-xl transition-all group">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm border border-gray-100 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </div>
                            <div>
                                <div class="text-sm font-black text-gray-900">External Source</div>
                                <div class="text-xs text-gray-400 font-medium">View post on source platform</div>
                            </div>
                        </a>

                        <a href="https://reddit.com{{ $socialPost->permalink }}" target="_blank" class="flex items-center gap-4 p-6 bg-slate-50 rounded-3xl border border-gray-100 hover:border-orange-200 hover:bg-white hover:shadow-xl transition-all group">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-orange-600 shadow-sm border border-gray-100 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0zm5.01 4.744c.688 0 1.25.561 1.25 1.249a1.25 1.25 0 0 1-2.498.056l-2.597-.547-.8 3.747c1.824.07 3.48.632 4.674 1.488.308-.309.73-.491 1.207-.491.968 0 1.754.786 1.754 1.754 0 .716-.435 1.333-1.01 1.614a3.111 3.111 0 0 1 .042.52c0 2.694-3.13 4.87-7.004 4.87-3.874 0-7.004-2.176-7.004-4.87a3.522 3.522 0 0 1 .042-.519c-.582-.281-1.011-.904-1.011-1.62 0-.969.782-1.754 1.751-1.754.477 0 .891.191 1.201.491 1.202-.855 2.857-1.417 4.685-1.487l.955-4.477a.5.5 0 0 1 .445-.401h.001l2.502.527c.026-.232.226-.412.47-.412zM8.257 11.23a1.455 1.455 0 1 1 0 2.91 1.455 1.455 0 1 1 0-2.91zm7.485 0a1.455 1.455 0 1 1 0 2.91 1.455 1.455 0 1 1 0-2.91zm-6.236 4.316c.492.493 1.545.69 2.503.69s2.007-.197 2.495-.69a.5.5 0 1 1 .707.707c-.636.637-1.898.883-3.202.883s-2.564-.246-3.197-.883a.5.5 0 1 1 .71-.707z"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-black text-gray-900">Reddit Permalink</div>
                                <div class="text-xs text-gray-400 font-medium">View discussion on Reddit</div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Footer with deletion -->
                <div class="px-10 py-6 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-xs text-gray-400 font-medium">System ID: {{ $socialPost->post_id }}</div>
                    <form action="{{ route('social-posts.destroy', $socialPost) }}" method="POST" onsubmit="return confirm('Permanently delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-black text-red-600 hover:text-red-900 uppercase tracking-widest transition">
                            Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
