<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Edit Social Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-ui.card title="Update Details">
                <form method="POST" action="{{ route('social-posts.update', $socialPost) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label for="category_id" class="block text-sm font-semibold text-gray-700">Category</label>
                            <select name="category_id" id="category_id" class="block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-900 shadow-sm transition-all focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none sm:text-sm">
                                <option value="">None</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $socialPost->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-ui.input label="Subreddit Name" name="subreddit" required :value="$socialPost->subreddit" />
                    </div>

                    <x-ui.input label="Post Title" name="title" required :value="$socialPost->title" />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-ui.input label="Author" name="author" required :value="$socialPost->author" />
                        <x-ui.input label="Score" name="score" type="number" required :value="$socialPost->score" />
                    </div>

                    <div class="flex items-center justify-end pt-4 space-x-4">
                        <a href="{{ route('social-posts.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 underline transition">Cancel</a>
                        <x-ui.button type="submit">Update Post</x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
