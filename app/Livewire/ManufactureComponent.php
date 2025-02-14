<?php

namespace App\Livewire;

use App\Models\MachineProduce;
use App\Models\Produce;
use Livewire\Component;

class ManufactureComponent extends Component
{
    public $produces;
    public $processes;
    public $dones;
    public $defect = 0;
    public $allow1 = false;
    public $allow2 = false;
    public $allow3 = false;

    public function render()
    {
        $userId = auth()->user()->id;

        $this->produces = MachineProduce::where('status', 0)
            ->where('user_id', $userId)
            ->get();

        $this->processes = MachineProduce::where('status', 1)
            ->where('user_id', $userId)
            ->get();

        $this->dones = MachineProduce::where('status', 2)
            ->where('user_id', $userId)
            ->get();

        return view('manufacturer.manufacture-component');
    }

    public function moveToProcessing($id)
    {
        $machineProduce = MachineProduce::findOrFail($id);

        $produce = $machineProduce->produce;

        $machineProduce->status = 1;
        $machineProduce->save();

        $produce->status = 1;
        $produce->save();
    }

    public function show($id)
    {
        $this->allow1 = ($this->allow1 == $id) ? false : $id;
    }

    public function ruxsat($id)
    {
        $this->allow2 = ($this->allow2 == $id) ? false : $id;
    }

    // public function moveToDone($id)
    // {
    //     dd($id);
    //     $machineProduce = MachineProduce::findOrFail($id);

    //     $produce = $machineProduce->produce;

    //     if (!$machineProduce) {
    //         return;
    //     }

    //     $machineProduce->defect = $this->defect;
    //     $machineProduce->quality = max(0, $machineProduce->count - $this->defect);
    //     $machineProduce->status = 2;
    //     $machineProduce->save();

    //     $nextMachineProduce = MachineProduce::where('produce_id', $id)
    //         ->where('id', '>', $machineProduce->id)
    //         ->first();

    //     if ($nextMachineProduce) {
    //         $nextMachineProduce->count = $machineProduce->quality;
    //         $nextMachineProduce->status = 0;
    //         $nextMachineProduce->save();
    //     } else {
    //         $produce->status = 2;
    //         $produce->quality = $machineProduce->quality;
    //         $produce->defect = $machineProduce->defect;
    //         $produce->save();
    //     }

    //     $this->defect = 0;
    //     $this->allow3 = false;
    // }

    public function consent($id)
    {
        $this->allow3 = ($this->allow3 == $id) ? false : $id;
    }

    public function moveToNextMachine($id)
    {
        $userId = auth()->user()->id;

        $currentMachine = MachineProduce::where('id', $id)
            ->where('user_id', $userId)
            ->where('status', 1)
            ->orderBy('id')
            ->first();

        if (!$currentMachine) {
            return;
        }

        $currentMachine->defect = $this->defect;
        $currentMachine->quality = max(0, $currentMachine->count - $this->defect);
        $currentMachine->status = 2;
        $currentMachine->save();

        $nextMachine = MachineProduce::where('id', $id + 1)
            ->where('user_id', $userId)
            ->orderBy('id')
            ->first();

        if ($nextMachine) {
            $nextMachine->count = $currentMachine->quality;
            $nextMachine->status = 0;
            $nextMachine->save();
        } else {
            $produce = Produce::where('id', $currentMachine->produce_id)->first();
            $produce->status = 2;
            $produce->quality = $currentMachine->quality;
            $produce->defect = MachineProduce::where('produce_id', $produce->id)->sum('defect');
            $produce->save();
        }

        $this->defect = 0;
    }
}
