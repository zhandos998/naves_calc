<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Мои расчёты</h2>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">
            @if($requests->isEmpty())
                <p class="text-gray-500">У вас пока нет сохранённых расчётов.</p>
            @else
                <table class="w-full table-auto text-sm border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 border">Дата</th>
                            <th class="p-2 border">Размеры</th>
                            <th class="p-2 border">Форма</th>
                            <th class="p-2 border">Итого</th>
                            <th class="p-2 border"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                        <tr>
                            <td class="p-2 border">{{ \Carbon\Carbon::parse($req->created_at)->format('d.m.Y H:i') }}</td>
                            <td class="p-2 border">{{ $req->width }}×{{ $req->length }}×{{ $req->height }} м</td>
                            <td class="p-2 border">{{ $req->frame_type }}</td>
                            <td class="p-2 border font-semibold">{{ number_format($req->final_price, 0, '.', ' ') }} ₸</td>
                            <td class="p-2 border font-semibold">
                                <a href="{{ route('calc.from_request', $req->id) }}"
                                    class="text-blue-600 hover:underline text-sm">
                                    Открыть в калькуляторе
                                </a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
