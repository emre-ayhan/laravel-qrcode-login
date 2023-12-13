<script setup>
import { ref, onMounted } from 'vue'
import { Html5Qrcode } from "html5-qrcode";

const html5QrCode = ref(null)

const onSuccess = (decodedText, decodedResult) => {
    console.log(decodedText)
};

const onError = (err) => {
  console.log(err);
  html5QrCode.value.stop();
};

onMounted(() => {
  html5QrCode.value = new Html5Qrcode("reader");

  // If you want to prefer back camera
  html5QrCode.value.start({ facingMode: "environment" }, { fps: 10, qrbox: 300 }, onSuccess, onError);
})


</script>

<template>
    <div id="reader"></div>
</template>