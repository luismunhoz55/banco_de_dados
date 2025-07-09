<div>
    <!-- HEADER -->
    <x-header title="Clientes" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Adicionar" @click="$wire.drawer = true" responsive icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$clients">
            @scope('actions', $client)
            <x-button icon="o-pencil" wire:click="editClient({{ $client['id_cliente'] }})"
                class="btn-ghost btn-sm text-error" />
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Adicionar cliente" right separator with-close-button class="lg:w-1/3">
        <x-form wire:submit="submit">
            <x-input label="Nome da empresa" wire:model='nome_empresa' />
            <x-input label="CNPJ" wire:model='cnpj' />
            <x-input label="Telefone" wire:model='telefone' />
            <x-button label="Criar" icon="o-check" class="btn-primary" type="submit" />
        </x-form>
    </x-drawer>
</div>
