<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
  <h3 class="text-xl mb-4">Hasil Perhitungan Alternatif</h3>
  <table class="table-auto border-collapse border border-gray-200 w-full">
      <thead>
          <tr class="bg-gray-100">
              <th class="border border-gray-300 px-4 py-2">Alternatif</th>
              <th class="border border-gray-300 px-4 py-2">Skor</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($results as $result)
              <tr>
                  <td class="border border-gray-300 px-4 py-2">{{ $result['nama'] }}</td>
                  <td class="border border-gray-300 px-4 py-2">{{ $result['score'] }}</td>
              </tr>
          @endforeach
      </tbody>
  </table>
</x-layout>
