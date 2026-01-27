{{-- Chatbot Widget - Floating AI Assistant --}}
<div id="chatbot-widget" x-data="chatbotWidget()" x-cloak class="fixed bottom-5 right-5 z-50">
    
    {{-- Floating Button --}}
    <button @click="toggle()" 
            class="relative w-14 h-14 bg-gradient-to-br from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 
                   rounded-full shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center
                   text-white transform hover:scale-105 animate-bounce-slow">
        <i class="fas" :class="isOpen ? 'fa-times text-xl' : 'fa-robot text-2xl'"></i>
        
        {{-- Notification Badge --}}
        <span x-show="!isOpen" 
              class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center
                     text-[10px] font-bold border-2 border-white animate-pulse">
            AI
        </span>
    </button>
    
    {{-- Chat Window --}}
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="absolute bottom-20 right-0 w-[360px] max-w-[calc(100vw-2rem)] bg-white rounded-2xl shadow-2xl 
                border border-gray-100 overflow-hidden flex flex-col"
         style="height: 500px; max-height: calc(100vh - 150px);">
        
        {{-- Header --}}
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fas fa-robot text-white text-lg"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-white font-semibold text-sm">Asisten E-Lapor</h3>
                <p class="text-white/80 text-xs flex items-center gap-1">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    Online • Siap membantu
                </p>
            </div>
            <button @click="toggle()" class="text-white/80 hover:text-white transition-colors">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
        
        {{-- Messages Container --}}
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50" x-ref="chatContainer">
            {{-- Welcome Message --}}
            <template x-if="messages.length === 0">
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-robot text-red-600 text-sm"></i>
                        </div>
                        <div class="bg-white rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm max-w-[85%]">
                            <p class="text-sm text-gray-700">
                                Halo! 👋 Saya Asisten Virtual E-Lapor. Ada yang bisa saya bantu?
                            </p>
                        </div>
                    </div>
                    
                    {{-- Quick Actions --}}
                    <div class="flex flex-wrap gap-2 ml-11">
                        <button @click="sendQuickAction('cara melapor')" 
                                class="px-3 py-1.5 bg-white border border-red-200 rounded-full text-xs font-medium 
                                       text-red-600 hover:bg-red-50 transition-colors">
                            📝 Cara Melapor
                        </button>
                        <button @click="sendQuickAction('kategori aduan')" 
                                class="px-3 py-1.5 bg-white border border-red-200 rounded-full text-xs font-medium 
                                       text-red-600 hover:bg-red-50 transition-colors">
                            📂 Kategori
                        </button>
                        <button @click="sendQuickAction('bantuan')" 
                                class="px-3 py-1.5 bg-white border border-red-200 rounded-full text-xs font-medium 
                                       text-red-600 hover:bg-red-50 transition-colors">
                            ❓ Bantuan
                        </button>
                    </div>
                </div>
            </template>
            
            {{-- Message History --}}
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex gap-3" :class="msg.isUser ? 'flex-row-reverse' : ''">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                         :class="msg.isUser ? 'bg-blue-100' : 'bg-red-100'">
                        <i class="text-sm" :class="msg.isUser ? 'fas fa-user text-blue-600' : 'fas fa-robot text-red-600'"></i>
                    </div>
                    <div class="rounded-2xl px-4 py-3 shadow-sm max-w-[85%]"
                         :class="msg.isUser ? 'bg-red-600 text-white rounded-tr-sm' : 'bg-white text-gray-700 rounded-tl-sm'">
                        <p class="text-sm whitespace-pre-wrap" x-html="formatMessage(msg.content)"></p>
                    </div>
                </div>
            </template>
            
            {{-- Typing Indicator --}}
            <div x-show="isTyping" class="flex gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-robot text-red-600 text-sm"></i>
                </div>
                <div class="bg-white rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm">
                    <div class="flex gap-1">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Input Area --}}
        <div class="p-3 bg-white border-t border-gray-100">
            <form @submit.prevent="sendMessage()" class="flex gap-2">
                <input type="text" x-model="inputMessage" 
                       placeholder="Ketik pesan..." 
                       :disabled="isTyping"
                       class="flex-1 px-4 py-2.5 bg-gray-100 rounded-full text-sm focus:outline-none focus:ring-2 
                              focus:ring-red-500 focus:bg-white transition-all disabled:opacity-50">
                <button type="submit" :disabled="!inputMessage.trim() || isTyping"
                        class="w-10 h-10 bg-red-600 hover:bg-red-700 disabled:bg-gray-300 
                               rounded-full flex items-center justify-center text-white transition-colors">
                    <i class="fas fa-paper-plane text-sm"></i>
                </button>
            </form>
            <p class="text-[10px] text-gray-400 text-center mt-2">
                Powered by AI • Llama 3.3
            </p>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 2s ease-in-out infinite;
    }
</style>

<script>
    function chatbotWidget() {
        return {
            isOpen: false,
            isTyping: false,
            inputMessage: '',
            messages: [],
            
            toggle() {
                this.isOpen = !this.isOpen;
            },
            
            formatMessage(text) {
                // Convert markdown-like formatting
                return text
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\n/g, '<br>')
                    .replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" class="text-red-600 hover:underline">$1</a>');
            },
            
            async sendMessage() {
                const message = this.inputMessage.trim();
                if (!message) return;
                
                // Add user message
                this.messages.push({ content: message, isUser: true });
                this.inputMessage = '';
                this.isTyping = true;
                
                // Scroll to bottom
                this.$nextTick(() => {
                    this.$refs.chatContainer.scrollTop = this.$refs.chatContainer.scrollHeight;
                });
                
                try {
                    const response = await fetch('/api/chatbot', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ message }),
                    });
                    
                    const data = await response.json();
                    
                    // Add bot response
                    this.messages.push({ content: data.message, isUser: false });
                    
                } catch (error) {
                    this.messages.push({ 
                        content: 'Maaf, terjadi kesalahan. Silakan coba lagi.', 
                        isUser: false 
                    });
                } finally {
                    this.isTyping = false;
                    this.$nextTick(() => {
                        this.$refs.chatContainer.scrollTop = this.$refs.chatContainer.scrollHeight;
                    });
                }
            },
            
            sendQuickAction(action) {
                this.inputMessage = action;
                this.sendMessage();
            }
        };
    }
</script>
