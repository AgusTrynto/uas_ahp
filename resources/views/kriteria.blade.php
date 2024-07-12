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
                                    <input type="number" name="matrix[{{ $k1->id }}][{{ $k2->id }}]" id="input-{{ $i }}-{{ $j }}" step="0.000000000000001" min="0" class="border rounded p-2 w-full">
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded" style="color: black">Save</button>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const kriteriaCount = {{ count($kriteria) }};
            
            for (let i = 0; i < kriteriaCount; i++) {
                for (let j = 0; j < kriteriaCount; j++) {
                    if (i !== j) {
                        const inputIJ = document.getElementById(`input-${i}-${j}`);
                        const inputJI = document.getElementById(`input-${j}-${i}`);
                        
                        inputIJ.addEventListener('input', function() {
                            if (inputIJ.value !== '') {
                                inputJI.value = (1 / parseFloat(inputIJ.value)).toFixed(12);
                            } else {
                                inputJI.value = '';
                            }
                        });
                    }
                }
            }
        });
    </script>
</x-layout>
