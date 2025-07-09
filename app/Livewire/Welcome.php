<?php

namespace App\Livewire;

use App\Models\Usuario;
use Illuminate\Support\Collection;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class Welcome extends Component
{
    use Toast;

    public ?int $id_usuario = null;

    public bool $is_editing = false;

    public string $search = '';

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    #[Rule('required')]
    public string $nome = '';

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $senha = '';

    #[Rule('required')]
    public string $tipo = '';

    public function submit()
    {
        $validated = $this->validate();

        Usuario::create($validated);

        $this->success("Usuário criado", position: 'toast-bottom');
    }

    // Delete action
    public function delete($id_usuario): void
    {
        $user = Usuario::where('id_usuario', $id_usuario)->first();

        $user->delete();

        $this->success("Usuário deletado com sucesso!", position: 'toast-bottom');
    }

    // Table headers
    public function headers(): array
    {
        return [
            ['key' => 'id_usuario', 'label' => '#', 'sortable' => false, 'class' => 'w-1'],
            ['key' => 'nome', 'label' => 'Nome', 'sortable' => false, 'class' => 'w-64'],
            ['key' => 'email', 'label' => 'E-mail', 'sortable' => false],
            ['key' => 'tipo', 'label' => 'Tipo', 'sortable' => false, 'class' => 'w-20'],
        ];
    }

    public function users(): Collection
    {
        return Usuario::
            when($this->search, function ($q) {
                return $q->whereLike('nome', "%$this->search%")
                    ->orWhereLike('email', "%$this->search%")
                    ->orWhereLike('tipo', "%$this->search%");
            })
            ->get();
    }

    public function editUser(int $id_usuario)
    {
        $this->is_editing = true;

        $this->id_usuario = $id_usuario;

        $this->fillClient($this->id_cliente);

        $this->drawer = true;
    }

    public function fillClient(int $id_usuario)
    {
        $user = Usuario::where('id_usuario', $id_usuario)->first();

        $this->fill($user);
    }

    public function render()
    {
        return view('livewire.welcome', [
            'users' => $this->users(),
            'headers' => $this->headers()
        ]);
    }
}
