<template>
  <div class="px-4 py-3 mb-8 bg-purple-50 rounded-lg shadow-md dark:bg-purple-200">
    <label class="block text-sm">
      <span class="text-purple-700 dark:text-dark-400">{{ text }}</span>
      <!-- focus-within sets the color for the icon when input is focused -->
      <div class="relative text-purple-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
        <input
          class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 border-purple-300 bg-white focus:border-purple-500 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          ref="input"
          :placeholder="text"
          :type="type"
          :required="required"
          :accept="accept"
        />
        <div class="absolute inset-y-0 left-0 flex items-center ml-3 pointer-events-none">
          <slot></slot>
        </div>
      </div>
    </label>
  </div>
</template>
  
  <script setup>
  import { onMounted, ref } from 'vue';
  
  defineProps(['modelValue','text','type','required','accept']);
  
  defineEmits(['update:modelValue']);
  
  const input = ref(null);
  
  onMounted(() => {
      if (input.value.hasAttribute('autofocus')) {
          input.value.focus();
      }
  });
  </script>
  