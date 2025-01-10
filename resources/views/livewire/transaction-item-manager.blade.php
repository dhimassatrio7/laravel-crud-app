<div class="p-6">
    <button wire:click="create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Transaction Item</button>

    @if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
        {{ session('message') }}
    </div>
    @endif

    <div class="overflow-x-auto mt-4">
        <table class="min-w-full bg-white border-collapse border border-gray-300">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border">Transaction</th>
                    <th class="py-2 px-4 border">Product</th>
                    <th class="py-2 px-4 border">Quantity</th>
                    <th class="py-2 px-4 border">Subtotal</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactionItems as $item)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border text-center">{{ $item->transaction->id }}</td>
                    <td class="py-2 px-4 border text-center">{{ $item->product->name }}</td>
                    <td class="py-2 px-4 border text-center">{{ $item->quantity }}</td>
                    <td class="py-2 px-4 border text-center">{{ $item->subtotal }}</td>
                    <td class="py-2 px-4 border text-center">
                        <button wire:click="edit({{ $item->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                        <button wire:click="delete({{ $item->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <x-dialog-modal wire:model="isOpen">
        <x-slot name="title">
            {{ $transactionItemId ? 'Edit Transaction Item' : 'Add Transaction Item' }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700">Transaction</label>
                    <select wire:model="transaction_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Select Transaction</option>
                        @foreach(\App\Models\Transaction::all() as $transaction)
                        <option value="{{ $transaction->id }}">{{ $transaction->id }}</option>
                        @endforeach
                    </select>
                    @error('transaction_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Product</label>
                    <select wire:model="product_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Select Product</option>
                        @foreach(\App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Quantity</label>
                    <input type="number" wire:model="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Subtotal</label>
                    <input type="number" step="0.01" wire:model="subtotal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('subtotal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ $transactionItemId ? 'Update' : 'Create' }}
            </button>
            <button wire:click="closeModal" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
        </x-slot>
    </x-dialog-modal>
</div>
