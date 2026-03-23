<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('API Control Panel') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen" x-data="categoryApiManager()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- API Info Card -->
            <x-ui.card>
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-indigo-600 rounded-2xl text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Live API Interaction</h3>
                        <p class="text-sm text-gray-500 font-medium">This panel uses the REST API for real-time category management without page refreshes.</p>
                    </div>
                </div>
            </x-ui.card>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Create Category Form -->
                <div class="lg:col-span-1">
                    <x-ui.card title="Add New Category">
                        <form @submit.prevent="createCategory" class="space-y-4">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-1">Name</label>
                                <input type="text" x-model="newCategory.name" required
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition shadow-inner">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-1">Description</label>
                                <textarea x-model="newCategory.description" rows="3"
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition shadow-inner"></textarea>
                            </div>
                            <x-ui.button type="submit" class="w-full" size="lg">
                                <span x-show="!loading">Publish via API</span>
                                <span x-show="loading">Processing...</span>
                            </x-ui.button>
                        </form>
                    </x-ui.card>
                </div>

                <!-- Categories List -->
                <div class="lg:col-span-2">
                    <x-ui.card title="Active API Resources">
                        <div class="space-y-4">
                            <template x-for="category in categories" :key="category.id">
                                <div class="group flex items-center justify-between p-5 bg-white border border-gray-100 rounded-2xl hover:shadow-xl hover:border-indigo-100 transition-all duration-300">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-black">
                                            <span x-text="category.name.substring(0, 1).toUpperCase()"></span>
                                        </div>
                                        <div>
                                            <h4 class="font-black text-gray-900" x-text="category.name"></h4>
                                            <p class="text-xs text-gray-400 font-medium" x-text="category.description || 'No description provided'"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-1 bg-gray-50 text-[10px] font-black text-gray-400 rounded-lg uppercase tracking-widest" x-text="category.posts_count + ' posts'"></span>
                                        <button @click="deleteCategory(category.id)" class="p-2 text-gray-400 hover:text-red-600 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <div x-show="categories.length === 0" class="text-center py-12 text-gray-400 font-medium italic">
                                No API resources found. Create one to begin!
                            </div>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </div>
    </div>

    <script>
        function categoryApiManager() {
            return {
                categories: [],
                newCategory: { name: '', description: '' },
                loading: false,
                
                async init() {
                    await this.fetchCategories();
                },

                async fetchCategories() {
                    const response = await fetch('/api/categories');
                    const result = await response.json();
                    this.categories = result.data;
                },

                async createCategory() {
                    this.loading = true;
                    try {
                        const response = await fetch('/api/categories', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.newCategory)
                        });
                        
                        if (response.ok) {
                            this.newCategory = { name: '', description: '' };
                            await this.fetchCategories();
                        } else {
                            const error = await response.json();
                            alert(error.message || 'API Error');
                        }
                    } catch (e) {
                        alert('Network Error');
                    }
                    this.loading = false;
                },

                async deleteCategory(id) {
                    if (!confirm('Permanently delete this resource via API?')) return;
                    
                    try {
                        const response = await fetch(`/api/categories/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        
                        if (response.ok) {
                            await this.fetchCategories();
                        }
                    } catch (e) {
                        alert('Delete Error');
                    }
                }
            }
        }
    </script>
</x-app-layout>
