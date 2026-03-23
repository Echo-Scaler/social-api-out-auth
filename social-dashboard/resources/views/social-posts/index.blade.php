<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Post Management') }}
            </h2>
            <x-ui.button :href="route('social-posts.create')" tag="a">
                <a href="{{ route('social-posts.create') }}">+ New Custom Post</a>
            </x-ui.button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-ui.card title="All Social Posts">
                @if(session('success'))
                    <x-ui.alert type="success" :message="session('success')" class="mb-6" />
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="px-4 py-3">Category / Sub</th>
                                <th class="px-4 py-3">Content Detail</th>
                                <th class="px-4 py-3">Engagement</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($posts as $post)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-4">
                                        @if($post->category)
                                            <span class="block text-xs font-black text-indigo-500 uppercase tracking-tighter mb-1">{{ $post->category->name }}</span>
                                        @endif
                                        <span class="text-sm font-bold text-gray-900 border-l-2 border-indigo-200 pl-2">r/{{ $post->subreddit }}</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-bold text-gray-900 leading-tight">{{ Str::limit($post->title, 60) }}</div>
                                        <div class="text-xs text-gray-400 mt-1">u/{{ $post->author }} &bull; {{ format_date($post->created_utc) }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="text-xs font-black text-red-600 bg-red-50 px-2 py-1 rounded-md">&uarr; {{ format_number($post->score) }}</span>
                                        <span class="text-xs font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-md ml-1">💬 {{ format_number($post->num_comments) }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-right space-x-3">
                                        <a href="{{ route('social-posts.edit', $post) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">Edit</a>
                                        <form action="{{ route('social-posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Permanently delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-12 text-center text-gray-500 font-medium font-bold">
                                        No posts available. Fetch from dashboard or create one!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
