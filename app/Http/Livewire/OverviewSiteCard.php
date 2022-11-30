<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use LaracraftTech\LaravelDynamicModel\DynamicModel;

class OverviewSiteCard extends Component
{
    public $device_id;
    public $parameter_slug;
    public $single_value;
    public $created_at;
    public function update()
    {
        $parameters_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $this->device_id . '_log']);
        $this->single_value = $parameters_log->latest()->first() ? $parameters_log->latest()->first()->{$this->parameter_slug} : 'NULL';
        $this->created_at = $parameters_log->latest()->first() ? $parameters_log->latest()->first()->{'created_at'} : 'NULL';
    }
    public function render()
    {
        return view('livewire.overview-site-card');
    }
}
