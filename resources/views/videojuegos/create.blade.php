<x-app-layout>
    <div class="w-1/2 mx-auto">
        <form method="POST" action="{{ route('videojuegos.store') }}">
            @csrf

            <!-- Titulo -->
            <div>
                <x-input-label for="titulo" :value="'titulo del videojuego'" />
                <x-text-input id="titulo" class="block mt-1 w-full"
                    type="text" name="titulo" :value="old('titulo')" required
                    autofocus autocomplete="titulo" />
                <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="anyo" :value="'Año del videojuego'" />
                <x-text-input id="anyo" class="block mt-1 w-full"
                    type="text" name="anyo" :value="old('anyo')" required
                    autofocus autocomplete="anyo" />
                <x-input-error :messages="$errors->get('anyo')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="desarrolladora_id" :value="'Desarrolladora del videojuego'" />
                <x-text-input id="desarrolladora_id" class="block mt-1 w-full"
                    type="text" name="desarrolladora_id" :value="old('desarrolladora_id')" required
                    autofocus autocomplete="desarrolladora_id" />
                <x-input-error :messages="$errors->get('desarrolladora_id')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('videojuegos.index') }}">
                    <x-secondary-button class="ms-4">
                        Volver
                        </x-primary-button>
                </a>
                <x-primary-button class="ms-4">
                    Insertar
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
