<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :contents="json_encode(['Users' => '#'])" />

        {{-- Search --}}
        <form action="{{ route('users.index') }}">
            <x-search-input :value="$search" :action="route('users.create')" />
        </form>

        <div class="not-prose relative rounded-lg bg-gray-200 overflow-hidden shadow sm:rounded-lg mb-1">
            <div class="relative rounded-xl overflow-auto">
                <div class="shadow-sm overflow-hidden mt-5">
                    <table class="border-collapse table-fixed w-full text-sm">
                        <thead>
                            <tr>
                                <th class="border-b border-slate-300 font-bold p-4 pl-8 pt-0 pb-3" width="1%">
                                </th>
                                <th class="border-b border-slate-300 font-bold p-4 pl-8 pt-0 pb-3 text-left" width="5%">
                                    No.</th>
                                <th class="border-b border-slate-300 font-bold p-4 pl-8 pt-0 pb-3 text-left">
                                    Name</th>
                                <th class="border-b border-slate-300 font-bold p-4 pl-2 pt-0 pb-3 text-left">
                                    Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                            <tr class="even:bg-white">
                                <td class="border-b border-slate-150 p-2 text-left bg-white pl-5">
                                    <x-button-action-delete href="{{ route('users.destroy', $user) }}" title="delete">{{
                                        __('x')
                                        }}
                                    </x-button-action-delete>
                                </td>
                                <td class="border-b border-slate-150 p-2 text-left bg-white pl-8">
                                    {{ $key+1 }}
                                </td>
                                <td class="border-b border-slate-150 p-2 text-left bg-white pl-8">
                                    <a href="{{ route('users.edit', $user) }}" class="link" title="edit">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td class="border-b border-slate-150 p-2 text-left bg-white">{{ $user->email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $users->links() }}
    </div>

</x-app-layout>