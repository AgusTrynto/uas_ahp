<x-layout>
    <x-slot:title>Ranking Alternatif</x-slot:title>
    <h3 class="text-xl mb-4">Hasil Ranking Alternatif</h3>
    <table class="table-auto border-collapse border border-gray-200 w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">Ranking</th>
                <th class="border border-gray-300 px-4 py-2">Alternatif</th>
                <th class="border border-gray-300 px-4 py-2">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rankings as $index => $ranking)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $ranking['alternatif'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($ranking['score'], 4) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
