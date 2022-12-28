<div class="not-prose relative rounded-lg bg-gray-200 overflow-hidden shadow sm:rounded-lg mb-1">
    <div class="relative rounded-xl overflow-auto">
        <div class="shadow-sm overflow-hidden mt-5">
            <table class="border-collapse table-fixed w-full text-sm">
                <thead>
                    <tr>
                        @foreach ($headers as $header)
                        <th class="border-b border-slate-300 font-bold p-4 pt-0 pb-3{{ ' '.$header['classes'] }}"
                            width="{{ $header['width'] }}">
                            {{ $header['name'] }}
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>