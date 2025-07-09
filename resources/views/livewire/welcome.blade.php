<div>
    <!-- HEADER -->
    <x-header title="Usuários" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Adicionar" @click="$wire.drawer = true" responsive icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$users" :sort-by="$sortBy">
            @scope('actions', $user)
            <x-button icon="o-pencil" wire:click="editUser({{ $user['id_usuario'] }})"
                class="btn-ghost btn-sm text-error" />
            @endscope
            @scope('cell_delete', $user)
            <x-button icon="o-trash" wire:click="delete({{ $user['id_usuario'] }})"
                class="btn-ghost btn-sm text-error" />
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Adicionar cliente" right separator with-close-button class="lg:w-1/3">
        <x-form wire:submit="submit">
            <x-input label="Nome" wire:model='nome' />
            <x-input label="E-mail" wire:model='email' />
            <x-input label="Senha" wire:model='senha' />
            <x-input label="Tipo" wire:model='tipo' />
            <x-button label="Criar" icon="o-check" class="btn-primary" type="submit" />
        </x-form>
    </x-drawer>
</div>
