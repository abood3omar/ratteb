@extends('components.layout')

@section('title', 'إدارة الحجوزات')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-black text-white mb-8">إدارة الحجوزات 👮‍♂️</h1>

    <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead class="bg-slate-950 text-slate-400 uppercase font-bold border-b border-white/5">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">العميل</th>
                        <th class="px-6 py-4">النوع</th>
                        <th class="px-6 py-4">التفاصيل</th>
                        <th class="px-6 py-4">التاريخ</th>
                        <th class="px-6 py-4">العربون / السعر</th>
                        <th class="px-6 py-4">الحالة</th>
                        <th class="px-6 py-4">الإجراءات</th>
                    </tr>
                </thead>
<tbody class="divide-y divide-slate-800 text-slate-300">
    @foreach($bookings as $booking)
        {{-- 
            تعريف البيانات لكل سطر:
            showModal: للتحكم بظهور المودال
            isTarget: هل هذا هو الحجز المطلوب من الإشعار؟
        --}}
        <tr x-data="{ 
                showModal: false, 
                isTarget: {{ $targetBookingId == $booking->id ? 'true' : 'false' }} 
            }"
            {{-- إذا كان هو المطلوب: انزل لعنده وافتح المودال --}}
            x-init="if(isTarget) { 
                $el.scrollIntoView({behavior: 'smooth', block: 'center'}); 
                setTimeout(() => showModal = true, 500); 
            }"
            :class="isTarget ? 'bg-blue-900/20 border-l-4 border-blue-500' : 'hover:bg-slate-800/50 transition'"
            class="transition-all duration-500"
        >
            <td class="px-6 py-4 font-mono">{{ $booking->id }}</td>
<td class="px-6 py-4">
    <div class="flex flex-col items-start gap-1.5">
        {{-- الاسم --}}
        <span class="font-bold text-white text-base">
            {{ $booking->user->name ?? 'زائر' }}
        </span>

        {{-- أزرار التواصل --}}
        @if($booking->user)
            <div class="flex items-center gap-2">
                
                {{-- زر واتساب --}}
                @if($booking->user->MobileNumber)
                    {{-- ملاحظة: دالة str_replace عشان تنظف الرقم من أي فواصل أو زائد ليعمل الرابط --}}
                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $booking->user->MobileNumber) }}" 
                       target="_blank" 
                       class="group flex items-center gap-1.5 px-2 py-1 rounded-md bg-green-500/10 border border-green-500/20 hover:bg-green-600 hover:border-green-600 transition-all duration-300"
                       title="تواصل عبر واتساب">
                        <i class="fa-brands fa-whatsapp text-green-500 group-hover:text-white text-xs"></i>
                        <span class="text-[10px] font-bold text-green-500 group-hover:text-white">واتس</span>
                    </a>
                @endif

                {{-- زر إيميل --}}
                @if($booking->user->email)
                    <a href="mailto:{{ $booking->user->email }}" 
                       class="group flex items-center gap-1.5 px-2 py-1 rounded-md bg-blue-500/10 border border-blue-500/20 hover:bg-blue-600 hover:border-blue-600 transition-all duration-300"
                       title="إرسال بريد إلكتروني">
                        <i class="fa-solid fa-envelope text-blue-500 group-hover:text-white text-xs"></i>
                        <span class="text-[10px] font-bold text-blue-500 group-hover:text-white">إيميل</span>
                    </a>
                @endif
                
            </div>
        @endif
    </div>
</td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 rounded bg-white/5 border border-white/10 text-xs">
                    {{ $booking->type == 'package' ? 'باقة' : ($booking->type == 'event' ? 'تخطيط' : 'خدمة') }}
                </span>
            </td>
            <td class="px-6 py-4">
                @if($booking->type == 'package') {{ $booking->package->name_ar ?? '-' }}
                @elseif($booking->type == 'service') {{ $booking->service->name_ar ?? '-' }}
                @else {{ $booking->occasion_type }} @endif
            </td>
            <td class="px-6 py-4">{{ $booking->date ?? $booking->event_date }}</td>
            <td class="px-6 py-4">
                @if($booking->deposit_amount)
                    <span class="text-emerald-400 block">{{ (int)$booking->deposit_amount }} د.أ (عربون)</span>
                @endif
                <span class="text-xs text-slate-500">من {{ (int)$booking->total_price }}</span>
            </td>
            <td class="px-6 py-4">
                @php
                    $sClass = match($booking->status) {
                        'pending' => 'text-yellow-500 bg-yellow-500/10',
                        'approved' => 'text-blue-500 bg-blue-500/10',
                        'paid' => 'text-green-500 bg-green-500/10',
                        default => 'text-gray-500 bg-gray-500/10'
                    };
                @endphp
                <span class="px-2 py-1 rounded text-xs font-bold {{ $sClass }}">{{ $booking->status }}</span>
            </td>
            
            {{-- عمود الإجراءات --}}
            <td class="px-6 py-4 flex items-center gap-2">
                
                {{-- زر عرض التفاصيل (المودال) --}}
                <button @click="showModal = true" class="w-8 h-8 rounded-full bg-slate-700 hover:bg-slate-600 flex items-center justify-center text-white transition" title="التفاصيل">
                    <i class="fa-solid fa-eye"></i>
                </button>

                {{-- أزرار القبول والرفض (كما هي) --}}
                @if($booking->status == 'pending')
                    <form action="{{ route('admin.bookings.update') }}" method="POST">
                        @csrf <input type="hidden" name="id" value="{{ $booking->id }}"><input type="hidden" name="type" value="{{ $booking->type }}">
                        <input type="hidden" name="status" value="approved">
                        <button class="w-8 h-8 rounded-full bg-green-600 hover:bg-green-500 flex items-center justify-center text-white" title="موافقة"><i class="fa-solid fa-check"></i></button>
                    </form>
                    <form action="{{ route('admin.bookings.update') }}" method="POST">
                        @csrf <input type="hidden" name="id" value="{{ $booking->id }}"><input type="hidden" name="type" value="{{ $booking->type }}">
                        <input type="hidden" name="status" value="rejected">
                        <button class="w-8 h-8 rounded-full bg-red-600 hover:bg-red-500 flex items-center justify-center text-white" title="رفض"><i class="fa-solid fa-xmark"></i></button>
                    </form>
                @endif

                {{-- ======================== --}}
                {{--        المودال هنا       --}}
                {{-- ======================== --}}
                <template x-teleport="body">
                    <div x-show="showModal" x-transition.opacity style="display: none;" 
                         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
                        
                        <div @click.away="showModal = false" 
                             class="bg-slate-900 border border-slate-700 rounded-2xl w-full max-w-2xl shadow-2xl relative overflow-hidden animate-scale-up">
                            
                            {{-- رأس المودال --}}
                            <div class="p-6 border-b border-white/10 flex justify-between items-center bg-slate-950">
                                <h3 class="text-xl font-bold text-white">تفاصيل الحجز #{{ $booking->id }}</h3>
                                <button @click="showModal = false" class="text-slate-400 hover:text-white transition"><i class="fa-solid fa-xmark text-xl"></i></button>
                            </div>

                            {{-- محتوى المودال --}}
                            <div class="p-6 overflow-y-auto max-h-[70vh] text-right" dir="rtl">
                                <div class="grid grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label class="text-xs text-slate-500 block mb-1">العميل</label>
                                        <p class="text-white font-bold">{{ $booking->user->name ?? 'غير مسجل' }}</p>
                                        <p class="text-slate-400 text-sm">{{ $booking->user->email ?? '' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-slate-500 block mb-1">التاريخ والوقت</label>
                                        <p class="text-white font-bold">{{ $booking->date ?? $booking->event_date }}</p>
                                        <p class="text-slate-400 text-sm">{{ $booking->time ?? $booking->event_time ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- تفاصيل إضافية --}}
                                <div class="bg-white/5 rounded-xl p-4 mb-4 border border-white/5">
                                    <h4 class="text-blue-400 text-sm font-bold mb-3 border-b border-white/5 pb-2">معلومات إضافية</h4>
                                    <div class="grid grid-cols-1 gap-3 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-slate-400">عدد المعازيم:</span>
                                            <span class="text-white">{{ $booking->guest_count ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-slate-400">العنوان:</span>
                                            <span class="text-white">{{ $booking->address ?? 'استلام من الموقع' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-slate-400">ملاحظات:</span>
                                            <span class="text-white">{{ $booking->notes ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- صورة الوصل إذا وجدت --}}
                                @if($booking->payment_receipt)
                                    <div class="mt-4">
                                        <label class="text-xs text-slate-500 block mb-2">وصل الدفع</label>
                                        <a href="{{ asset('storage/'.$booking->payment_receipt) }}" target="_blank" class="block rounded-xl overflow-hidden border border-white/10 hover:border-blue-500 transition relative group">
                                            <img src="{{ asset('storage/'.$booking->payment_receipt) }}" class="w-full h-48 object-cover">
                                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                                <span class="text-white font-bold"><i class="fa-solid fa-expand ml-2"></i>عرض الصورة كاملة</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- أسفل المودال --}}
                            <div class="p-4 bg-slate-950 border-t border-white/10 flex justify-end gap-3">
                                <button @click="showModal = false" class="px-5 py-2 rounded-xl text-slate-300 hover:bg-white/5 transition font-bold">إغلاق</button>
                                
                                {{-- إذا الحالة Pending، نعرض أزرار التحكم داخل المودال أيضاً --}}
                                @if($booking->status == 'pending')
                                    <form action="{{ route('admin.bookings.update') }}" method="POST">
                                        @csrf <input type="hidden" name="id" value="{{ $booking->id }}"><input type="hidden" name="type" value="{{ $booking->type }}">
                                        <input type="hidden" name="status" value="approved">
                                        <button class="px-6 py-2 rounded-xl bg-green-600 hover:bg-green-500 text-white font-bold shadow-lg">قبول الحجز</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </template>

            </td>
        </tr>
    @endforeach
</tbody>
            </table>
        </div>
    </div>
</div>
@endsection