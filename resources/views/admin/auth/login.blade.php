<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(249,115,22,0.16),_transparent_32%),linear-gradient(135deg,_#f8fafc_0%,_#eef2ff_100%)] flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-4xl bg-white rounded-[2rem] shadow-2xl border border-slate-200 overflow-hidden grid lg:grid-cols-[0.95fr_1.05fr]">
        <div class="bg-gradient-to-br from-orange-600 via-orange-500 to-amber-400 text-white p-8 lg:p-10 flex flex-col justify-between">
            <div>
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white/20 border border-white/30 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h1 class="text-3xl font-semibold tracking-tight">Admin Login</h1>
                <p class="mt-3 text-sm text-orange-50 leading-7">Sign in to manage your clinic dashboard, appointments, blogs, services, and patient content.</p>
            </div>
            <div class="rounded-2xl border border-white/20 bg-white/10 p-4 mt-8">
                <p class="text-xs uppercase tracking-[0.3em] text-orange-100">Secure access</p>
                <ul class="mt-3 space-y-2 text-sm text-orange-50">
                    <li>• Use your existing admin credentials</li>
                    <li>• Access protected management tools</li>
                    <li>• Keep your content up to date</li>
                </ul>
            </div>
        </div>

        <div class="p-8 lg:p-10 bg-slate-50/70">
            <div class="flex items-center justify-between gap-3 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 16l-4-4m0 0l4-4m-4 4h14"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Welcome back</h2>
                        <p class="text-sm text-slate-500">Access the admin dashboard</p>
                    </div>
                </div>
                <a href="{{ route('admin.secret.signup') }}" class="text-sm font-medium text-slate-600 hover:text-orange-600">Create account</a>
            </div>

            @if($errors->any())
                <div class="mb-4 bg-red-50 text-red-700 border border-red-200 px-3 py-2 rounded-xl text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
                @csrf
                <x-form-control name="email" label="Email" type="email" :value="old('email')" class="focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                <x-form-control name="password" label="Password" type="password" class="focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                <button class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2.75 rounded-xl shadow-sm transition-all duration-150">Sign In</button>
            </form>

            <div class="mt-6 text-sm text-slate-500">
                Need an account?
                <a href="{{ route('admin.secret.signup') }}" class="ml-1 font-medium text-slate-900 hover:text-orange-600">Create one here</a>
            </div>
        </div>
    </div>
</body>
</html>
