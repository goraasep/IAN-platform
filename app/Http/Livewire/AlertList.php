<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sites;

class AlertList extends Component
{
    public $site;
    public $sites;
    public $dashboard;
    public function update()
    {
        if ($this->dashboard) {
            $this->sites = Sites::all();
        } else {
            $this->site = Sites::where('id', $this->site->id)->get()->first();
        }
    }

    public function render()
    {
        if ($this->dashboard) {
            $this->sites = Sites::all();
        }
        return view('livewire.alert-list');
    }
}
