<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <x-breadcrumb :contents="json_encode(['Roles' => route('roles.index'), 'Create' => '#'])" />

        <form method="post" action="{{ route('roles.store') }}">
            @csrf
            <div class="px-5 py-3 mb-4 text-gray-700 border border-gray-200 rounded-lg bg-white shadow space-y-6">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Create Role') }}
                    </h2>
                </header>


                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')"
                        required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <x-input-label class="pb-0" for="name" :value="__('Permissions')" />
                <div class="overflow-y-auto max-h-64 columns-5 p-1">
                    @forelse ($permissions as $key => $permission)
                    <div class="flex items-center mb-4">
                        <x-checkbox-input id="permission_id-{{ $key }}" name="permission_id[]" class="block w-full"
                            value="{{ $permission->id }}" />
                        <x-input-label class="ml-1" for="permission_id-{{ $key }}" :value="$permission->name" />
                    </div>
                    @empty
                    <span>Data not available.</span>
                    @endforelse
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>