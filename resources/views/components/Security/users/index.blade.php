@extends('components.layout')

@section('title', 'إدارة المستخدمين')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 fade-in">
        <div>
            <h1 class="text-3xl font-black text-white mb-2">إدارة المستخدمين 👥</h1>
            <p class="text-slate-400">قائمة بجميع المستخدمين المسجلين وصلاحياتهم.</p>
        </div>
        
        <div class="flex items-center gap-3 mt-4 md:mt-0 w-full md:w-auto">
            <form method="GET" action="{{ route('users.index') }}" class="relative flex-grow md:flex-grow-0 group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث..." 
                    class="w-full md:w-64 bg-slate-900/50 border border-white/10 text-white text-sm rounded-xl pl-4 pr-10 py-3 focus:outline-none focus:border-blue-500 transition">
                <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-blue-500 transition">
                    <i class="fa-solid fa-search"></i>
                </button>
            </form>
            <a href="{{ route('sessions.index') }}" class="bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white px-4 py-3 rounded-xl border border-white/10 transition flex items-center gap-2 text-sm font-bold whitespace-nowrap">
                <i class="fa-solid fa-clock-rotate-left"></i> الجلسات
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-2xl mb-6 flex items-center gap-3 animate-fade-in font-bold">
            <i class="fa-solid fa-circle-check text-lg"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-2xl mb-6 flex items-center gap-3 animate-fade-in font-bold">
            <i class="fa-solid fa-circle-exclamation text-lg"></i> {{ session('error') }}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-2xl mb-6 flex flex-col gap-1 animate-fade-in text-sm font-bold">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> يوجد أخطاء في المدخلات، يرجى التحقق.
            </div>
        </div>
    @endif

    <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 rounded-[2rem] overflow-hidden shadow-2xl fade-in" style="animation-delay: 0.1s;">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-white/5 text-blue-400 uppercase tracking-wider text-xs font-bold border-b border-white/5">
                    <tr>
                        <th class="px-6 py-5">الاسم</th>
                        <th class="px-6 py-5">البريد الإلكتروني</th>
                        <th class="px-6 py-5">الدور</th>
                        <th class="px-6 py-5 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-slate-300 text-sm font-medium">
                    @forelse($users as $user)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-md">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="text-white">{{ $user->name }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-800 text-xs px-2 py-1 rounded border border-white/5">{{ $user->role->RoleName ?? 'بدون دور' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('users.edit', $user->id) }}" class="w-8 h-8 rounded-lg bg-yellow-500/10 text-yellow-400 hover:bg-yellow-500 hover:text-white flex items-center justify-center transition" title="تعديل">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button data-modal-toggle="changePasswordModal_{{ $user->id }}" class="w-8 h-8 rounded-lg bg-teal-500/10 text-teal-400 hover:bg-teal-500 hover:text-white flex items-center justify-center transition" title="تغيير الباسورد">
                                        <i class="fa-solid fa-key"></i>
                                    </button>
                                    <button data-modal-toggle="deleteUserModal_{{ $user->id }}" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white flex items-center justify-center transition" title="حذف">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-slate-500">لا يوجد مستخدمين</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-white/5 flex justify-between items-center text-xs text-slate-500">
            <div>عرض {{ $users->firstItem() }} إلى {{ $users->lastItem() }} من إجمالي {{ $users->total() }}</div>
            <div>{{ $users->links('pagination::tailwind') }}</div>
        </div>
    </div>

    @foreach($users as $user)
        
        <div id="deleteUserModal_{{ $user->id }}" class="fixed inset-0 z-[100] hidden">
            <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" data-modal-close="deleteUserModal_{{ $user->id }}"></div>
            <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-slate-900 border border-white/10 rounded-[2rem] shadow-2xl p-8 text-center">
                    <div class="w-14 h-14 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center text-2xl mx-auto mb-4 border border-red-500/20"><i class="fa-solid fa-user-xmark"></i></div>
                    <h3 class="text-lg font-bold text-white mb-2">حذف المستخدم؟</h3>
                    <p class="text-slate-400 mb-6 text-sm">سيتم حذف حساب "{{ $user->name }}" نهائياً.</p>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="flex justify-center gap-3">
                        @csrf @method('DELETE')
                        <button type="button" data-modal-close="deleteUserModal_{{ $user->id }}" class="px-5 py-2 rounded-xl text-slate-300 hover:bg-white/5 font-bold text-sm border border-white/5">إلغاء</button>
                        <button type="submit" class="px-6 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold text-sm shadow-lg">حذف</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="changePasswordModal_{{ $user->id }}" class="modal-container fixed inset-0 z-[100] hidden">
            <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" data-modal-close="changePasswordModal_{{ $user->id }}"></div>
            <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-slate-900 border border-white/10 rounded-[2rem] shadow-2xl p-8">
                    
                    <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-lock text-teal-500"></i> تغيير كلمة المرور للمستخدم: <span class="text-teal-400">{{ $user->name }}</span>
                    </h3>
                    
                    <form action="{{ route('users.change-password', $user->id) }}" method="POST">
                        @csrf @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-slate-400 text-xs font-bold mb-2">كلمة المرور الجديدة</label>
                            <input type="password" name="new_password" 
                                class="w-full bg-slate-950/50 border rounded-xl px-4 py-3 text-white focus:outline-none transition 
                                {{ $errors->has('new_password') ? 'border-red-500 focus:border-red-500 has-error' : 'border-slate-700 focus:border-teal-500' }}" required>
                            
                            @error('new_password')
                                <p class="text-red-400 text-xs mt-1 font-bold"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-slate-400 text-xs font-bold mb-2">تأكيد كلمة المرور</label>
                            <input type="password" name="new_password_confirmation" 
                                class="w-full bg-slate-950/50 border rounded-xl px-4 py-3 text-white focus:outline-none transition
                                {{ $errors->has('new_password_confirmation') ? 'border-red-500 focus:border-red-500' : 'border-slate-700 focus:border-teal-500' }}" required>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" data-modal-close="changePasswordModal_{{ $user->id }}" class="px-5 py-2 rounded-xl text-slate-300 hover:bg-white/5 font-bold text-sm border border-white/5">إلغاء</button>
                            <button type="submit" class="px-6 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold text-sm shadow-lg">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        // دالة لفتح وإغلاق المودلز
        function toggleModal(modalId, action) {
            const modal = document.getElementById(modalId);
            if (modal) {
                if (action === 'open') modal.classList.remove('hidden');
                else modal.classList.add('hidden');
            }
        }

        // Event Listeners للأزرار
        document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
            btn.addEventListener('click', () => toggleModal(btn.dataset.modalToggle, 'open'));
        });
        
        document.querySelectorAll('[data-modal-close]').forEach(btn => {
            btn.addEventListener('click', () => {
                const modalId = btn.dataset.modalClose || btn.closest('[id]').id;
                toggleModal(modalId, 'close');
            });
        });

        // ==========================================
        //  AUTO-OPEN MODAL ON ERROR (The Fix)
        // ==========================================
        document.addEventListener("DOMContentLoaded", function() {
            // نبحث عن أي حقل إدخال يحتوي على الكلاس 'has-error' الذي أضفناه في الـ Blade
            const errorInputs = document.querySelectorAll('.has-error');
            
            if (errorInputs.length > 0) {
                // نأخذ أول عنصر فيه خطأ ونبحث عن المودال الأب له
                const modal = errorInputs[0].closest('.modal-container'); // تأكدنا من إضافة كلاس modal-container للمودال
                if (modal) {
                    modal.classList.remove('hidden'); // نفتح المودال تلقائياً
                }
            }
        });
    </script>

@endsection