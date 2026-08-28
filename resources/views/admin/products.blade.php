<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Kelola Karya Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 p-6 font-sans">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-2xl shadow-md border border-gray-100">
        
        <!-- Header Admin Panel & Logout -->
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <div>
                <h1 class="text-xl font-bold text-blue-900">Admin Panel - Kelola Karya Siswa</h1>
                <p class="text-xs text-gray-500">Login sebagai: <b class="text-gray-700">{{ Auth::user()->name ?? 'Admin' }}</b></p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('products.index') }}" class="text-xs bg-gray-200 hover:bg-gray-300 text-gray-800 px-3.5 py-2 rounded-lg font-semibold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-store"></i> Lihat Katalog
                </a>
                
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs px-3.5 py-2 rounded-lg font-bold transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg mb-4 text-sm flex justify-between items-center">
                <span><i class="fa-solid fa-circle-check mr-1.5"></i> {{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="font-bold">&times;</button>
            </div>
        @endif

        <!-- Form Tambah Produk Baru -->
        <div class="bg-gray-50 p-5 rounded-xl border mb-6">
            <h2 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-plus-circle text-blue-900"></i> Form Tambah Produk Baru
            </h2>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @csrf
                
                <div>
                    <label class="text-xs font-semibold text-gray-700">Nama Produk</label>
                    <input type="text" name="name" required placeholder="Contoh: Lampu Hias Akrilik" class="w-full border p-2 rounded-lg text-xs mt-1 focus:ring-2 focus:ring-blue-900 focus:outline-none">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-700">Harga (Rp)</label>
                    <input type="number" name="price" required placeholder="Contoh: 50000" class="w-full border p-2 rounded-lg text-xs mt-1 focus:ring-2 focus:ring-blue-900 focus:outline-none">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-700">Kategori / Jurusan</label>
                    <input type="text" name="category" placeholder="Contoh: RPL, Tata Boga, TKJ" required class="w-full border p-2 rounded-lg text-xs mt-1 focus:ring-2 focus:ring-blue-900 focus:outline-none">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-700">Gambar Produk</label>
                    <input type="file" name="image" class="w-full border p-1 rounded-lg text-xs mt-1 bg-white">
                </div>
                <div class="md:col-span-2 flex justify-end gap-2 mt-2">
                    <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg text-xs font-bold shadow-md transition flex items-center gap-1.5">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Produk
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Kelola Produk -->
        <h2 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
            <i class="fa-solid fa-boxes-stacked text-blue-900"></i> Daftar Produk Yang Tersedia
        </h2>
        <div class="overflow-x-auto rounded-xl border">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-100 border-b text-gray-700">
                        <th class="p-3">Gambar</th>
                        <th class="p-3">Nama Produk</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/50' }}" class="h-10 w-10 object-cover rounded-lg shadow-sm">
                        </td>
                        <td class="p-3 font-semibold text-gray-800">{{ $product->name }}</td>
                        <td class="p-3 text-blue-900 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="p-3">
                            <span class="bg-blue-100 text-blue-800 text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                {{ $product->category }}
                            </span>
                        </td>
                        <td class="p-3 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <!-- Tombol Edit -->
                                <button onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ addslashes($product->category) }}')" 
                                        class="bg-amber-100 hover:bg-amber-200 text-amber-800 px-2.5 py-1 rounded-lg font-bold transition flex items-center gap-1">
                                    <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 px-2.5 py-1 rounded-lg font-bold transition flex items-center gap-1">
                                        <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-400">Belum ada barang karya siswa yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Modal Pop-Up Edit Produk -->
    <div id="editModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden flex justify-center items-center z-50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl border">
            <div class="bg-blue-900 text-white p-4 flex justify-between items-center">
                <h3 class="font-bold text-sm"><i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit Produk Karya Siswa</h3>
                <button type="button" onclick="closeEditModal()" class="text-white hover:text-gray-300 text-lg font-bold">&times;</button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data" class="p-5 space-y-3">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-xs font-semibold text-gray-700">Nama Produk</label>
                    <input type="text" id="edit_name" name="name" required class="w-full border p-2 rounded-lg text-xs mt-1 focus:ring-2 focus:ring-blue-900 focus:outline-none">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-700">Harga (Rp)</label>
                    <input type="number" id="edit_price" name="price" required class="w-full border p-2 rounded-lg text-xs mt-1 focus:ring-2 focus:ring-blue-900 focus:outline-none">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-700">Kategori / Jurusan</label>
                    <input type="text" id="edit_category" name="category" required class="w-full border p-2 rounded-lg text-xs mt-1 focus:ring-2 focus:ring-blue-900 focus:outline-none">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-700">Ganti Gambar Produk (Opsional)</label>
                    <input type="file" name="image" class="w-full border p-1 rounded-lg text-xs mt-1 bg-white">
                    <p class="text-[10px] text-gray-400 mt-0.5">Kosongkan jika tidak ingin mengubah gambar.</p>
                </div>

                <div class="pt-3 flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-xs font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-md transition">
                        Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, price, category) {
            const form = document.getElementById('editForm');
            form.action = `/admin/products/${id}`;

            document.getElementById('edit_name').value = name;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_category').value = category;

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>
</html>