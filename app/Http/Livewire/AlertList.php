<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sites;

class AlertList extends Component
{
    public $site;

    public function update()
    {
        $this->site = Sites::with(['devices' => ['parameters']])->where('id', $this->site->id)->get()->first();
    }

    public function render()
    {
        return view('livewire.alert-list');
    }
}
