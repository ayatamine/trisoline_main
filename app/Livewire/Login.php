<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseAuth;
 
class Login extends BaseAuth
{
    protected static string $view = 'livewire.login';

}
