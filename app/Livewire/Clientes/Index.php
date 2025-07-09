<?php

namespace App\Livewire\Clientes;

use App\Models\Cliente;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast;

    public string $search = '';

    public bool $drawer = false;

    #[Rule('required')]
    public string $nome_empresa = '';

    #[Rule('required')]
    public string $cnpj = '';

    #[Rule('required')]
    public string $telefone = '';

    public function submit()
    {
        $validated = $this->validate();

        Cliente::create($validated);

        $this->reset();

        $this->success("Cliente criado", position: 'toast-bottom');
    }

    public function headers(): array
    {
        return [
            ['key' => 'id_cliente', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'nome_empresa', 'label' => 'Nome da empresa', 'class' => 'w-64'],
            ['key' => 'cnpj', 'label' => 'CNPJ', 'sortable' => false],
            ['key' => 'telefone', 'label' => 'Telefone', 'class' => 'w-20'],
        ];
    }

    public function clients()
    {
        return Cliente::all();
    }

    public function render()
    {
        return view('livewire.clientes.index', [
            'headers' => $this->headers(),
            'clients' => $this->clients()
        ]);
    }
}
