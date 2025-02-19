<?php

namespace App\Livewire;

use App\Models\History;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Produce;
use App\Models\MachineProduce;
use App\Models\Product;
use App\Models\Machine;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseMaterial;

class ProduceComponent extends Component
{
    use WithPagination;

    public $produce_id, $product_id, $count;
    public $machines = [];
    public $isOpen = false, $viewModalOpen = false;
    public $viewProduce, $viewMachines = [];
    public $maxCount = 0;
    public $maxCounts = [];

    public function render()
    {
        return view('manufacturer.produces.produce-component', [
            'produces' => Produce::with('product')->paginate(10),
            'products' => Product::all(),
            'allMachines' => Machine::where('status', 1)->get(),
            'users' => User::where('role_id', 4)->get(),
        ]);
    }

    public function updatedProductId()
    {
        $product = Product::findOrFail($this->product_id);

        $availableCounts = [];

        foreach ($product->product_materials as $ingredient) {
            $material = WarehouseMaterial::where('warehouse_id', 1)
                ->where('product_id', $ingredient->material_id)
                ->first();

            if (!$material || $material->value == 0) {
                $availableCounts[] = 0;
            } else {
                $availableCounts[] = $material->value / $ingredient->value;
            }
        }

        $this->maxCount = !empty($availableCounts) ? min($availableCounts) : 0;
    }

    public function openModal()
    {
        $this->resetFields();
        $this->addMachine();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function addMachine()
    {
        $this->machines[] = ['machine_id' => '', 'user_id' => ''];
    }

    public function removeMachine($index)
    {
        unset($this->machines[$index]);
        $this->machines = array_values($this->machines);
    }

    public function store()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'count' => 'required|integer|min:1|max:' . $this->maxCount,
            'machines' => 'required|array|min:1',
            'machines.*.machine_id' => 'required|exists:machines,id',
            'machines.*.user_id' => 'required|exists:users,id',
        ]);

        $produce = Produce::create([
            'product_id' => $this->product_id,
            'count' => $this->count,
        ]);

        foreach ($this->machines as $machineData) {
            MachineProduce::create([
                'produce_id' => $produce->id,
                'count' => $this->count,
                'machine_id' => $machineData['machine_id'],
                'user_id' => $machineData['user_id'],
            ]);
        }

        foreach ($produce->product->product_materials as $ingredient) {
            $warehouseMaterial = WarehouseMaterial::where('warehouse_id', 1)
                ->where('product_id', $ingredient->material_id)
                ->first();

            if ($warehouseMaterial) {
                $wasValue = $warehouseMaterial->value;
                $beenValue = $wasValue - ($ingredient->value * $this->count);

                $warehouseMaterial->update(['value' => $beenValue]);

                History::create([
                    'type' => 3,
                    'material_id' => $ingredient->material_id,
                    'quantity' => $ingredient->value * $this->count,
                    'was' => $wasValue,
                    'been' => $beenValue,
                    'from_id' => 1,
                    'to_id' => $produce->id,
                ]);
            }
        }

        

        session()->flash('message', 'Created Successfully!');
        $this->closeModal();
    }

    public function viewProduct($id)
    {
        $this->viewProduce = Produce::with('product')->findOrFail($id);
        $this->viewMachines = MachineProduce::where('produce_id', $id)->with('machine', 'user')->get();
        $this->viewModalOpen = true;
    }

    public function closeViewModal()
    {
        $this->viewModalOpen = false;
    }

    private function resetFields()
    {
        $this->produce_id = null;
        $this->product_id = null;
        $this->count = null;
        $this->machines = [];
    }
}
