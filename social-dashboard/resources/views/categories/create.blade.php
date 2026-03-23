<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-ui.card title="Category Details">
                <form method="POST" action="{{ route('categories.store') }}" class="space-y-6">
                    @csrf

                    <x-ui.input label="Category Name" name="name" required placeholder="e.g. Technology, Politics, Sports" />

                    <div class="space-y-1.5">
                        <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" 
                            class="block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-900 shadow-sm transition-all focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none sm:text-sm placeholder-gray-400"
                            placeholder="Briefly describe what this category covers...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end pt-4 space-x-4">
                        <a href="{{ route('categories.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 underline transition">Cancel</a>
                        <x-ui.button type="submit">Create Category</x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
