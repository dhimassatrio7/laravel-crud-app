<div class="p-6">
    <button wire:click="create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Payment Proof</button>

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
                    <th class="py-2 px-4 border">Proof</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentProofs as $proof)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border text-center">{{ $proof->transaction->id }}</td>
                    <td class="py-2 px-4 border text-center">
                        <img src="{{ Storage::url($proof->proof_url) }}" alt="Payment Proof" class="mt-2 w-20 h-20 object-cover mx-auto">
                    </td>
                    <td class="py-2 px-4 border text-center">
                        <button wire:click="edit({{ $proof->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                        <button wire:click="delete({{ $proof->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <x-dialog-modal wire:model="isOpen">
        <x-slot name="title">
            {{ $paymentProofId ? 'Edit Payment Proof' : 'Add Payment Proof' }}
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
                    <label class="block text-gray-700">Proof File</label>
                    <input type="file" wire:model="proof_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('proof_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ $paymentProofId ? 'Update' : 'Create' }}
            </button>
            <button wire:click="closeModal" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
        </x-slot>
    </x-dialog-modal>
</div>
