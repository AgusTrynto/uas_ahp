<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    <h3 class="text-xl mb-4">Masukkan Nama Kriteria</h3>
    <form action="{{ route('save_kriteria') }}" method="post" class="space-y-4">
        @csrf
        <input type="hidden" name="jml_kriteria" value="{{ $jml_kriteria }}">
        <input type="hidden" name="jml_alternatif" value="{{ $jml_alternatif }}">
        @for ($i = 0; $i < $jml_kriteria; $i++)
            <div>
                <label for="kriteria_{{ $i }}" class="block">Nama Kriteria {{ $i + 1 }}:</label>
                <input type="text" id="kriteria_{{ $i }}" name="kriteria[]" required class="border rounded p-2 w-full">
            </div>
            <div>
                <label for="label_{{ $i }}" class="block">Label:</label>
                <select id="label_{{ $i }}" name="labels[]" required class="border rounded p-2 w-full">
                    <option value="benefit">Benefit</option>
                    <option value="cost">Cost</option>
                </select>
            </div>
        @endfor
        <div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded" style="color: black">Next</button>
        </div>
    </form>
</x-layout>
