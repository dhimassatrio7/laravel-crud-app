<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // Tambahkan ini
use App\Models\PaymentProof;
use App\Models\Transaction; // Jika Anda ingin menampilkan transaksi
use Illuminate\Support\Facades\Storage;

class PaymentProofManager extends Component
{
    use WithFileUploads; // Tambahkan ini

    public $paymentProofs, $transaction_id, $proof_url, $paymentProofId;
    public $isOpen = false;

    public function render()
    {
        $this->paymentProofs = PaymentProof::with('transaction')->get(); // Mengambil semua bukti pembayaran dengan relasi transaksi
        return view('livewire.payment-proof-manager');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $paymentProof = PaymentProof::findOrFail($id);
        $this->paymentProofId = $id;
        $this->transaction_id = $paymentProof->transaction_id;
        $this->proof_url = $paymentProof->proof_url;
        $this->isOpen = true;
    }

    public function delete($id)
    {
        $paymentProof = PaymentProof::find($id);
        // Hapus file dari storage jika ada
        if ($paymentProof->proof_url) {
            Storage::delete($paymentProof->proof_url);
        }
        $paymentProof->delete();
        session()->flash('message', 'Payment Proof Deleted Successfully.');
    }

    public function save()
    {
        $this->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'proof_url' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Validasi file
        ]);

        // Upload file dan simpan URL
        $path = $this->proof_url->store('payment_proofs', 'public');

        PaymentProof::updateOrCreate(['id' => $this->paymentProofId], [
            'transaction_id' => $this->transaction_id,
            'proof_url' => $path,
        ]);

        session()->flash('message', $this->paymentProofId ? 'Payment Proof Updated Successfully.' : 'Payment Proof Created Successfully.');
        $this->closeModal();
    }

    private function resetInputFields()
    {
        $this->transaction_id = '';
        $this->proof_url = '';
        $this->paymentProofId = '';
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }
}
