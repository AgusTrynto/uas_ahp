<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    <h3 class="text-xl mb-4">Masukkan Nilai Matriks Kriteria</h3>
    <form action="{{ route('save_matrix') }}" method="POST" class="space-y-4">
        @csrf
        <table class="border-collapse border border-gray-400 w-full">
            <thead>
                <tr>
                    <th class="border border-gray-400 p-2">Kriteria</th>
                    @foreach ($kriteria as $k)
                        <th class="border border-gray-400 p-2">{{ $k->nama }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($kriteria as $i => $k1)
                    <tr>
                        <td class="border border-gray-400 p-2">{{ $k1->nama }}</td>
                        @foreach ($kriteria as $j => $k2)
                            <td class="border border-gray-400 p-2">
                                @if ($i == $j)
                                    <input type="number" name="matrix[{{ $k1->id }}][{{ $k2->id }}]" value="1" readonly class="border rounded p-2 w-full">
                                @else
                                    <input type="number" name="matrix[{{ $k1->id }}][{{ $k2->id }}]" step="0.01" min="0" class="border rounded p-2 w-full">
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Save</button>
        </div>
    </form>
</x-layout>
