<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(15,23,42,0.14),_transparent_30%),linear-gradient(135deg,_#f8fafc_0%,_#e2e8f0_100%)] flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-5xl bg-white rounded-[2rem] shadow-2xl border border-slate-200 overflow-hidden grid lg:grid-cols-[1.05fr_0.95fr]">
        <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 text-white p-8 lg:p-10 flex flex-col justify-between">
            <div>
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white/10 border border-white/20 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h1 class="text-3xl font-semibold tracking-tight">Create an Admin Account</h1>
                <p class="mt-3 text-sm text-slate-300 leading-7">Register a new database-backed admin account for secure portal access and content management.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/10 p-4 mt-8">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-300">Access includes</p>
                <ul class="mt-3 space-y-2 text-sm text-slate-200">
                    <li>• Secure portal login</li>
                    <li>• Database-backed admin access</li>
                    <li>• Manage appointments, blogs, and clinics</li>
                </ul>
            </div>
        </div>

        <div class="p-8 lg:p-10 bg-slate-50/70">
            <div class="flex items-center justify-between gap-3 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-slate-900 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6l4 2"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Create an Account</h2>
                        <p class="text-sm text-slate-500">Register a new admin account quickly</p>
                    </div>
                </div>
                <a href="{{ route('admin.login') }}" class="text-sm font-medium text-slate-600 hover:text-orange-600">Sign in</a>
            </div>

            @if($errors->any())
                <div class="mb-4 bg-red-50 text-red-700 border border-red-200 px-3 py-2 rounded-xl text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.secret.signup.submit') }}" method="POST" class="space-y-3">
                @csrf
                <x-form-control name="name" type="text" placeholder="Full name" />
                <x-form-control name="email" type="email" placeholder="Email" :value="old('email')" />
                <x-form-control name="password" type="password" placeholder="Password" />
                <x-form-control name="password_confirmation" type="password" placeholder="Confirm password" />
                <button class="w-full bg-slate-900 hover:bg-slate-800 text-white font-medium px-4 py-2.75 rounded-xl shadow-sm transition-all duration-150">Create Account</button>
            </form>

            <div class="mt-6 text-sm text-slate-500">
                Already have an account?
                <a href="{{ route('admin.login') }}" class="ml-1 font-medium text-slate-900 hover:text-orange-600">Sign in here</a>
            </div>
        </div>
    </div>
</body>
</html>
