<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Devices;
use Illuminate\Support\Facades\App;
use LaracraftTech\LaravelDynamicModel\DynamicModel;

class StringParameter extends Component
{
    public $device_id;
    public function mount($device_id)
    {
        $this->device_id = $device_id;
    }
    // public function getParameter()
    // {
    //     $parameters = App::make(DynamicModel::class, ['table_name' => 'device_' . $this->device_id . '_log']);
    // }
    public function render()
    {
        $data = [
            'parameters_log' => App::make(DynamicModel::class, ['table_name' => 'device_' . $this->device_id . '_log'])->latest()->first(),
            'parameters' => Devices::with('parameters')->where('id', $this->device_id)->first()->parameters->where('type', 'string')
        ];
        // dd($data);
        // $parameters = App::make(DynamicModel::class, ['table_name' => 'device_' . $this->device_id . '_log']);
        // $device=Devices::with('parameters')->where('id',$this->device_id);
        return view('livewire.string-parameter', $data);
    }
}
