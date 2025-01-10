<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TransactionItem;
use App\Models\Product; // Jika Anda ingin menampilkan produk
use App\Models\Transaction; // Jika Anda ingin menampilkan transaksi

class TransactionItemManager extends Component
{
    public $transactionItems, $transaction_id, $product_id, $quantity, $subtotal, $transactionItemId;
    public $isOpen = false;

    public function render()
    {
        $this->transactionItems = TransactionItem::with(['transaction', 'product'])->get(); // Mengambil semua item transaksi dengan relasi
        return view('livewire.transaction-item-manager');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $transactionItem = TransactionItem::findOrFail($id);
        $this->transactionItemId = $id;
        $this->transaction_id = $transactionItem->transaction_id;
        $this->product_id = $transactionItem->product_id;
        $this->quantity = $transactionItem->quantity;
        $this->subtotal = $transactionItem->subtotal;
        $this->isOpen = true;
    }

    public function delete($id)
    {
        TransactionItem::find($id)->delete();
        session()->flash('message', 'Transaction Item Deleted Successfully.');
    }

    public function save()
    {
        $this->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'subtotal' => 'required|numeric',
        ]);

        TransactionItem::updateOrCreate(['id' => $this->transactionItemId], [
            'transaction_id' => $this->transaction_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'subtotal' => $this->subtotal,
        ]);

        session()->flash('message', $this->transactionItemId ? 'Transaction Item Updated Successfully.' : 'Transaction Item Created Successfully.');
        $this->closeModal();
    }

    private function resetInputFields()
    {
        $this->transaction_id = '';
        $this->product_id = '';
        $this->quantity = '';
        $this->subtotal = '';
        $this->transactionItemId = '';
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }
}
