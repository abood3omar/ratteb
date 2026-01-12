@extends('components.layout')

@section('title', 'تخطيط ' . $occasion->name_ar)

@section('content')
    @php
        // تحضير مصفوفة للبحث السريع عن تفاصيل الخدمات داخل JavaScript
        $servicesLookup = [];
        foreach ($occasion->categories as $cat) {
            foreach ($cat->providers as $prov) {
                foreach ($prov->services as $srv) {
                    $servicesLookup[$srv->id] = [
                        'name'        => $srv->name_ar,
                        'description' => $srv->description,
                        'capacity'    => $srv->capacity,
                        'price'       => (int)$srv->price,
                        'image'       => $srv->image ? asset('storage/' . $srv->image) : null,
                        'provider'    => $prov->name_ar,
                        'cat_name'    => $cat->name_ar
                    ];
                }
            }
        }
    @endphp

    {{-- تنسيق خاص لإصلاح ألوان الحقول عند الملء التلقائي في المتصفح --}}
    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active{
            -webkit-text-fill-color: white !important;
            -webkit-box-shadow: 0 0 0 30px #020617 inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        /* لتلوين أيقونة التقويم والساعة بالأبيض */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }
    </style>

    <div class="min-h-screen pb-24" 
         x-data="{ 
             // --- متغيرات الحالة ---
             step: 0, 
             selections: {}, 
             total: 0,
             date: '',
             time: '', 
             guest_count: '', 
             delivery_type: 'pickup', 
             address: '', 
             extra_details: '', 
             isLoading: false,
             
             // --- بيانات ثابتة من السيرفر ---
             allServices: {{ json_encode($servicesLookup) }},
             isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},

loginUrl: '{{ route('login') }}?redirect_to=' + encodeURIComponent(window.location.href),
             storageKey: 'booking_draft_{{ $occasion->slug }}', // مفتاح تخزين فريد لكل مناسبة

             // --- متغيرات المودال ---
             showModal: false,
             modalService: {},

             // --- دالة التهيئة (تعمل عند تحميل الصفحة) ---
             init() {
                 this.restoreState();
                 
                 // مراقبة التغييرات للحفظ التلقائي (اختياري لتحسين التجربة)
                 this.$watch('selections', () => this.saveState());
                 this.$watch('date', () => this.saveState());
                 this.$watch('time', () => this.saveState());
             },

             // --- دالة استرجاع البيانات من localStorage ---
             restoreState() {
                 const savedData = localStorage.getItem(this.storageKey);
                 if (savedData) {
                     try {
                         const parsed = JSON.parse(savedData);
                         this.selections = parsed.selections || {};
                         this.date = parsed.date || '';
                         this.time = parsed.time || '';
                         this.guest_count = parsed.guest_count || '';
                         this.delivery_type = parsed.delivery_type || 'pickup';
                         this.address = parsed.address || '';
                         this.extra_details = parsed.extra_details || '';
                         
                         // استعادة الخطوة (اختياري: نعيده لآخر خطوة وصل لها)
                         if (parsed.step !== undefined) {
                            this.step = parsed.step;
                         }

                         this.calculateTotal();
                         console.log('تم استرجاع مسودة الحجز.');
                     } catch (e) {
                         console.error('خطأ في قراءة البيانات المحفوظة', e);
                         localStorage.removeItem(this.storageKey);
                     }
                 }
             },

             // --- دالة حفظ البيانات في localStorage ---
             saveState() {
                 const data = {
                     selections: this.selections,
                     date: this.date,
                     time: this.time,
                     guest_count: this.guest_count,
                     delivery_type: this.delivery_type,
                     address: this.address,
                     extra_details: this.extra_details,
                     step: this.step
                 };
                 localStorage.setItem(this.storageKey, JSON.stringify(data));
             },

             // --- دالة مسح البيانات (بعد النجاح) ---
             clearState() {
                 localStorage.removeItem(this.storageKey);
                 this.selections = {};
                 this.date = '';
                 this.time = '';
                 this.total = 0;
                 this.step = 0;
             },

             // --- دوال التحكم في الخدمات والسعر ---
             openModal(serviceId) {
                 this.modalService = this.allServices[serviceId] || {};
                 this.showModal = true;
             },

             selectService(catId, serviceId) {
                 this.selections[catId] = serviceId;
                 this.calculateTotal();
                 this.saveState();
             },
             
             calculateTotal() {
                 let sum = 0;
                 for (const [catId, serviceId] of Object.entries(this.selections)) {
                     if (serviceId && this.allServices[serviceId]) {
                         sum += this.allServices[serviceId].price;
                     }
                 }
                 this.total = sum;
             },

             // --- دالة إرسال الحجز ---
             async submitBooking() {
                 if (!this.date || !this.time) {
                     alert('يرجى تحديد التاريخ والوقت أولاً');
                     return;
                 }
                 if (this.delivery_type === 'delivery' && !this.address.trim()) {
                     alert('يرجى إدخال عنوان التوصيل');
                     return;
                 }

                 this.isLoading = true;

                 try {
                     const response = await fetch('{{ route('front.planner.store') }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                             'Accept': 'application/json'
                         },
                         body: JSON.stringify({
                             occasion_slug: '{{ $occasion->slug }}',
                             event_date: this.date,
                             event_time: this.time,
                             selections: this.selections,
                             guest_count: this.guest_count,
                             delivery_type: this.delivery_type,
                             address: this.address,
                             extra_details: this.extra_details
                         })
                     });

                     const result = await response.json();

                     if (result.success) {
                         this.clearState(); // تنظيف الذاكرة بعد النجاح
                         window.location.href = result.redirect_url;
                     } else {
                         if (result.redirect_url) {
                            // في حال طلب السيرفر إعادة التوجيه (مثلاً انتهت الجلسة)
                            window.location.href = result.redirect_url;
                         } else {
                            alert(result.message || 'حدث خطأ أثناء الحجز');
                            this.isLoading = false;
                         }
                     }
                 } catch (error) {
                     console.error('Error:', error);
                     alert('فشل الاتصال بالسيرفر');
                     this.isLoading = false;
                 }
             },

             nextStep() {
                 if (this.step < {{ $occasion->categories->count() }}) {
                     this.step++;
                     window.scrollTo({ top: 0, behavior: 'smooth' });
                     this.saveState();
                 }
             },
             prevStep() {
                 if (this.step > 0) {
                     this.step--;
                     window.scrollTo({ top: 0, behavior: 'smooth' });
                 }
             }
         }">

        {{-- Header Section --}}
        <div class="border-b border-white/5 py-10 mb-8 relative">
            <div class="container mx-auto px-4 relative z-10 flex flex-col items-center text-center">
                <h1 class="text-3xl md:text-4xl font-black text-white mb-2">تخطيط {{ $occasion->name_ar }}</h1>
                <p class="text-slate-400 text-sm max-w-lg mx-auto">صمم مناسبتك خطوة بخطوة.</p>
            </div>
        </div>

        <div class="container mx-auto px-4 flex flex-col lg:flex-row gap-8">
            {{-- Sidebar: Navigation Steps (Desktop Only) --}}
            <aside class="w-full lg:w-1/4 hidden lg:block">
                <div class="sticky top-24 bg-slate-900/50 border border-white/5 rounded-2xl p-6">
                    <h3 class="text-white font-bold mb-6 text-sm uppercase tracking-wider text-slate-500">مراحل التجهيز</h3>
                    <div class="relative space-y-0">
                        <div class="absolute right-3.5 top-2 bottom-2 w-0.5 bg-slate-800"></div>
                        @foreach($occasion->categories as $index => $category)
                            <div class="relative flex items-center gap-4 py-3 cursor-pointer group" @click="step >= {{ $index }} ? step = {{ $index }} : null">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold z-10 border-2 transition-all duration-300"
                                     :class="{ 
                                         'bg-blue-600 border-blue-600 text-white': step > {{ $index }} || selections[{{ $category->id }}],
                                         'bg-slate-900 border-blue-500 text-blue-500 ring-4 ring-blue-500/20': step === {{ $index }},
                                         'bg-slate-900 border-slate-700 text-slate-500': step < {{ $index }} && !selections[{{ $category->id }}]
                                     }">
                                    <span x-show="selections[{{ $category->id }}]"><i class="fa-solid fa-check"></i></span>
                                    <span x-show="!selections[{{ $category->id }}]">{{ $index + 1 }}</span>
                                </div>
                                <p class="text-sm font-bold transition-colors" 
                                   :class="step === {{ $index }} ? 'text-white' : 'text-slate-400 group-hover:text-slate-300'">
                                    {{ $category->name_ar }}
                                </p>
                            </div>
                        @endforeach
                        <div class="relative flex items-center gap-4 py-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold z-10 border-2 transition-all duration-300"
                                 :class="step === {{ $occasion->categories->count() }} ? 'bg-green-600 border-green-600 text-white ring-4 ring-green-500/20' : 'bg-slate-900 border-slate-700 text-slate-500'">
                                <i class="fa-solid fa-flag-checkered"></i>
                            </div>
                            <p class="text-sm font-bold transition-colors" 
                               :class="step === {{ $occasion->categories->count() }} ? 'text-white' : 'text-slate-400'">
                                المراجعة والحجز
                            </p>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Main Content Area --}}
            <main class="w-full lg:w-3/4 min-h-[500px]">
                
                {{-- Loop Through Categories (Steps) --}}
                @foreach($occasion->categories as $index => $category)
                    <div x-show="step === {{ $index }}" x-transition.opacity.duration.300ms style="display: none;">
                        <div class="flex justify-between items-end mb-6">
                            <div>
                                <span class="text-blue-500 text-xs font-bold uppercase tracking-widest">الخطوة {{ $index + 1 }}</span>
                                <h2 class="text-3xl font-black text-white mt-1">اختر {{ $category->name_ar }}</h2>
                            </div>
                            <button @click="selections[{{ $category->id }}] = null; calculateTotal(); nextStep()" 
                                    class="px-4 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 text-xs transition">
                                تخطي هذه الخطوة
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $allServices = collect();
                                foreach ($category->providers as $provider) {
                                    foreach ($provider->services as $service) {
                                        $service->provider_name = $provider->name_ar;
                                        $allServices->push($service);
                                    }
                                }
                            @endphp

                            @forelse($allServices as $service)
                                <div class="group relative bg-slate-900 border border-white/10 rounded-2xl overflow-hidden hover:border-white/20 transition-all h-full flex flex-col group-hover:-translate-y-1 duration-300">
                                    <label class="cursor-pointer flex-grow flex flex-col">
                                        <input 
                                            type="radio" 
                                            name="cat_{{ $category->id }}" 
                                            @click="selectService({{ $category->id }}, {{ $service->id }})"
                                            :checked="selections[{{ $category->id }}] == {{ $service->id }}"
                                            class="peer sr-only"
                                        >
                                        
                                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-500 peer-checked:bg-blue-900/5 rounded-2xl pointer-events-none z-10 transition"></div>

                                        <div class="h-44 relative bg-slate-950 w-full">
                                            @if($service->image)
                                                <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="fa-solid fa-image text-slate-700 text-3xl"></i>
                                                </div>
                                            @endif
                                            <div class="absolute top-3 right-3 bg-black/70 backdrop-blur px-3 py-1 rounded-lg text-[10px] text-white font-bold border border-white/10 z-20">
                                                {{ $service->provider_name }}
                                            </div>
                                        </div>

                                        <div class="p-5 flex flex-col flex-grow">
                                            <h4 class="text-white font-bold text-lg mb-1">{{ $service->name_ar }}</h4>
                                            <p class="text-slate-400 text-xs line-clamp-2 mb-4 h-8">{{ $service->description }}</p>
                                            
                                            <div class="mt-auto flex justify-between items-center border-t border-white/5 pt-4">
                                                <span class="text-xl font-black text-white">{{ (int)$service->price }} <span class="text-xs text-slate-500">د.أ</span></span>
                                                
                                                <button 
                                                    type="button" 
                                                    @click.stop="openModal({{ $service->id }})" 
                                                    class="text-xs bg-white/5 hover:bg-white/10 text-slate-300 px-3 py-1.5 rounded-lg border border-white/5 transition z-20 relative"
                                                >
                                                    التفاصيل <i class="fa-solid fa-eye ml-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-16 bg-slate-900/50 rounded-2xl border border-dashed border-slate-700">
                                    <p class="text-slate-400">لا توجد خدمات متاحة لهذا التصنيف حاليًا.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach

                {{-- Final Step: Review & Booking --}}
                <div x-show="step === {{ $occasion->categories->count() }}" x-transition.opacity style="display: none;" class="text-white">
                    <div class="bg-slate-900 border border-white/10 rounded-2xl p-6 mb-6">
                        <h3 class="text-white font-bold border-b border-white/5 pb-4 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-clipboard-list text-blue-500"></i> تفاصيل المناسبة
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-white">تاريخ المناسبة <span class="text-red-500">*</span></label>
                                <input type="date" x-model="date" min="{{ date('Y-m-d') }}" class="w-full text-white bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition placeholder-slate-500">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-white">وقت البدء <span class="text-red-500">*</span></label>
                                <input type="time" x-model="time" class="w-full text-white bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition placeholder-slate-500">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-white">عدد المعازيم (تقريبي)</label>
                                <input type="number" x-model="guest_count" placeholder="مثلاً: 100" class="w-full text-white bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition placeholder-slate-500">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-white">تفاصيل إضافية (لون الورد، نوع الزينة..)</label>
                                <input type="text" x-model="extra_details" placeholder="اكتب تفاصيلك هنا..." class="w-full text-white bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition placeholder-slate-500">
                            </div>
                        </div>

                        {{-- Delivery Options --}}
                        <div class="mt-6 pt-6 border-t border-white/5">
                            <label class="text-xs font-bold block mb-3 text-white">(ان لزم)طريقة الاستلام/التنفيذ</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer bg-slate-950 border border-slate-700 px-4 py-3 rounded-xl flex-1 hover:border-blue-500 transition" :class="{'border-blue-500 ring-1 ring-blue-500': delivery_type === 'pickup'}">
                                    <input type="radio" value="pickup" x-model="delivery_type" class="hidden">
                                    <i class="fa-solid fa-shop text-slate-400"></i>
                                    <span class="text-sm text-white">في الموقع / استلام</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer bg-slate-950 border border-slate-700 px-4 py-3 rounded-xl flex-1 hover:border-blue-500 transition" :class="{'border-blue-500 ring-1 ring-blue-500': delivery_type === 'delivery'}">
                                    <input type="radio" value="delivery" x-model="delivery_type" class="hidden">
                                    <i class="fa-solid fa-truck text-slate-400"></i>
                                    <span class="text-sm text-white">توصيل (للمنزل/القاعة)</span>
                                </label>
                            </div>
                        </div>

                        {{-- Address Input (Only if Delivery) --}}
                        <div x-show="delivery_type === 'delivery'" x-transition class="mt-4">
                            <label class="text-xs text-white font-bold mb-2 block">عنوان التوصيل <span class="text-red-500">*</span></label>
                            <textarea x-model="address" rows="2" placeholder="المدينة، اسم الشارع، معلم قريب..." class="w-full text-white bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition resize-none placeholder-slate-500"></textarea>
                        </div>
                    </div>

                    {{-- Summary & Smart Action Button --}}
                    <div class="bg-slate-900 border border-white/10 rounded-2xl p-6">
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-white">الإجمالي النهائي المتوقع</span>
                            <span class="text-4xl font-black text-white" x-text="total + ' د.أ'"></span>
                        </div>
                        
                        <button 
                            @click="
                                saveState(); 
                                if(!isLoggedIn) { window.location.href = loginUrl; return; } 
                                submitBooking()
                            " 
                            class="w-full font-bold py-4 rounded-xl shadow-lg transition flex items-center justify-center gap-2 text-lg group" 
                            :disabled="!date || !time || isLoading" 
                            :class="(!date || !time || isLoading) ? 'bg-slate-800 text-slate-500 cursor-not-allowed' : 'bg-green-600 hover:bg-green-500 text-white shadow-green-900/30'"
                        >
                            <span x-show="!isLoading">
                                <span x-show="!date || !time">يرجى تحديد الموعد أولاً</span>
                                <span x-show="date && time && !isLoggedIn">تسجيل الدخول للمتابعة</span>
                                <span x-show="date && time && isLoggedIn">تأكيد الحجز وإرسال الطلب</span>
                            </span>
                            <span x-show="isLoading">جاري الحجز...</span>
                            
                            <i x-show="!isLoading" class="fa-solid" 
                               :class="{
                                   'fa-lock': !date || !time,
                                   'fa-right-to-bracket': date && time && !isLoggedIn,
                                   'fa-check-circle group-hover:scale-110': date && time && isLoggedIn
                               }">
                            </i>
                            <i x-show="isLoading" class="fa-solid fa-circle-notch fa-spin"></i>
                        </button>
                    </div>
                </div>
            </main>
        </div>

        {{-- Fixed Bottom Bar (Mobile/Desktop) --}}
        <div class="fixed bottom-0 left-0 w-full bg-slate-950/90 backdrop-blur border-t border-white/10 p-4 z-40">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-400 uppercase">المجموع</span>
                    <span class="text-2xl font-black text-white" x-text="total + ' د.أ'"></span>
                </div>
                <div class="flex gap-3">
                    <button @click="prevStep()" x-show="step > 0" class="px-6 py-2 rounded-xl border border-white/10 text-white hover:bg-white/5 transition font-bold text-sm">
                        عودة
                    </button>
                    <button @click="nextStep()" x-show="step < {{ $occasion->categories->count() }}" 
                            class="px-8 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-900/20 transition font-bold text-sm flex items-center gap-2">
                        <span>التالي</span>
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Service Detail Modal --}}
        <template x-teleport="body">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
                <div @click.away="showModal = false" class="bg-slate-900 border border-white/10 rounded-3xl w-full max-w-lg p-0 shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]">
                    <button @click="showModal = false" class="absolute top-4 right-4 w-8 h-8 bg-black/50 rounded-full text-white flex items-center justify-center hover:bg-red-500 transition z-50">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <div class="relative h-48 bg-slate-950 flex-shrink-0">
                        <img x-show="modalService.image" :src="modalService.image" class="w-full h-full object-cover">
                        <div x-show="!modalService.image" class="w-full h-full flex items-center justify-center text-slate-700">
                            <i class="fa-solid fa-image text-4xl"></i>
                        </div>
                        <div class="absolute bottom-4 right-4 bg-black/70 backdrop-blur px-3 py-1 rounded-lg text-xs text-white font-bold border border-white/10" x-text="modalService.provider"></div>
                    </div>

                    <div class="p-6 overflow-y-auto">
                        <span class="text-blue-500 text-xs font-bold uppercase tracking-wider mb-1 block" x-text="modalService.cat_name"></span>
                        <h2 class="text-2xl font-black text-white mb-4" x-text="modalService.name"></h2>
                        
                        <div class="space-y-4">
                            <div class="bg-white/5 rounded-xl p-4 border border-white/5">
                                <span class="text-xs text-white font-bold block mb-1">الوصف</span>
                                <p class="text-slate-300 text-sm leading-relaxed" x-text="modalService.description || 'لا يوجد وصف متاح.'"></p>
                            </div>
                            
                            <div class="flex gap-4">
                                <div class="flex-1 bg-white/5 rounded-xl p-4 border border-white/5" x-show="modalService.capacity">
                                    <span class="text-xs text-white font-bold block mb-1">السعة</span>
                                    <span class="text-white font-bold text-sm">
                                        <i class="fa-solid fa-users text-blue-500 ml-1"></i> 
                                        <span x-text="modalService.capacity"></span> شخص
                                    </span>
                                </div>
                                <div class="flex-1 bg-white/5 rounded-xl p-4 border border-white/5">
                                    <span class="text-xs text-white font-bold block mb-1">السعر</span>
                                    <span class="text-white font-bold text-xl" x-text="modalService.price + ' د.أ'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-t border-white/10 bg-slate-950">
                        <button @click="showModal = false" class="w-full py-3 bg-slate-800 hover:bg-slate-700 text-white rounded-xl font-bold transition">
                            إغلاق
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection