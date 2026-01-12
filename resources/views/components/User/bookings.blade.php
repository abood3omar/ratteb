@extends('components.layout')

@section('title', 'حجوزاتي')

@section('content')

    <div class="max-w-7xl mx-auto px-4 py-8" x-data="{ currentTab: 'all' }">
        
        {{-- Header & Tabs --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 border-b border-white/10 pb-6 fade-in">
            <div>
                <h1 class="text-3xl font-black text-white mb-2">حجوزاتي 📅</h1>
                <p class="text-slate-400">إدارة ومتابعة جميع طلباتك في مكان واحد.</p>
            </div>

            {{-- Tabs Navigation --}}
            <div class="flex bg-slate-900 p-1 rounded-xl border border-white/10 mt-4 md:mt-0">
                <button @click="currentTab = 'all'" 
                        :class="currentTab === 'all' ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:text-white'"
                        class="px-4 py-2 rounded-lg text-sm font-bold transition-all">الكل</button>
                <button @click="currentTab = 'event'" 
                        :class="currentTab === 'event' ? 'bg-purple-600 text-white shadow-lg' : 'text-slate-400 hover:text-white'"
                        class="px-4 py-2 rounded-lg text-sm font-bold transition-all">المناسبات</button>
                <button @click="currentTab = 'package'" 
                        :class="currentTab === 'package' ? 'bg-pink-600 text-white shadow-lg' : 'text-slate-400 hover:text-white'"
                        class="px-4 py-2 rounded-lg text-sm font-bold transition-all">الباقات</button>
                <button @click="currentTab = 'service'" 
                        :class="currentTab === 'service' ? 'bg-emerald-600 text-white shadow-lg' : 'text-slate-400 hover:text-white'"
                        class="px-4 py-2 rounded-lg text-sm font-bold transition-all">الخدمات</button>
            </div>
        </div>

        {{-- Bookings List --}}
        <div class="grid grid-cols-1 gap-6 fade-in">
            @forelse($allBookings as $booking)
                @php
                    // إعداد النصوص والألوان حسب النوع
                    $typeLabel = match($booking->type) {
                        'event'   => 'تخطيط مناسبة',
                        'package' => 'باقة جاهزة',
                        'service' => 'خدمة فردية',
                    };
                    $typeColor = match($booking->type) {
                        'event'   => 'purple',
                        'package' => 'pink',
                        'service' => 'emerald',
                    };
                    
                    // إعداد حالات الحجز
                    $statusColors = [
                        'pending'   => ['bg' => 'bg-yellow-500/10', 'text' => 'text-yellow-500', 'label' => 'قيد المراجعة'],
                        'approved'  => ['bg' => 'bg-blue-500/10',   'text' => 'text-blue-500',   'label' => 'بانتظار الدفع'],
                        'paid'      => ['bg' => 'bg-green-500/10',  'text' => 'text-green-500',  'label' => 'مدفوع ومؤكد'],
                        'rejected'  => ['bg' => 'bg-red-500/10',    'text' => 'text-red-500',    'label' => 'مرفوض'],
                        'cancelled' => ['bg' => 'bg-gray-500/10',   'text' => 'text-gray-500',   'label' => 'ملغى'],
                    ];
                    
                    // تعديل الحالة إذا تم رفع الوصل ولم يتم التأكيد بعد
                    $status = $statusColors[$booking->status] ?? $statusColors['pending'];
                    if($booking->status == 'approved' && $booking->payment_receipt) {
                        $status = ['bg' => 'bg-orange-500/10', 'text' => 'text-orange-500', 'label' => 'جاري التحقق من الوصل'];
                    }

                    // استخراج المحتويات الداخلية (خدمات) والصورة الرئيسية
                    $innerItems = collect();
                    $mainImage  = null;

                    if ($booking->type === 'package' && isset($booking->package)) {
                        $innerItems = $booking->package->services;
                        $mainImage  = $booking->package->image;
                    } elseif ($booking->type === 'event' && isset($booking->items)) {
                        $innerItems = $booking->items->map(fn($item) => $item->service);
                    } elseif ($booking->type === 'service' && isset($booking->service)) {
                        $innerItems = collect([$booking->service]);
                        $mainImage  = $booking->service->image;
                    }
                @endphp

                <div x-show="currentTab === 'all' || currentTab === '{{ $booking->type }}'"
                     x-transition.opacity.duration.300ms
                     x-data="{ openDetails: false }"
                     class="bg-slate-900 border border-white/5 rounded-3xl p-6 hover:border-{{ $typeColor }}-500/30 transition-all duration-300 group relative overflow-hidden">

                    {{-- شريط جانبي ملون --}}
                    <div class="absolute top-0 right-0 w-1.5 h-full bg-{{ $typeColor }}-500"></div>

                    <div class="flex flex-col md:flex-row gap-6 items-center">
                        
                        {{-- الصورة --}}
                        <div class="w-full md:w-32 h-32 rounded-2xl bg-slate-800 overflow-hidden shrink-0 border border-white/10 relative">
                            @if($mainImage)
                                <img src="{{ asset('storage/' . $mainImage) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-{{ $typeColor }}-500"><i class="fa-solid fa-layer-group text-3xl"></i></div>
                            @endif
                        </div>

                        {{-- المعلومات --}}
                        <div class="flex-grow w-full">
                            <div class="flex flex-wrap justify-between items-start mb-2 gap-4">
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="text-[10px] font-bold px-2 py-1 rounded border border-{{ $typeColor }}-500/20 text-{{ $typeColor }}-400 bg-{{ $typeColor }}-500/5">{{ $typeLabel }}</span>
                                        <span class="text-xs text-slate-500 font-mono">#ID-{{ $booking->id }}</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-white">{{ $booking->display_name }}</h3>
                                    <p class="text-sm text-slate-400 mt-1">
                                        <i class="fa-regular fa-calendar ml-1"></i> {{ \Carbon\Carbon::parse($booking->date ?? $booking->event_date)->format('Y-m-d') }}
                                        @if($booking->event_time) | <i class="fa-regular fa-clock ml-1"></i> {{ \Carbon\Carbon::parse($booking->event_time)->format('h:i A') }} @endif
                                    </p>
                                </div>

                                <div class="text-left flex flex-col items-end">
                                    <span class="{{ $status['bg'] }} {{ $status['text'] }} px-3 py-1 rounded-lg text-xs font-bold mb-1 block w-fit">{{ $status['label'] }}</span>
                                    <span class="text-2xl font-black text-white block">{{ (int)$booking->total_price }} <span class="text-xs text-slate-500 font-normal">د.أ</span></span>
                                </div>
                            </div>

                            {{-- أزرار التحكم --}}
                            <div class="flex gap-3 mt-4 pt-4 border-t border-white/5">
                                <button @click="openDetails = true" class="flex-1 md:flex-none px-6 py-2 bg-white/5 hover:bg-white/10 text-white rounded-xl text-xs font-bold transition border border-white/5">
                                    التفاصيل
                                </button>

                                {{-- زر الدفع (يظهر عند الموافقة وعدم رفع الوصل بعد) --}}
                                @if($booking->status == 'approved' && !$booking->payment_receipt)
                                    <button @click="$dispatch('open-payment-modal', { id: '{{ $booking->id }}', type: '{{ $booking->type }}', price: '{{ $booking->total_price }}' })" 
                                            class="px-6 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-lg shadow-emerald-900/20">
                                        دفع العربون 💸
                                    </button>
                                @endif

                                {{-- زر الإلغاء (فقط في حالة Pending) --}}
                                @if($booking->status === 'pending')
                                    <form action="{{ route('bookings.cancel') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من إلغاء هذا الحجز؟');">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $booking->id }}">
                                        <input type="hidden" name="type" value="{{ $booking->type }}">
                                        <button type="submit" class="px-6 py-2 text-red-400 hover:bg-red-500/10 rounded-xl text-xs font-bold transition">إلغاء</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- مودال التفاصيل (داخل كل عنصر) --}}
                    <template x-teleport="body">
                        <div x-show="openDetails" x-transition.opacity class="fixed inset-0 z-[999] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
                            <div @click.away="openDetails = false" class="bg-slate-900 border border-white/10 rounded-3xl w-full max-w-2xl p-0 shadow-2xl flex flex-col max-h-[90vh]">
                                
                                <div class="p-6 border-b border-white/10 bg-slate-950 flex justify-between items-center">
                                    <h2 class="text-xl font-bold text-white">تفاصيل الحجز #{{ $booking->id }}</h2>
                                    <button @click="openDetails = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
                                </div>

                                <div class="p-6 overflow-y-auto custom-scrollbar space-y-6">
                                    {{-- بيانات التوصيل والمعازيم --}}
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-white/5 p-3 rounded-xl">
                                            <span class="text-xs text-slate-400 block">طريقة التنفيذ</span>
                                            <span class="text-sm font-bold text-white">{{ $booking->delivery_type == 'delivery' ? 'توصيل للموقع' : 'استلام / في القاعة' }}</span>
                                        </div>
                                        <div class="bg-white/5 p-3 rounded-xl">
                                            <span class="text-xs text-slate-400 block">عدد المعازيم</span>
                                            <span class="text-sm font-bold text-white">{{ $booking->guest_count ?? '-' }}</span>
                                        </div>
                                        @if($booking->address)
                                        <div class="col-span-2 bg-white/5 p-3 rounded-xl">
                                            <span class="text-xs text-slate-400 block">العنوان</span>
                                            <span class="text-sm font-bold text-white">{{ $booking->address }}</span>
                                        </div>
                                        @endif
                                    </div>

                                    {{-- قائمة الخدمات الداخلية --}}
                                    @if($innerItems->isNotEmpty())
                                        <div>
                                            <h3 class="text-sm font-bold text-blue-400 uppercase tracking-wider mb-3 border-b border-white/5 pb-2">
                                                محتويات الحجز ({{ $innerItems->count() }})
                                            </h3>
                                            <div class="space-y-3">
                                                @foreach($innerItems as $item)
                                                    <div class="bg-slate-950 border border-white/5 rounded-xl p-3 flex items-center gap-3">
                                                        <div class="w-10 h-10 rounded-lg bg-slate-800 overflow-hidden shrink-0">
                                                            @if($item?->image) <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover"> @else <div class="w-full h-full flex items-center justify-center text-slate-600"><i class="fa-solid fa-cube"></i></div> @endif
                                                        </div>
                                                        <div class="flex-grow">
                                                            <h4 class="text-white text-sm font-bold">{{ $item?->name_ar ?? 'خدمة' }}</h4>
                                                            <p class="text-[10px] text-slate-500">{{ $item?->provider?->name_ar ?? '' }}</p>
                                                        </div>
                                                        {{-- سعر الخدمة الفردي --}}
                                                        <span class="text-[10px] bg-white/5 px-2 py-1 rounded text-slate-300">{{ (int)$item?->price }} د.أ</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- الملاحظات --}}
                                    @if($booking->notes || $booking->extra_details)
                                        <div class="bg-yellow-500/5 border border-yellow-500/10 p-4 rounded-xl">
                                            <h4 class="text-yellow-500 text-xs font-bold mb-1">ملاحظات وتفاصيل إضافية</h4>
                                            <p class="text-slate-300 text-sm">{!! nl2br(e($booking->notes)) !!} <br> {!! nl2br(e($booking->extra_details)) !!}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @empty
                <div class="text-center py-20 bg-slate-900/50 rounded-3xl border border-dashed border-white/10">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-500 text-2xl"><i class="fa-solid fa-clipboard-list"></i></div>
                    <h3 class="text-xl font-bold text-white">لا يوجد حجوزات</h3>
                    <p class="text-slate-400 text-sm mt-2 mb-6">لم تقم بإجراء أي حجوزات حتى الآن.</p>
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('front.planner.index') }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-sm font-bold transition">تخطيط مناسبة</a>
                        <a href="{{ route('front.packages.index') }}" class="px-6 py-2 bg-white/5 hover:bg-white/10 text-white rounded-xl text-sm font-bold transition border border-white/10">تصفح الباقات</a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- مودال الدفع (مشترك للصفحة كلها) --}}
        <div x-data="{ show: false, id: '', type: '', price: '' }" 
             @open-payment-modal.window="show = true; id = $event.detail.id; type = $event.detail.type; price = $event.detail.price"
             x-show="show" x-transition.opacity style="display: none;" 
             class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
            
            <div @click.away="show = false" class="bg-slate-900 border border-white/10 rounded-3xl w-full max-w-md p-8 shadow-2xl text-center relative">
                <button @click="show = false" class="absolute top-4 left-4 text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>

                <div class="w-16 h-16 bg-blue-600/20 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 border border-blue-500/30"><i class="fa-solid fa-file-invoice-dollar text-2xl"></i></div>
                <h3 class="text-2xl font-black text-white mb-2">دفع العربون (20%)</h3>
                <p class="text-slate-400 text-sm mb-6">لتثبيت الحجز، يرجى تحويل قيمة العربون ورفع صورة الوصل.</p>

                <div class="flex justify-between items-center bg-slate-950 p-4 rounded-xl border border-white/5 mb-6">
                    <div class="text-right"><span class="text-xs text-slate-500 block">العربون المطلوب</span><span class="text-xl font-bold text-white" x-text="(price * 0.20).toFixed(0) + ' د.أ'"></span></div>
                    <div class="text-left border-r border-white/10 pr-4"><span class="text-xs text-slate-500 block">رقم كليك (CliQ)</span><span class="text-sm font-mono text-blue-400 font-bold select-all">NASAQQ</span></div>
                </div>

                <form action="{{ route('bookings.upload_receipt') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="id" :value="id">
                    <input type="hidden" name="type" :value="type">
                    <div class="relative group">
                        <input type="file" name="receipt" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                        <div class="bg-white/5 border-2 border-dashed border-white/10 rounded-xl p-6 transition group-hover:border-blue-500/50 group-hover:bg-blue-500/5">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-500 mb-2 group-hover:text-blue-400 transition"></i>
                            <p class="text-sm text-slate-300 font-bold">اضغط لرفع صورة الوصل</p>
                            <p class="text-xs text-slate-500 mt-1">PNG, JPG (Max 2MB)</p>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold transition shadow-lg">إرسال الوصل وتأكيد الحجز</button>
                </form>
            </div>
        </div>

    </div>

@endsection