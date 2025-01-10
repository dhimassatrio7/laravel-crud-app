<div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8"">
    <!-- Add Transaction Button -->
    <button wire:click=" create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Transaction</button>

    <!-- Success Message -->
    @if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
        {{ session('message') }}
    </div>
    @endif

    <!-- Transaction Table -->
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full bg-white border-collapse border border-gray-300">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border">User</th>
                    <th class="py-2 px-4 border">Total Amount</th>
                    <th class="py-2 px-4 border">Status</th>
                    <th class="py-2 px-4 border">Items</th>
                    <th class="py-2 px-4 border">Payment Proof</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border text-center">{{ $transaction->user->name }}</td>
                    <td class="py-2 px-4 border text-center">Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border text-center">
                        <span class="px-2 py-1 rounded-full text-white 
                        {{ $transaction->status === 'pending' ? 'bg-yellow-500' : ($transaction->status === 'completed' ? 'bg-green-500' : 'bg-red-500') }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border text-center">
                        @foreach($transaction->items as $item)
                        <div>{{ $item->product->name }} ({{ $item->quantity }})</div>
                        @endforeach
                    </td>
                    <td class="py-2 px-4 border text-center">
                        @if($transaction->paymentProof)
                        <img src="{{ Storage::url($transaction->paymentProof->proof_url) }}" alt="Payment Proof" class="mt-2 w-20 h-20 object-cover mx-auto">
                        @else
                        <span class="text-gray-500">No Proof</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border text-center">
                        <button wire:click="edit({{ $transaction->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                        <button wire:click="delete({{ $transaction->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-2 px-4 border text-center text-gray-500">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <x-dialog-modal wire:model="isOpen">
        <x-slot name="title">
            {{ $transactionId ? 'Edit Transaction' : 'Add Transaction' }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <!-- User Selection -->
                <div>
                    <label class="block text-gray-700">User</label>
                    <select wire:model="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Select User</option>
                        @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Total Amount -->
                <div>
                    <label class="block text-gray-700">Total Amount</label>
                    <input type="number" wire:model="total_amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('total_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Status Selection -->
                <div>
                    <label class="block text-gray-700">Status</label>
                    <select wire:model="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="canceled">Canceled</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ $transactionId ? 'Update' : 'Create' }}
            </button>
            <button wire:click="closeModal" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
        </x-slot>
    </x-dialog-modal>
</div>
