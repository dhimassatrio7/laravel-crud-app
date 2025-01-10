<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\User; // Jika Anda ingin menampilkan pengguna
use Illuminate\Support\Facades\Auth;

class TransactionManager extends Component
{
    public $transactions, $user_id, $total_amount, $status, $transactionId;
    public $isOpen = false;

    public function render()
    {
        $this->transactions = Transaction::with('user')->get(); // Mengambil semua transaksi dengan relasi pengguna
        return view('livewire.transaction-manager');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $this->transactionId = $id;
        $this->user_id = $transaction->user_id;
        $this->total_amount = $transaction->total_amount;
        $this->status = $transaction->status;
        $this->isOpen = true;
    }

    public function delete($id)
    {
        Transaction::find($id)->delete();
        session()->flash('message', 'Transaction Deleted Successfully.');
    }

    public function save()
    {
        $this->validate([
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric',
            'status' => 'required|in:pending,completed,canceled',
        ]);

        Transaction::updateOrCreate(['id' => $this->transactionId], [
            'user_id' => $this->user_id,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
        ]);

        session()->flash('message', $this->transactionId ? 'Transaction Updated Successfully.' : 'Transaction Created Successfully.');
        $this->closeModal();
    }

    private function resetInputFields()
    {
        $this->user_id = '';
        $this->total_amount = '';
        $this->status = '';
        $this->transactionId = '';
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }
}
