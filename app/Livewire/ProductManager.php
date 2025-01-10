<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // Tambahkan ini
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductManager extends Component
{
    use WithFileUploads; // Tambahkan ini

    public $products, $name, $description, $price, $stock, $productId, $image; // Tambahkan $image
    public $isOpen = 0;

    public function render()
    {
        $this->products = Product::all();
        return view('livewire.product-manager');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->image = $product->image; // Ambil gambar
        $this->isOpen = true;
    }

    public function delete($id)
    {
        $product = Product::find($id);
        // Hapus gambar dari storage jika ada
        if ($product->image) {
            Storage::delete($product->image);
        }
        $product->delete();
        session()->flash('message', 'Product Deleted Successfully.');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi gambar
        ]);

        // Jika ada gambar yang diupload
        if ($this->image) {
            $imagePath = $this->image->store('product_images', 'public'); // Simpan gambar
        }

        Product::updateOrCreate(['id' => $this->productId], [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $this->image ? $imagePath : null, // Simpan path gambar
        ]);

        session()->flash('message', $this->productId ? 'Product Updated Successfully.' : 'Product Created Successfully.');
        $this->closeModal();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->stock = '';
        $this->productId = '';
        $this->image = null; // Reset gambar
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }
}
