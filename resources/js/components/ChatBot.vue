<template>
   <div class="rounded-lg border-2 bg-white p-6 shadow-lg">
      <div class="mb-4 flex items-center justify-between">
         <h3 class="text-xl font-bold text-gray-800">
            💬 Tanya Model ASKARA
         </h3>
         <button
            v-if="messages.length > 0"
            @click="clearChat"
            class="text-sm text-red-500 hover:text-red-700"
         >
            Clear Chat
         </button>
      </div>

      <p class="mb-4 text-sm text-gray-600">
         Ajukan pertanyaan tentang hasil diagnosis Anda. AI ASKARA akan membantu
         menjelaskan dengan bahasa yang mudah dipahami.
      </p>

      <!-- Chat Messages -->
      <div
         ref="chatContainer"
         class="mb-4 max-h-[60vh] space-y-3 overflow-y-auto rounded-lg bg-gray-50 p-4"
      >
         <div v-if="messages.length === 0" class="text-center text-gray-400">
            Belum ada percakapan. Mulai dengan mengajukan pertanyaan di bawah.
         </div>

         <div
            v-for="(message, index) in messages"
            :key="index"
            :class="[
               'rounded-lg p-3',
               message.role === 'user'
                  ? 'ml-auto max-w-[80%] bg-blue-500 text-white'
                  : 'mr-auto max-w-[90%] bg-white shadow',
            ]"
         >
            <div class="mb-1 text-xs font-semibold opacity-70">
               {{ message.role === 'user' ? 'Anda' : '🤖 ASKARA' }}
            </div>
            <div class="whitespace-pre-wrap text-sm">
               {{ message.content }}
            </div>
            <div class="mt-1 text-xs opacity-50">
               {{ formatTime(message.timestamp) }}
            </div>
         </div>

         <!-- Loading indicator -->
         <div
            v-if="isLoading"
            class="mr-auto max-w-[90%] rounded-lg bg-white p-3 shadow"
         >
            <div class="flex items-center space-x-2">
               <div
                  class="h-2 w-2 animate-bounce rounded-full bg-blue-500"
                  style="animation-delay: 0s"
               ></div>
               <div
                  class="h-2 w-2 animate-bounce rounded-full bg-blue-500"
                  style="animation-delay: 0.2s"
               ></div>
               <div
                  class="h-2 w-2 animate-bounce rounded-full bg-blue-500"
                  style="animation-delay: 0.4s"
               ></div>
               <span class="text-sm text-gray-500">AI sedang berpikir...</span>
            </div>
         </div>
      </div>

      <!-- Input Area -->
      <div class="flex gap-2">
         <textarea
            v-model="currentQuestion"
            @keydown.enter.exact.prevent="sendMessage"
            :disabled="isLoading"
            placeholder="Ketik pertanyaan Anda... (Enter untuk kirim, Shift+Enter untuk baris baru)"
            rows="3"
            class="flex-1 resize-none rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none disabled:bg-gray-100"
         ></textarea>
         <button
            @click="sendMessage"
            :disabled="!currentQuestion.trim() || isLoading"
            class="rounded-lg bg-blue-600 px-6 py-2 text-white transition-colors hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-blue-300"
         >
            <span v-if="!isLoading">Kirim</span>
            <span v-else>...</span>
         </button>
      </div>

      <!-- Suggested Questions -->
      <div v-if="messages.length === 0" class="mt-4">
         <p class="mb-2 text-xs font-semibold text-gray-600">
            Contoh pertanyaan:
         </p>
         <div class="flex flex-wrap gap-2">
            <button
               v-for="(suggestion, index) in suggestedQuestions"
               :key="index"
               @click="askSuggestion(suggestion)"
               class="rounded-full bg-blue-50 px-3 py-1 text-xs text-blue-600 hover:bg-blue-100"
            >
               {{ suggestion }}
            </button>
         </div>
      </div>
   </div>
</template>

<script lang="ts" setup>
import { nextTick, ref } from 'vue';

interface Message {
   role: 'user' | 'assistant';
   content: string;
   timestamp: Date;
}

interface Props {
   diagnosisResult?: any;
}

const props = defineProps<Props>();

const messages = ref<Message[]>([]);
const currentQuestion = ref('');
const isLoading = ref(false);
const chatContainer = ref<HTMLDivElement | null>(null);

const suggestedQuestions = [
   'Apa arti dari hasil diagnosis ini?',
   'Apakah kondisi ini berbahaya?',
   'Apa yang harus saya lakukan selanjutnya?',
   'Bagaimana cara mencegah penyakit ini?',
   'Berapa lama waktu pemulihan?',
];

const sendMessage = async () => {
   const question = currentQuestion.value.trim();
   if (!question || isLoading.value) return;

   // Add user message
   messages.value.push({
      role: 'user',
      content: question,
      timestamp: new Date(),
   });

   currentQuestion.value = '';
   isLoading.value = true;

   // Scroll to bottom
   await nextTick();
   scrollToBottom();

   try {
      // Prepare diagnosis context
      const diagnosisContext = props.diagnosisResult
         ? JSON.stringify({
              prediction: props.diagnosisResult.prediction,
              confidence: props.diagnosisResult.confidence,
              clinical_explanation:
                 props.diagnosisResult.clinical_explanation,
           })
         : null;

      // Call chat API
      const formData = new FormData();
      formData.append('question', question);
      if (diagnosisContext) {
         formData.append('diagnosis_context', diagnosisContext);
      }

      const response = await fetch('http://localhost:5000/chat', {
         method: 'POST',
         body: formData,
      });

      const data = await response.json();

      if (data.success) {
         messages.value.push({
            role: 'assistant',
            content: data.answer,
            timestamp: new Date(),
         });
      } else {
         messages.value.push({
            role: 'assistant',
            content:
               'Maaf, terjadi kesalahan. ' +
               (data.error || 'Silakan coba lagi.'),
            timestamp: new Date(),
         });
      }
   } catch (error) {
      console.error('Chat error:', error);
      messages.value.push({
         role: 'assistant',
         content:
            'Maaf, tidak dapat terhubung ke server. Pastikan server API berjalan di localhost:5000',
         timestamp: new Date(),
      });
   } finally {
      isLoading.value = false;
      await nextTick();
      scrollToBottom();
   }
};

const askSuggestion = (suggestion: string) => {
   currentQuestion.value = suggestion;
   sendMessage();
};

const clearChat = () => {
   messages.value = [];
   currentQuestion.value = '';
};

const scrollToBottom = () => {
   if (chatContainer.value) {
      chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
   }
};

const formatTime = (date: Date) => {
   return date.toLocaleTimeString('id-ID', {
      hour: '2-digit',
      minute: '2-digit',
   });
};
</script>
