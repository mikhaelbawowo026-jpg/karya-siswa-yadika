<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karya Siswa - SMK Yadika Manado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Animasi Pop-Up Photocard */
        @keyframes photocardPop {
            0% {
                opacity: 0;
                transform: scale(0.7) translateY(30px) rotate(-3deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0) rotate(0deg);
            }
        }
        .animate-photocard {
            animation: photocardPop 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        /* Hover Glow Effect */
        .card-hover {
            transition: all 0.3s ease-in-out;
        }
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(30, 58, 138, 0.15), 0 8px 10px -6px rgba(30, 58, 138, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    <!-- Navigation Header -->
    <header class="bg-blue-900/95 backdrop-blur-md text-white sticky top-0 z-40 shadow-lg border-b border-blue-800">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo Sekolah + Nama Sekolah -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo-yadika.png') }}" 
                     onerror="this.src='https://ui-avatars.com/api/?name=SMK+Yadika&background=0D8ABC&color=fff&rounded=true'" 
                     alt="Logo SMK Yadika Manado" 
                     class="w-10 h-10 object-contain rounded-full bg-white p-1 shadow-md">
                <div>
                    <h1 class="font-bold text-lg leading-tight">SMK Yadika Manado</h1>
                    <p class="text-[11px] text-blue-200">Galeri & Toko Kreativitas Siswa</p>
                </div>
            </div>

            <!-- Menu Autentikasi / Status Admin -->
            <div class="flex items-center gap-2">
                @auth
                    <div class="text-right hidden sm:block mr-2">
                        <p class="text-xs font-bold leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-blue-200">Admin Terautentikasi</p>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="bg-blue-800 hover:bg-blue-700 text-xs px-3 py-2 rounded-lg flex items-center gap-1.5 transition border border-blue-600">
                        <i class="fa-solid fa-gauge text-yellow-400"></i> Admin Panel
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-2 rounded-lg font-bold transition flex items-center gap-1">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-800 hover:bg-blue-700 text-xs px-3.5 py-2 rounded-lg flex items-center gap-2 transition border border-blue-600 shadow-sm">
                        <i class="fa-solid fa-lock text-yellow-400"></i> Login Admin
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero / Banner Background Gedung Sekolah -->
    <section class="relative bg-cover bg-center py-20 px-4 text-center text-white" 
             style="background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.8), rgba(30, 58, 138, 0.85)), url('{{ asset('images/bg-sekolah.jpg') }}'), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1200&q=80');">
        <div class="max-w-3xl mx-auto space-y-3">
            <span class="bg-yellow-500/20 text-yellow-300 text-xs font-semibold px-3 py-1 rounded-full border border-yellow-500/30">
                Pameran Hasil Karya Siswa
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Kreativitas Tanpa Batas SMK Yadika Manado</h2>
            <p class="text-sm md:text-base text-blue-100 max-w-xl mx-auto">
                Dukung karya inovatif siswa-siswi SMK Yadika Manado mulai dari produk teknologi, kuliner, hingga seni grafis.
            </p>
        </div>
    </section>

    <!-- Main Content Katalog Produk -->
    <main class="max-w-6xl mx-auto px-4 py-8 -mt-6">
        @if(session('success'))
            <div class="bg-green-500 text-white font-medium text-sm px-4 py-3 rounded-lg mb-6 shadow-md flex items-center justify-between">
                <span><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-white font-bold">&times;</button>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-xl shadow-sm border">
            <h3 class="text-lg font-bold text-gray-800 border-l-4 border-blue-900 pl-3">Daftar produk karya siswa</h3>
            <span class="text-xs text-gray-500 font-medium">{{ $products->count() }} Barang Ditemukan</span>
        </div>

        <!-- Grid Photocard Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between card-hover group">
                    <div class="relative overflow-hidden">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/300' }}" 
                             alt="{{ $product->name }}" 
                             class="h-48 w-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-blue-900/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
                            {{ $product->category }}
                        </span>
                    </div>

                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm line-clamp-2 group-hover:text-blue-900 transition">{{ $product->name }}</h4>
                        </div>
                        
                        <div class="mt-4 pt-3 border-t flex justify-between items-center">
                            <div>
                                <p class="text-[10px] text-gray-400">Harga</p>
                                <p class="text-blue-900 font-extrabold text-base">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <button onclick="openOrderModal('{{ $product->name }}', {{ $product->price }}, '{{ $product->category }}', '{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/300' }}')" 
                                    class="bg-blue-900 hover:bg-blue-800 text-white p-2.5 rounded-xl shadow transition flex items-center justify-center">
                                <i class="fa-solid fa-cart-shopping text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-8 rounded-2xl text-center border">
                    <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500 text-sm">Belum ada barang karya siswa yang ditampilkan.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Modal Form Order (Photocard Pop-Up Animasi) -->
    <div id="orderModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden flex justify-center items-center z-50 p-4">
        <div id="modalCard" class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl border border-white/20 animate-photocard">
            
            <!-- Photo Card Header / Preview Gambar -->
            <div class="relative h-44 bg-gray-900">
                <img id="modalProductImage" src="" class="w-full h-full object-cover opacity-90">
                <button type="button" onclick="closeOrderModal()" class="absolute top-3 right-3 bg-black/50 hover:bg-black text-white w-8 h-8 rounded-full flex items-center justify-center text-sm transition">
                    &times;
                </button>
                <div class="absolute bottom-3 left-3 right-3 bg-gradient-to-t from-black/80 to-transparent p-2 rounded-lg text-white">
                    <span id="modalProductCategory" class="text-[10px] bg-yellow-500 text-black font-bold px-2 py-0.5 rounded-full"></span>
                    <h3 id="modalProductName" class="font-bold text-sm truncate mt-1"></h3>
                    <p id="modalProductPrice" class="text-yellow-300 font-extrabold text-xs"></p>
                </div>
            </div>

            <!-- Form Pemesanan -->
            <form action="{{ route('orders.store') }}" method="POST" class="p-5 space-y-3">
                @csrf
                <input type="hidden" name="total_price" id="modalPrice">

                <div>
                    <label class="text-xs font-semibold text-gray-700">Nama Lengkap Pemesan</label>
                    <input type="text" name="buyer_name" required placeholder="Contoh: Andi Pratama" class="w-full border p-2 rounded-lg text-xs mt-1 focus:ring-2 focus:ring-blue-900 focus:outline-none">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-700">Kelas / Instansi Pemesan</label>
                    <input type="text" name="buyer_class" required placeholder="Contoh: XII RPL 1 / Umum" class="w-full border p-2 rounded-lg text-xs mt-1 focus:ring-2 focus:ring-blue-900 focus:outline-none">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-700">Metode Pembayaran</label>
                    <select name="payment_method" class="w-full border p-2 rounded-lg text-xs mt-1 bg-gray-50 focus:ring-2 focus:ring-blue-900 focus:outline-none">
                        <option value="COD">COD (Bayar Langsung di Sekolah)</option>
                        <option value="QRIS">QRIS (Scan All Payment)</option>
                        <option value="Transfer">Transfer Bank</option>
                    </select>
                </div>

                <div class="pt-2 flex gap-2">
                    <button type="button" onclick="closeOrderModal()" class="w-1/3 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg text-xs font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="w-2/3 bg-blue-900 hover:bg-blue-800 text-white py-2 rounded-lg text-xs font-bold shadow-md transition flex items-center justify-center gap-1">
                        <i class="fa-solid fa-paper-plane text-[10px]"></i> Konfirmasi Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Live Chat Admin Floating Widget -->
    <div class="fixed bottom-5 right-5 z-40">
        <button onclick="toggleChat()" class="bg-blue-900 hover:bg-blue-800 text-white p-4 rounded-full shadow-2xl flex items-center justify-center transition transform hover:scale-110">
            <i class="fa-solid fa-comments text-xl"></i>
        </button>
    </div>

    <!-- Chat Box Drawer -->
    <div id="chatBox" class="fixed bottom-20 right-5 w-80 bg-white border rounded-2xl shadow-2xl hidden overflow-hidden z-50">
        <div class="bg-blue-900 text-white p-3.5 font-bold text-xs flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                <span>Chat Admin SMK Yadika</span>
            </div>
            <button onclick="toggleChat()" class="text-white hover:text-gray-300">&times;</button>
        </div>
        <div id="chatMessages" class="p-3 h-48 overflow-y-auto text-xs space-y-2 bg-gray-50">
            <div class="bg-blue-100 text-blue-900 p-2.5 rounded-xl max-w-[85%]">
                Halo! Ada yang bisa kami bantu mengenai pesanan atau karya siswa SMK Yadika Manado?
            </div>
        </div>
        <div class="p-2 border-t flex bg-white">
            <input type="text" id="chatInput" placeholder="Ketik pesan..." class="w-full border px-2 py-1.5 text-xs rounded-l-lg focus:outline-none">
            <button onclick="sendChatMessage()" class="bg-blue-900 text-white px-3 text-xs rounded-r-lg font-bold">Kirim</button>
        </div>
    </div>

    <script>
        function openOrderModal(name, price, category, image) {
            document.getElementById('modalProductName').innerText = name;
            document.getElementById('modalProductCategory').innerText = category;
            document.getElementById('modalProductPrice').innerText = 'Rp ' + price.toLocaleString('id-ID');
            document.getElementById('modalProductImage').src = image;
            document.getElementById('modalPrice').value = price;
            
            const modal = document.getElementById('orderModal');
            const card = document.getElementById('modalCard');
            
            modal.classList.remove('hidden');
            // Re-trigger animasi photocard pop-up
            card.classList.remove('animate-photocard');
            void card.offsetWidth; 
            card.classList.add('animate-photocard');
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
        }

        function toggleChat() {
            document.getElementById('chatBox').classList.toggle('hidden');
        }

        function sendChatMessage() {
            const input = document.getElementById('chatInput');
            const box = document.getElementById('chatMessages');
            if(input.value.trim() !== '') {
                box.innerHTML += `
                    <div class="flex justify-end">
                        <span class="bg-blue-900 text-white p-2.5 rounded-xl max-w-[85%]">${input.value}</span>
                    </div>
                `;
                const userMsg = input.value;
                input.value = '';
                box.scrollTop = box.scrollHeight;

                setTimeout(() => {
                    box.innerHTML += `
                        <div class="bg-blue-100 text-blue-900 p-2.5 rounded-xl max-w-[85%]">
                            Terima kasih! Pesan Anda mengenai "${userMsg}" akan segera dibalas oleh Admin.
                        </div>
                    `;
                    box.scrollTop = box.scrollHeight;
                }, 1000);
            }
        }
    </script>
</body>
</html>