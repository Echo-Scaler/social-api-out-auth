<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Social Media Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-ui.card title="Manage Categories">
                <x-slot name="footer">
                    <div class="flex justify-end">
                        <a href="{{ route('categories.create') }}">
                            <x-ui.button>+ Create New Category</x-ui.button>
                        </a>
                    </div>
                </x-slot>

                @if(session('success'))
                    <x-ui.alert type="success" :message="session('success')" class="mb-6" />
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="px-4 py-3">Category Name</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Posts Count</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-4 font-bold text-gray-900 border-l-4 border-indigo-500 rounded-r-lg">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        {{ Str::limit($category->description, 60) }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $category->social_posts_count }} posts
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-right space-x-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">Edit</a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Deleting this category will unlink all its posts. Proceed?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-10 text-center text-gray-500">
                                        No categories found. Start by creating one!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $categories->links() }}
                </div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
