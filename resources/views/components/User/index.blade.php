@extends('components.layout')

@section('title', 'إعدادات الحساب')

@section('content')
    <div class="max-w-4xl mx-auto fade-in">
        {{-- العنوان الرئيسي --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-black text-white mb-2">إعدادات الحساب ⚙️</h1>
            <p class="text-slate-400">إدارة ملفك الشخصي وأمان الحساب.</p>
        </div>

        {{-- رسائل النجاح أو الخطأ --}}
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-2xl mb-6 flex items-center gap-3 font-bold animate-fade-in">
                <i class="fa-solid fa-circle-check text-lg"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-2xl mb-6 flex items-center gap-3 font-bold animate-fade-in">
                <i class="fa-solid fa-circle-exclamation text-lg"></i> {{ session('error') }}
            </div>
        @endif

        <div class="space-y-8">
            {{-- قسم المعلومات الشخصية --}}
            <div class="relative bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 shadow-2xl overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>

                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-sm shadow-lg">
                        <i class="fa-solid fa-id-card"></i>
                    </span>
                    المعلومات الشخصية
                </h2>

                <form method="POST" action="/account/update" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- الاسم --}}
                        <div class="space-y-2">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">الاسم</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-user text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <input 
                                    type="text" 
                                    name="name" 
                                    value="{{ Auth::user()->name }}" 
                                    class="w-full bg-slate-950/50 border border-slate-700 rounded-xl pr-10 pl-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                                >
                            </div>
                            <x-form-error name="name" class="text-red-400 text-xs mt-1" />
                        </div>

                        {{-- البريد الإلكتروني --}}
                        <div class="space-y-2">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">البريد الإلكتروني</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-envelope text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <input 
                                    type="email" 
                                    name="email" 
                                    value="{{ Auth::user()->email }}" 
                                    class="w-full bg-slate-950/50 border border-slate-700 rounded-xl pr-10 pl-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                                >
                            </div>
                            <x-form-error name="email" class="text-red-400 text-xs mt-1" />
                        </div>

                        {{-- رقم الهاتف --}}
                        <div class="space-y-2">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">رقم الهاتف</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-phone text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <input 
                                    type="text" 
                                    name="MobileNumber" 
                                    value="{{ Auth::user()->MobileNumber }}" 
                                    class="w-full bg-slate-950/50 border border-slate-700 rounded-xl pr-10 pl-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-right" 
                                    dir="ltr"
                                >
                            </div>
                            <x-form-error name="MobileNumber" class="text-red-400 text-xs mt-1" />
                        </div>

                        {{-- الدور الحالي (غير قابل للتعديل) --}}
                        <div class="space-y-2">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">الدور الحالي</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-shield-halved text-slate-500"></i>
                                </div>
                                <input 
                                    type="text" 
                                    value="{{ Auth::user()->role->RoleName ?? 'مستخدم' }}" 
                                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl pr-10 pl-4 py-3 text-slate-400 cursor-not-allowed" 
                                    disabled
                                >
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-white/5">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-900/20 transition hover:-translate-y-1">
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>

            {{-- قسم تغيير كلمة المرور --}}
            <div class="relative bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 shadow-2xl overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-pink-500"></div>

                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-purple-600 flex items-center justify-center text-sm shadow-lg">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    تغيير كلمة المرور
                </h2>

                <form method="POST" action="/account/change-password" class="space-y-6">
                    @csrf

                    {{-- كلمة المرور الحالية --}}
                    <div class="space-y-2">
                        <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">كلمة السر الحالية</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-key text-slate-500 group-focus-within:text-purple-500 transition-colors"></i>
                            </div>
                            <input 
                                type="password" 
                                name="current_password" 
                                class="w-full bg-slate-950/50 border border-slate-700 rounded-xl pr-10 pl-4 py-3 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                            >
                        </div>
                        <x-form-error name="current_password" class="text-red-400 text-xs mt-1" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- كلمة المرور الجديدة --}}
                        <div class="space-y-2">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">كلمة السر الجديدة</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-unlock text-slate-500 group-focus-within:text-purple-500 transition-colors"></i>
                                </div>
                                <input 
                                    type="password" 
                                    name="new_password" 
                                    class="w-full bg-slate-950/50 border border-slate-700 rounded-xl pr-10 pl-4 py-3 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                                >
                            </div>
                            <x-form-error name="new_password" class="text-red-400 text-xs mt-1" />
                        </div>

                        {{-- تأكيد كلمة المرور --}}
                        <div class="space-y-2">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">تأكيد كلمة السر</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-check-double text-slate-500 group-focus-within:text-purple-500 transition-colors"></i>
                                </div>
                                <input 
                                    type="password" 
                                    name="new_password_confirmation" 
                                    class="w-full bg-slate-950/50 border border-slate-700 rounded-xl pr-10 pl-4 py-3 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                                >
                            </div>
                            <x-form-error name="new_password_confirmation" class="text-red-400 text-xs mt-1" />
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-white/5">
                        <button type="submit" 
                                class="bg-purple-600 hover:bg-purple-500 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-purple-900/20 transition hover:-translate-y-1">
                            تحديث كلمة المرور
                        </button>
                    </div>
                </form>
            </div>

            {{-- قسم منطقة الخطر (حذف الحساب) --}}
            <div class="relative bg-slate-900/60 backdrop-blur-xl border border-red-500/20 rounded-[2.5rem] p-8 shadow-2xl overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-600 to-red-400"></div>

                <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-red-600 flex items-center justify-center text-sm shadow-lg">
                        <i class="fa-solid fa-trash-can"></i>
                    </span>
                    منطقة الخطر
                </h2>

                <div class="bg-red-500/10 border border-red-500/10 rounded-xl p-4 mb-6 text-red-300 text-sm">
                    <i class="fa-solid fa-triangle-exclamation ml-2"></i>
                    تحذير: حذف الحساب إجراء نهائي لا يمكن التراجع عنه. سيتم فقدان جميع البيانات المرتبطة بحسابك.
                </div>

                <form method="POST" action="/account/delete" id="deleteAccountForm" class="space-y-6">
                    @csrf
                    @method('DELETE')

                    <div class="space-y-2">
                        <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">تأكيد كلمة المرور للحذف</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-fingerprint text-slate-500 group-focus-within:text-red-500 transition-colors"></i>
                            </div>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="w-full bg-slate-950/50 border border-slate-700 rounded-xl pr-10 pl-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500 transition"
                            >
                        </div>
                        <x-form-error name="password" class="text-red-400 text-xs mt-1" />
                    </div>

                    <div class="flex justify-end">
                        <button type="button" id="deleteAccountButton" 
                                class="bg-red-600 hover:bg-red-500 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-red-900/20 transition hover:-translate-y-1 flex items-center gap-2">
                            <i class="fa-solid fa-user-xmark"></i> حذف الحساب
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- مودال تأكيد الحذف --}}
    <div id="deleteAccountModal" class="fixed inset-0 z-[100] hidden">
        <div class="fixed inset-0 bg-slate-950/90 backdrop-blur-sm transition-opacity" id="cancelDeleteOverlay"></div>
        <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-slate-900 border border-white/10 rounded-[2rem] p-8 shadow-2xl text-center transform scale-100 transition-all">
                <div class="w-16 h-16 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 border border-red-500/20 animate-pulse">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <h3 class="text-2xl font-black text-white mb-2">هل أنت متأكد تماماً؟</h3>
                <p class="text-slate-400 mb-8 text-sm leading-relaxed">
                    أنت على وشك حذف حسابك بشكل دائم. لن تتمكن من استعادة أي بيانات بعد هذه الخطوة.
                </p>

                <div class="flex justify-center gap-3">
                    <button type="button" id="cancelDelete" 
                            class="px-6 py-3 rounded-xl text-slate-300 hover:bg-white/5 font-bold border border-white/5 transition">
                        إلغاء الأمر
                    </button>
                    <button type="button" id="confirmDelete" 
                            class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold shadow-lg shadow-red-900/30 transition transform hover:scale-105">
                        نعم، احذف حسابي
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript للتحكم في مودال الحذف --}}
    <script>
        const deleteAccountModal = document.getElementById('deleteAccountModal');
        const deleteAccountButton = document.getElementById('deleteAccountButton');
        const cancelDeleteButton = document.getElementById('cancelDelete');
        const cancelDeleteOverlay = document.getElementById('cancelDeleteOverlay');
        const confirmDeleteButton = document.getElementById('confirmDelete');
        const deleteAccountForm = document.getElementById('deleteAccountForm');

        function openModal() {
            deleteAccountModal.classList.remove('hidden');
        }

        function closeModal() {
            deleteAccountModal.classList.add('hidden');
        }

        if (deleteAccountButton) {
            deleteAccountButton.addEventListener('click', (e) => {
                const passwordInput = document.getElementById('password');
                if (passwordInput.value.trim() === '') {
                    passwordInput.focus();
                    passwordInput.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                    return;
                }
                openModal();
            });
        }

        if (cancelDeleteButton) cancelDeleteButton.addEventListener('click', closeModal);
        if (cancelDeleteOverlay) cancelDeleteOverlay.addEventListener('click', closeModal);

        if (confirmDeleteButton) {
            confirmDeleteButton.addEventListener('click', () => {
                deleteAccountForm.submit();
            });
        }
    </script>
@endsection