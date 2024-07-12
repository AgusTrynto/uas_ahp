<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    <h3 class="text-xl mb-4">Masukkan Nama Alternatif</h3>
    <form action="{{ route('save_alternatif') }}" method="post" class="space-y-4">
        @csrf
        <input type="hidden" name="jml_kriteria" value="{{ $jml_kriteria }}">
        <input type="hidden" name="jml_alternatif" value="{{ $jml_alternatif }}">
        @for ($i = 0; $i < $jml_alternatif; $i++)
            <div>
                <label for="alternatif_{{ $i }}" class="block">Nama Alternatif {{ $i + 1 }}:</label>
                <input type="text" id="alternatif_{{ $i }}" name="alternatif[]" required class="border rounded p-2 w-full">
            </div>
        @endfor
        <div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded" style="color: black">Next</button>
        </div>
    </form>
</x-layout>
