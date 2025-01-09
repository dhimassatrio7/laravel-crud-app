<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="flex justify-between mb-4">
        <h2 class="text-lg font-semibold">Manage Posts</h2>
        <button wire:click="create" class="bg-blue-500 text-white px-4 py-2 rounded">Add Post</button>
    </div>

    @if (session()->has('message'))
    <div class="bg-green-500 text-white p-2 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif

    <table class="w-full border-collapse">
        <thead class="bg-gray-200">
            <tr class="text-left">
                <th class="border border-gray-200 px-4 py-2">ID</th>
                <th class="border border-gray-200 px-4 py-2">Title</th>
                <th class="border border-gray-200 px-4 py-2">Content</th>
                <th class="border border-gray-200 px-4 py-2">User</th>
                <th class="border border-gray-200 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td class="border border-gray-200 px-4 py-2">{{ $post->id }}</td>
                <td class="border border-gray-200 px-4 py-2">{{ $post->title }}</td>
                <td class="border border-gray-200 px-4 py-2">{{ $post->content }}</td>
                <td class="border border-gray-200 px-4 py-2">{{ $post->user->name }}</td>
                <td class="border border-gray-200 px-4 py-2">
                    <button wire:click="edit({{ $post->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                    <button wire:click="delete({{ $post->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($isOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-lg">
            <h3 class="text-lg font-semibold mb-4">{{ $post_id ? 'Edit Post' : 'Add Post' }}</h3>
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Post Title</label>
                    <input type="text" wire:model="title" class="border border-gray-300 rounded w-full p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Post Content</label>
                    <textarea wire:model="content" class="border border-gray-300 rounded w-full p-2" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" wire:click="closeModal" class="bg-gray-300 text-black px-4 py-2 rounded mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ $post_id ? 'Update' : 'Create' }}</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
