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
    public function delete($id): void
    {
        $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    }

    // Table headers
    public function headers(): array
    {
        return [
            ['key' => 'id_usuario', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'nome', 'label' => 'Nome', 'class' => 'w-64'],
            ['key' => 'email', 'label' => 'E-mail', 'sortable' => false],
            ['key' => 'tipo', 'label' => 'Tipo', 'class' => 'w-20'],
        ];
    }

    public function users(): Collection
    {
        return Usuario::all();
    }

    public function render()
    {
        return view('livewire.welcome', [
            'users' => $this->users(),
            'headers' => $this->headers()
        ]);
    }
}
