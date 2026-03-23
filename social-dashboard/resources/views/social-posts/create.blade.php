<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Create Custom Social Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-ui.card title="Post Details">
                <form method="POST" action="{{ route('social-posts.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label for="category_id" class="block text-sm font-semibold text-gray-700">Category (Optional)</label>
                            <select name="category_id" id="category_id" class="block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-900 shadow-sm transition-all focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none sm:text-sm">
                                <option value="">None</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-ui.input label="Subreddit Name" name="subreddit" required placeholder="e.g. webdev" value="custom" />
                    </div>

                    <x-ui.input label="Post Title" name="title" required placeholder="What's on your mind?" />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-ui.input label="Author" name="author" required value="{{ auth()->user()->name }}" />
                        <x-ui.input label="External URL (Optional)" name="url" type="url" placeholder="https://example.com" />
                    </div>

                    {{-- Hidden fields for custom posts --}}
                    <input type="hidden" name="post_id" value="custom_{{ uniqid() }}">
                    <input type="hidden" name="permalink" value="/custom/{{ uniqid() }}">
                    <input type="hidden" name="created_utc" value="{{ now() }}">
                    <input type="hidden" name="score" value="0">
                    <input type="hidden" name="num_comments" value="0">

                    <div class="flex items-center justify-end pt-4 space-x-4">
                        <a href="{{ route('social-posts.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 underline transition">Cancel</a>
                        <x-ui.button type="submit">Publish Post</x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
