<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-semibold mb-2">Matriks Normalisasi</h2>
        <table class="table-auto w-full border-collapse border border-gray-400">
            <thead>
                <tr>
                    @foreach ($kriteria as $k)
                        <th class="border border-gray-300 px-4 py-2">{{ $k->nama }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($normalizedMatrix); $i++)
                    <tr>
                        @for ($j = 0; $j < count($normalizedMatrix); $j++)
                            <td class="border border-gray-300 px-4 py-2">{{ number_format($normalizedMatrix[$i][$j], 4) }}</td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>

        <h2 class="text-xl font-semibold mb-2 mt-4">Bobot Kriteria</h2>
        <table class="table-auto w-full border-collapse border border-gray-400">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Kriteria</th>
                    <th class="border border-gray-300 px-4 py-2">Bobot</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($weights as $index => $weight)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $kriteria[$index]->nama }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($weight, 4) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="text-xl font-semibold mb-2 mt-4">Konsistensi</h2>
        <p class="mb-2">CI: {{ number_format($ci, 4) }}</p>
        <p class="mb-2">CR: {{ number_format($cr, 4) }}</p>
        @if ($cr < 0.1)
            <p class="text-green-500">Matriks konsisten</p>
        @else
            <p class="text-red-500">Matriks tidak konsisten, periksa kembali nilai perbandingan berpasangan</p>
        @endif
    </div>
</x-layout>