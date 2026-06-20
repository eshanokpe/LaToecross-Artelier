<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class Footer extends Component
{
    public $email = '';
    public $showSuccess = false;
    public $errorMessage = null;

    protected $rules = [
        'email' => 'required|email|max:255',
    ];

    protected $messages = [
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.max' => 'Email address is too long.',
    ];

    public function subscribe()
    {
        $this->validate();

        // TODO: Add newsletter subscription logic here
        // Example: Newsletter::subscribe($this->email);

        $this->showSuccess = true;
        $this->email = '';
        
        // Reset success message after 5 seconds
        $this->dispatch('reset-success', ['delay' => 5000]);
    }

    public function resetSuccess()
    {
        $this->showSuccess = false;
    }

    public function render()
    {
        return view('livewire.footer', [
            'categories' => Category::where('is_active', true)->take(6)->get(),
        ]);
    }
}