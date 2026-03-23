<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Social Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('social-posts.update', $socialPost) }}">
                    @csrf
                    @method('PUT')

                    <!-- Subreddit -->
                    <div class="mb-4">
                        <label for="subreddit" class="block font-medium text-sm text-gray-700">Subreddit Topic</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">r/</span>
                            <input id="subreddit" type="text" name="subreddit" value="{{ old('subreddit', $socialPost->subreddit) }}" required autofocus class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block font-medium text-sm text-gray-700">Post Title</label>
                        <input id="title" type="text" name="title" value="{{ old('title', $socialPost->title) }}" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-sm">
                    </div>

                    <!-- Upvotes / Score -->
                    <div class="mb-6">
                        <label for="score" class="block font-medium text-sm text-gray-700">Score / Upvotes</label>
                        <input id="score" type="number" name="score" value="{{ old('score', $socialPost->score) }}" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-sm">
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('social-posts.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4">Cancel</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            Update Post
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
