<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <h3 class="text-xl mb-4">Masukkan Nilai Alternatif</h3>
    <form action="{{ route('calculate_alternatif') }}" method="post" class="space-y-4">
        @csrf
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">Alternatif / Kriteria</th>
                        @foreach ($kriteria as $kriteria_item)
                            <th class="border border-gray-300 px-4 py-2">{{ $kriteria_item->nama }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alternatif as $alternatif_item)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $alternatif_item->nama }}</td>
                            @foreach ($kriteria as $kriteria_item)
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="number" name="matrix[{{ $alternatif_item->id }}][{{ $kriteria_item->id }}]" class="w-full border rounded p-2" required>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded" style="color: black">Next</button>
        </div>
    </form>
</x-layout>
