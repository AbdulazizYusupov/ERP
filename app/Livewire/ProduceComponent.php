<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Produce;
use App\Models\MachineProduce;
use App\Models\Product;
use App\Models\Machine;
use App\Models\User;

class ProduceComponent extends Component
{
    use WithPagination;

    public $produce_id, $product_id, $count;
    public $machines = [];
    public $isOpen = false, $viewModalOpen = false;
    public $viewProduce, $viewMachines = [];

    public function render()
    {
        return view('manufacturer.produces.produce-component', [
            'produces' => Produce::with('product')->paginate(10),
            'products' => Product::all(),
            'allMachines' => Machine::where('status', 1)->get(),
            'users' => User::all(),
        ]);
    }

    public function openModal()
    {
        $this->resetFields();
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
            'count' => 'required|integer|min:1',
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
