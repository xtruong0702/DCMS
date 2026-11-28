<style>
    .dcms-ai-root {
        position: fixed;
        right: 22px;
        bottom: 20px;
        z-index: 9999;
        font-family: 'Be Vietnam Pro', system-ui, -apple-system, sans-serif;
    }

    @media (max-width: 767px) {
        .dcms-ai-root {
            right: 14px;
            bottom: 78px;
        }
    }

    .dcms-ai-panel {
        width: min(410px, calc(100vw - 28px));
        height: min(580px, calc(100vh - 108px));
        margin-bottom: 14px;
        border-radius: 24px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        background: #ffffff;
        border: 1px solid rgba(13, 122, 104, 0.16);
        box-shadow: 0 24px 60px -12px rgba(6, 46, 40, 0.28), 0 4px 16px rgba(0, 0, 0, 0.06);
    }

    .dcms-ai-header {
        background: linear-gradient(135deg, #073830 0%, #0D7A68 58%, #0a584b 100%);
        padding: 15px 16px;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-shrink: 0;
        border-bottom: 1px solid rgba(252, 211, 77, 0.2);
    }

    .dcms-ai-avatar-lg {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(252, 211, 77, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        position: relative;
        flex-shrink: 0;
    }

    .dcms-ai-messages {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        background: #f3f7f6;
        scrollbar-width: thin;
        scrollbar-color: rgba(13, 122, 104, 0.28) transparent;
    }

    .dcms-ai-messages::-webkit-scrollbar {
        width: 5px;
    }
    .dcms-ai-messages::-webkit-scrollbar-thumb {
        background: rgba(13, 122, 104, 0.28);
        border-radius: 999px;
    }

    .dcms-ai-bubble-bot {
        background: #ffffff;
        color: #0f172a;
        border: 1px solid #dce8e5;
        border-radius: 18px 18px 18px 6px;
        padding: 12px 15px;
        font-size: 13.5px;
        line-height: 1.62;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        word-break: break-word;
    }

    .dcms-ai-bubble-bot strong {
        color: #094d42;
        font-weight: 700;
    }

    .dcms-ai-bubble-user {
        background: linear-gradient(135deg, #0D7A68 0%, #095d4f 100%);
        color: #ffffff;
        border-radius: 18px 18px 6px 18px;
        padding: 11px 15px;
        font-size: 13.5px;
        line-height: 1.55;
        box-shadow: 0 4px 12px rgba(13, 122, 104, 0.22);
        word-break: break-word;
    }

    .dcms-ai-time {
        font-size: 10.5px;
        color: #94a3b8;
        margin-top: 4px;
        padding: 0 4px;
    }

    .dcms-ai-action-primary {
        background: #0D7A68;
        color: #ffffff !important;
        border: 1px solid #0D7A68;
        border-radius: 11px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .dcms-ai-action-primary:hover {
        background: #095d4f;
        transform: translateY(-1px);
    }

    .dcms-ai-action-secondary {
        background: #ffffff;
        color: #0b6153 !important;
        border: 1px solid #b9dcd5;
        border-radius: 11px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .dcms-ai-action-secondary:hover {
        background: #ecfaf7;
        border-color: #0D7A68;
    }

    .dcms-ai-quickbar {
        padding: 10px 14px;
        background: #ffffff;
        border-top: 1px solid #e6efed;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        flex-shrink: 0;
    }

    .dcms-ai-chip {
        padding: 5px 11px;
        border-radius: 999px;
        background: #f0f6f5;
        color: #1e4d45;
        border: 1px solid #d5e6e2;
        font-size: 11.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .dcms-ai-chip:hover {
        background: #0D7A68;
        color: #ffffff;
        border-color: #0D7A68;
    }

    .dcms-ai-form {
        padding: 12px 14px;
        background: #ffffff;
        border-top: 1px solid #e2ece9;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .dcms-ai-input {
        flex: 1;
        border-radius: 14px;
        border: 1.5px solid #d7e5e2;
        background: #f6faf9;
        color: #0f172a;
        font-size: 13px;
        padding: 10px 14px;
        outline: none;
        transition: all 0.15s ease;
    }
    .dcms-ai-input:focus {
        background: #ffffff;
        border-color: #0D7A68;
        box-shadow: 0 0 0 3px rgba(13, 122, 104, 0.12);
    }

    .dcms-ai-send {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: linear-gradient(135deg, #0D7A68 0%, #095b4d 100%);
        color: #ffffff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.15s ease;
    }
    .dcms-ai-send:hover:not(:disabled) {
        transform: scale(1.04);
        filter: brightness(1.06);
    }
    .dcms-ai-send:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Dark Clinic Mode Overrides */
    html.dark-clinic .dcms-ai-panel {
        background: #0a1916;
        border-color: rgba(212, 175, 55, 0.28);
        box-shadow: 0 24px 64px rgba(0, 0, 0, 0.65);
    }
    html.dark-clinic .dcms-ai-messages {
        background: #071311;
    }
    html.dark-clinic .dcms-ai-bubble-bot {
        background: #102622;
        color: #eef7f5;
        border-color: rgba(212, 175, 55, 0.2);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
    }
    html.dark-clinic .dcms-ai-bubble-bot strong {
        color: #f3e5ab;
    }
    html.dark-clinic .dcms-ai-action-secondary {
        background: #122d28;
        color: #f3e5ab !important;
        border-color: rgba(212, 175, 55, 0.35);
    }
    html.dark-clinic .dcms-ai-action-secondary:hover {
        background: #183b35;
    }
    html.dark-clinic .dcms-ai-quickbar,
    html.dark-clinic .dcms-ai-form {
        background: #0b1c19;
        border-color: rgba(255, 255, 255, 0.08);
    }
    html.dark-clinic .dcms-ai-chip {
        background: #122a26;
        color: #d7ece8;
        border-color: rgba(212, 175, 55, 0.22);
    }
    html.dark-clinic .dcms-ai-chip:hover {
        background: #d4af37;
        color: #071311;
        border-color: #d4af37;
    }
    html.dark-clinic .dcms-ai-input {
        background: #102521;
        color: #f1f5f9;
        border-color: rgba(255, 255, 255, 0.14);
    }
    html.dark-clinic .dcms-ai-input::placeholder {
        color: #88a7a1;
    }
    html.dark-clinic .dcms-ai-input:focus {
        background: #142f2a;
        border-color: #d4af37;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.16);
    }
</style>

<div x-data="dentalAiChat()" x-init="init()" class="dcms-ai-root print:hidden">
    <!-- Cửa sổ Chat Trợ lý AI -->
    <div
        x-show="isOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="dcms-ai-panel"
    >
        <!-- Header -->
        <div class="dcms-ai-header">
            <div class="flex items-center gap-3 min-w-0">
                <div class="dcms-ai-avatar-lg">
                    <span>🦷</span>
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-[#0a584b]"></span>
                </div>
                <div class="min-w-0">
                    <h3 class="text-[14.5px] font-extrabold tracking-tight text-white truncate">Trợ lý AI {{ $clinicSettings['clinic_name'] }}</h3>
                    <p class="text-[11.5px] text-teal-100/90 flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                        <span>Tư vấn Y khoa 24/7 • Trực tuyến</span>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-1 shrink-0">
                <button
                    type="button"
                    @click="resetChat()"
                    title="Làm mới cuộc trò chuyện"
                    class="w-8 h-8 rounded-xl hover:bg-white/15 flex items-center justify-center text-teal-100 hover:text-white transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </button>
                <button
                    type="button"
                    @click="isOpen = false"
                    title="Đóng cửa sổ chat"
                    class="w-8 h-8 rounded-xl hover:bg-white/15 flex items-center justify-center text-teal-100 hover:text-white transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Nội dung hội thoại -->
        <div x-ref="messagesBox" class="dcms-ai-messages">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex flex-col items-end' : 'flex items-end gap-2.5'">
                    <template x-if="msg.role === 'assistant'">
                        <div class="w-8 h-8 rounded-xl bg-[#0D7A68] text-white flex items-center justify-center text-sm shrink-0 shadow-xs mb-5">
                            🦷
                        </div>
                    </template>

                    <div style="max-width: 84%;" class="space-y-2">
                        <div
                            :class="msg.role === 'user' ? 'dcms-ai-bubble-user' : 'dcms-ai-bubble-bot'"
                            x-html="formatText(msg.text)"
                        ></div>

                        <!-- Các nút hành động nhanh do AI gợi ý -->
                        <template x-if="msg.role === 'assistant' && msg.actions && msg.actions.length > 0">
                            <div class="flex flex-wrap gap-1.5 pt-0.5">
                                <template x-for="(act, aIdx) in msg.actions" :key="aIdx">
                                    <a
                                        :href="act.url"
                                        :target="act.external ? '_blank' : '_self'"
                                        :rel="act.external ? 'noopener noreferrer' : ''"
                                        :class="act.primary ? 'dcms-ai-action-primary' : 'dcms-ai-action-secondary'"
                                        x-text="act.label"
                                    ></a>
                                </template>
                            </div>
                        </template>

                        <div :class="msg.role === 'user' ? 'dcms-ai-time text-right' : 'dcms-ai-time'" x-text="msg.time || ''"></div>
                    </div>
                </div>
            </template>

            <!-- Hiệu ứng AI đang trả lời -->
            <div x-show="loading" class="flex items-end gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-[#0D7A68] text-white flex items-center justify-center text-sm shrink-0">🦷</div>
                <div class="dcms-ai-bubble-bot flex items-center gap-1.5" style="padding: 13px 16px;">
                    <span class="w-2 h-2 rounded-full bg-teal-500 animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="w-2 h-2 rounded-full bg-teal-500 animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="w-2 h-2 rounded-full bg-teal-500 animate-bounce" style="animation-delay: 300ms"></span>
                </div>
            </div>
        </div>

        <!-- Gợi ý câu hỏi nhanh -->
        <div class="dcms-ai-quickbar">
            <button type="button" @click="sendQuick('Bảng giá dịch vụ nha khoa')" class="dcms-ai-chip">💰 Bảng giá</button>
            <button type="button" @click="sendQuick('Phòng khám có bao nhiêu bác sĩ?')" class="dcms-ai-chip">👨‍⚕️ Đội ngũ BS</button>
            <button type="button" @click="sendQuick('Em bị đau răng khôn mọc lệch')" class="dcms-ai-chip">🦷 Đau răng khôn</button>
            <button type="button" @click="sendQuick('Nên niềng răng hay bọc răng sứ?')" class="dcms-ai-chip">✨ Niềng hay Sứ?</button>
        </div>

        <!-- Ô nhập tin nhắn -->
        <form @submit.prevent="sendMessage()" class="dcms-ai-form">
            <input
                type="text"
                x-ref="chatInput"
                x-model="input"
                :disabled="loading"
                placeholder="Nhập câu hỏi hoặc triệu chứng của Anh/Chị..."
                class="dcms-ai-input"
            >
            <button
                type="submit"
                :disabled="loading || !input.trim()"
                class="dcms-ai-send"
                title="Gửi câu hỏi"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </button>
        </form>
    </div>

    <!-- Nút Bong bóng mở Chat cố định góc phải dưới -->
    <div style="display: flex; justify-content: flex-end;">
        <button
            type="button"
            @click="toggle()"
            style="background: linear-gradient(135deg, #083d34 0%, #0D7A68 100%); border: 1.5px solid rgba(243, 229, 171, 0.55); box-shadow: 0 14px 32px -6px rgba(6, 46, 40, 0.55);"
            class="flex items-center gap-2.5 pl-4 pr-2.5 py-2 rounded-full text-white transition-all hover:scale-105 active:scale-95"
        >
            <span class="hidden sm:inline text-[13px] font-extrabold tracking-tight" x-text="isOpen ? 'Thu gọn' : 'Trợ lý AI 24/7'"></span>
            <span class="relative w-9 h-9 rounded-full bg-white/15 flex items-center justify-center text-lg">
                <span x-show="!isOpen">🦷</span>
                <svg x-show="isOpen" x-cloak class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                <span x-show="!isOpen" class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-amber-400 border-2 border-[#0D7A68] animate-pulse"></span>
            </span>
        </button>
    </div>
</div>

<script>
    function dentalAiChat() {
        const STORAGE_KEY = 'dcms_ai_chat_history_v3';
        const nowTime = () => {
            const d = new Date();
            return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
        };
        const makeWelcome = () => ({
            role: 'assistant',
            time: nowTime(),
            text: 'Kính chào Quý khách đến với **' + @js($clinicSettings['clinic_name']) + '**!\nEm là **Trợ lý Tư vấn Y khoa AI 24/7**, sẵn sàng hỗ trợ Anh/Chị về triệu chứng răng miệng, bảng giá niêm yết, đội ngũ Bác sĩ, lịch trống và thanh toán VietQR.',
            actions: [
                { label: '📅 Đặt lịch khám ngay', url: '{{ route('public.booking') }}', primary: true },
                { label: '💰 Xem bảng giá', url: '{{ route('public.services') }}', primary: false },
            ],
        });

        return {
            isOpen: false,
            input: '',
            loading: false,
            messages: [makeWelcome()],

            init() {
                try {
                    const saved = sessionStorage.getItem(STORAGE_KEY);
                    if (saved) {
                        const parsed = JSON.parse(saved);
                        if (Array.isArray(parsed) && parsed.length > 0) {
                            this.messages = parsed;
                        }
                    }
                } catch (e) {}
            },

            saveHistory() {
                try {
                    sessionStorage.setItem(STORAGE_KEY, JSON.stringify(this.messages.slice(-20)));
                } catch (e) {}
            },

            toggle() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    this.$nextTick(() => {
                        this.scrollToBottom();
                        if (this.$refs.chatInput) this.$refs.chatInput.focus();
                    });
                }
            },

            resetChat() {
                this.messages = [makeWelcome()];
                this.saveHistory();
                this.$nextTick(() => this.scrollToBottom());
            },

            scrollToBottom() {
                const box = this.$refs.messagesBox;
                if (box) {
                    box.scrollTop = box.scrollHeight;
                }
            },

            formatText(raw) {
                const escaped = String(raw || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;');
                return escaped
                    .replace(/^\s*[\*\-]\s+/gm, '• ')
                    .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\n\n+/g, '<div style="height:8px"></div>')
                    .replace(/\n/g, '<br>');
            },

            sendQuick(text) {
                this.input = text;
                this.sendMessage();
            },

            async sendMessage() {
                const text = this.input.trim();
                if (!text || this.loading) return;

                const historyPayload = this.messages.slice(-8).map(m => ({
                    role: m.role,
                    text: m.text,
                }));

                this.messages.push({ role: 'user', text, time: nowTime() });
                this.input = '';
                this.loading = true;
                this.saveHistory();
                this.$nextTick(() => this.scrollToBottom());

                try {
                    const res = await fetch('/api/ai-assistant/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            message: text,
                            history: historyPayload,
                        }),
                    });

                    const data = await res.json();
                    if (res.ok && data.success) {
                        this.messages.push({
                            role: 'assistant',
                            time: nowTime(),
                            text: data.reply,
                            actions: Array.isArray(data.actions) ? data.actions : [],
                        });
                    } else {
                        this.messages.push({
                            role: 'assistant',
                            time: nowTime(),
                            text: data.message || 'Xin lỗi Anh/Chị, trợ lý đang bận xử lý. Anh/Chị vui lòng thử lại hoặc gọi Hotline **' + @js($clinicSettings['clinic_hotline']) + '** để được hỗ trợ ngay ạ!',
                            actions: [{ label: '📞 Gọi ' + @js($clinicSettings['clinic_hotline']), url: 'tel:' + @js($clinicHotlineTel), primary: true }],
                        });
                    }
                } catch (err) {
                    this.messages.push({
                        role: 'assistant',
                        time: nowTime(),
                        text: 'Không thể kết nối đến máy chủ lúc này. Anh/Chị vui lòng gọi Hotline **' + @js($clinicSettings['clinic_hotline']) + '** để Lễ tân hỗ trợ trực tiếp ạ!',
                        actions: [{ label: '📞 Gọi ' + @js($clinicSettings['clinic_hotline']), url: 'tel:' + @js($clinicHotlineTel), primary: true }],
                    });
                } finally {
                    this.loading = false;
                    this.saveHistory();
                    this.$nextTick(() => this.scrollToBottom());
                }
            },
        };
    }
</script>
