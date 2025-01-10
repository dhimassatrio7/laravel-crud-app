<div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8"">
    <button wire:click=" create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Product</button>

    @if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
        {{ session('message') }}
    </div>
    @endif

    <div class="overflow-x-auto mt-4">
        <table class="min-w-full bg-white border-collapse">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border">Name</th>
                    <th class="py-2 px-4 border">Description</th>
                    <th class="py-2 px-4 border">Price</th>
                    <th class="py-2 px-4 border">Stock</th>
                    <th class="py-2 px-4 border">Image</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border text-center">{{ $product->name }}</td>
                    <td class="py-2 px-4 border text-center">{{ $product->description }}</td>
                    <td class="py-2 px-4 border text-center">{{ $product->price }}</td>
                    <td class="py-2 px-4 border text-center">{{ $product->stock }}</td>
                    <td class="py-2 px-4 border text-center">
                        @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="Product Image" class="w-12 h-12 object-cover">
                        @endif
                    </td>
                    <td class="py-2 px-4 border text-center">
                        <button wire:click="edit({{ $product->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                        <button wire:click="delete({{ $product->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-dialog-modal wire:model="isOpen">
        <x-slot name="title">
            {{ $productId ? 'Edit Product' : 'Create Product' }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700">Name</label>
                    <input type="text" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Description</label>
                    <textarea wire:model="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Price</label>
                    <input type="number" wire:model="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Stock</label>
                    <input type="number" wire:model="stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Image</label>
                    <input type="file" wire:model="image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ $productId ? 'Update' : 'Create' }}</button>
            <button wire:click="closeModal" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
        </x-slot>
    </x-dialog-modal>
</div>
