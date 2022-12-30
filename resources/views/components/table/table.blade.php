<div class="not-prose relative rounded-lg bg-gray-200 overflow-hidden shadow sm:rounded-lg mb-1">
    <input type="hidden" name="orderBy" id="orderBy">
    <input type="hidden" name="orderType" id="orderType">
    <div class="relative rounded-xl overflow-auto">
        <div class="shadow-sm overflow-hidden mt-5">
            <table class="border-collapse table-fixed w-full text-sm">
                <thead>
                    <tr>
                        @foreach ($headers as $key => $header)
                        <th scope="col"
                            class="border-b border-slate-300 font-bold p-4 pt-0 pb-3{{ ' '.$header['classes'] }}"
                            width="{{ $header['width'] }}">
                            @if($header['orderable'])
                            <a class="flex items-center shorting-link cursor-pointer" id="{{ $header['orderBy'] }}"
                                order-type="{{ $header['orderType'] }}">
                                {{ $header['name'] }}
                                @php
                                $iconType = 'up-down';
                                if(request()->input('orderBy') == $header['orderBy'] && request()->input('orderType') ==
                                'asc'){
                                $iconType = 'down';
                                }
                                if(request()->input('orderBy') == $header['orderBy'] && request()->input('orderType') ==
                                'desc'){
                                $iconType = 'up';
                                }
                                @endphp
                                <x-table.short-icon :iconType="$iconType">
                                </x-table.short-icon>
                            </a>
                            @else
                            {{ $header['name'] }}
                            @endif
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

@push('js')
<script>
    const submit = () => {
        document.getElementById('search-form').submit();
    }

    const shortingLinks = document.querySelectorAll('.shorting-link');
    const inputOrderBy = document.querySelector('#orderBy');
    const inputOrderType = document.querySelector('#orderType');
    const filterForm = document.querySelector('#filter-form');

    shortingLinks.forEach(shortingLink => {
        shortingLink.addEventListener('click', function() {
            const thisEl = document.querySelector(`#${this.id}`);
            const orderBy = this.id;
            let orderType = thisEl.getAttribute('order-type');
            orderType = (orderType == 'asc') ? 'desc' : 'asc';

            inputOrderBy.value = orderBy;
            inputOrderType.value = orderType;
            filterForm.submit();
        });
   });
</script>
@endpush