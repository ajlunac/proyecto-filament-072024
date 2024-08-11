<div>
   <h1 class="text-2xl">Contador</h1>
   <section>

        <h1 class="text-xl text-bold"> {{ $count }} </h1>
        <x-filament::button color="success" wire:click="increment">
            +
        </x-filament::button>

        <x-filament::button color="danger" wire:click="decrement">
            -
        </x-filament::button>

   </section>
</div>
