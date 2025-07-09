<?php

namespace App\Livewire\Clientes;

use App\Models\Cliente;
use GuzzleHttp\Client;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast;

    public ?int $id_cliente = null;

    public bool $is_editing = false;

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

        $cliente = null;

        if ($this->is_editing) {
            $cliente = Cliente::where('id_cliente', $this->id_cliente)->first();
            $cliente->update($validated);
        } else {
            $cliente = Cliente::create($validated);
        }

        $message = $this->is_editing == true ? "Cliente editado!" : "Cliente criado!";

        $this->reset();

        $this->success($message, position: 'toast-bottom');
    }

    public function headers(): array
    {
        return [
            ['key' => 'id_cliente', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'nome_empresa', 'label' => 'Nome da empresa', 'class' => 'w-64'],
            ['key' => 'cnpj', 'label' => 'CNPJ', 'sortable' => false],
            ['key' => 'telefone', 'label' => 'Telefone', 'class' => 'w-20'],
            ['key' => 'delete', 'label' => '', 'class' => 'w-20'],
        ];
    }

    public function delete($id_cliente)
    {
        $client = Cliente::where('id_cliente', $id_cliente)->first();

        $client->delete();

        $this->success("Cliente deletado com sucesso!", position: 'toast-bottom');
    }

    public function clients()
    {
        return Cliente::
            when($this->search, function ($q) {
                return $q->whereLike('nome_empresa', "%$this->search%")
                    ->orWhereLike('cnpj', "%$this->search%")
                    ->orWhereLike('telefone', "%$this->search%");
            })
            ->get();
    }

    public function editClient(int $id_client)
    {
        $this->is_editing = true;

        $this->id_cliente = $id_client;

        $this->fillClient($this->id_cliente);

        $this->drawer = true;
    }

    public function fillClient(int $id_cliente)
    {
        $client = Cliente::where('id_cliente', $id_cliente)->first();

        $this->fill($client);
    }



    public function render()
    {
        return view('livewire.clientes.index', [
            'headers' => $this->headers(),
            'clients' => $this->clients()
        ]);
    }
}
