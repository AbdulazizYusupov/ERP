<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductMaterial;
use App\Models\Material;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ProductComponent extends Component
{
    use WithFileUploads;

    public $products, $name, $image, $materials = [], $product_id, $price;
    public $modalOpen = false, $editModalOpen = false, $viewModalOpen = false;
    public $viewMaterials = [];

    public function mount()
    {
        $this->loadProducts();
    }

    private function loadProducts()
    {
        $this->products = Product::with('product_materials.material')->get();
    }

    public function openModal()
    {
        $this->resetFields();
        $this->addMaterial();
        $this->modalOpen = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
    }

    public function openEditModal($id)
    {
        $product = Product::with('product_materials')->findOrFail($id);
        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->materials = $product->product_materials->map(function ($mat) {
            return ['material_id' => $mat->material_id, 'value' => $mat->value, 'unit' => $mat->unit];
        })->toArray();

        $this->editModalOpen = true;
    }

    public function closeEditModal()
    {
        $this->editModalOpen = false;
    }

    private function resetFields()
    {
        $this->product_id = null;
        $this->name = '';
        $this->image = null;
        $this->materials = [];
    }

    public function addMaterial()
    {
        $this->materials[] = ['material_id' => '', 'value' => '', 'unit' => ''];
    }

    public function removeMaterial($index)
    {
        unset($this->materials[$index]);
        $this->materials = array_values($this->materials);
    }

    public function saveProduct()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:1',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.value' => 'required|numeric|min:0.1',
        ]);

        $imagePath = $this->image ? $this->image->store('products', 'public') : null;

        $product = Product::create([
            'name' => $this->name,
            'image' => $imagePath,
            'price' => $this->price,
            'slug' => Str::slug($this->name),
        ]);

        foreach ($this->materials as $mat) {
            $material = Material::find($mat['material_id']);
            $unit = $material->entry_materials->first()->unit ?? '';

            ProductMaterial::create([
                'product_id' => $product->id,
                'material_id' => $mat['material_id'],
                'value' => $mat['value'],
                'unit' => $unit,
                'warehouse_id' => 1
            ]);
        }

        $this->loadProducts();
        $this->closeModal();
    }

    public function updateProduct()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.value' => 'required|numeric|min:0.1',
        ]);

        $product = Product::findOrFail($this->product_id);
        $product->update(['name' => $this->name, 'price' => $this->price]);

        ProductMaterial::where('product_id', $product->id)->delete();

        foreach ($this->materials as $mat) {
            $material = Material::find($mat['material_id']);
            $unit = $material->entry_materials->first()->unit ?? '';

            ProductMaterial::create([
                'product_id' => $product->id,
                'material_id' => $mat['material_id'],
                'value' => $mat['value'],
                'unit' => $unit,
            ]);
        }

        $this->loadProducts();
        $this->closeEditModal();
    }

    public function viewProduct($id)
    {
        $product = Product::with('product_materials.material')->findOrFail($id);
        $this->viewMaterials = $product->product_materials->map(function ($mat) {
            return [
                'name' => $mat->material->name,
                'value' => $mat->value,
                'unit' => $mat->unit
            ];
        })->toArray();

        $this->viewModalOpen = true;
    }

    public function closeViewModal()
    {
        $this->viewModalOpen = false;
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        $this->loadProducts();
    }

    public function render()
    {
        return view('manufacturer.products.product-component', ['materialsList' => Material::all()]);
    }
}
