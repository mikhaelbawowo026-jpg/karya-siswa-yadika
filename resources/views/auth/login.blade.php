<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SMK Yadika Manado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-blue-900 p-6 text-center text-white relative">
            <a href="{{ route('products.index') }}" class="absolute top-4 left-4 text-xs bg-blue-800 hover:bg-blue-700 px-3 py-1.5 rounded-lg text-white">
                <i class="fa-solid fa-arrow-left"></i> Katalog
            </a>
            <img src="{{ asset('images/logo-yadika.png') }}" 
                 onerror="this.src='https://ui-avatars.com/api/?name=SMK+Yadika&background=0D8ABC&color=fff&rounded=true'" 
                 class="w-16 h-16 mx-auto bg-white p-1 rounded-full shadow-md mb-2">
            <h2 class="font-bold text-lg">Login Admin Gallery</h2>
            <p class="text-xs text-blue-200">SMK Yadika Manado</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="p-6 space-y-4">
            @csrf

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded-lg text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="text-xs font-semibold text-gray-700">Email Admin</label>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" required placeholder="admin@smkyadika.sch.id" class="w-full pl-9 pr-3 py-2 border rounded-lg text-xs focus:ring-2 focus:ring-blue-900 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-700">Password</label>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full pl-9 pr-3 py-2 border rounded-lg text-xs focus:ring-2 focus:ring-blue-900 focus:outline-none">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-2.5 rounded-lg text-xs shadow-md transition">
                Masuk ke Admin Panel
            </button>
        </form>
    </div>

</body>
</html>