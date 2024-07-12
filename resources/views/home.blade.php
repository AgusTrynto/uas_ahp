<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    <h3 class="text-xl mb-4">Masukan jumlah Kriteria dan Alternatif</h3>
    <form action="{{ route('setup') }}" method="post" class="space-y-4">
        @csrf
        <div>
            <label for="jml_kriteria" class="block">Jumlah Kriteria:</label>
            <input type="number" id="jml_kriteria" name="jml_kriteria" required class="border rounded p-2 w-full">
        </div>
        <div>
            <label for="jml_alternatif" class="block">Jumlah Alternatif:</label>
            <input type="number" id="jml_alternatif" name="jml_alternatif" required class="border rounded p-2 w-full">
        </div>
        <div>
            <button style="color: black" type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Next</button>
        </div>
    </form>
</x-layout>
