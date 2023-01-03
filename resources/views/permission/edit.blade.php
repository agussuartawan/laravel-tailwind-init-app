<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <x-breadcrumb :contents="json_encode(['Permissions' => route('permissions.index'), 'Edit' => '#'])" />

        <div class="px-5 py-3 mb-4 text-gray-700 border border-gray-200 rounded-lg bg-white shadow">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Create Permission') }}
                </h2>
            </header>

            <form method="post" action="{{ route('permissions.update', $permission) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        :value="old('name', $permission->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="role_id" :value="__('Roles')" />
                    <x-select-input id="role_id" name="role_id" type="text" class="mt-1 block w-full"
                        :value="old('role_id', $permission->name)" required autofocus autocomplete="role_id" />
                    <x-input-error class="mt-2" :messages="$errors->get('role_id')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>