<x-layouts.app>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Laporan Order per Kota (Min. 10 Juta)</h1>

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 text-sm font-semibold text-gray-700 uppercase">
                    <tr>
                        <th class="p-4 border-b">Kota</th>
                        <th class="p-4 border-b text-center">Jumlah Order</th>
                        <th class="p-4 border-b text-right">Total Nominal</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @forelse($results as $row)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 border-b font-medium">{{ $row->city }}</td>
                            <td class="p-4 border-b text-center">{{ $row->total_order }}</td>
                            <td class="p-4 border-b text-right text-green-600 font-bold">
                                Rp. {{ number_format($row->total_nominal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-6 text-center text-gray-500 italic">
                                Tidak ada kota dengan total order > 10.000.000.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-sm text-gray-500">
            * Menampilkan data gabungan dari tabel <code>customers</code> dan <code>orders</code>.
        </div>
    </div>
</x-layouts.app>