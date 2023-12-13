<script setup>
import { ref } from 'vue'
import PrimaryButton from './PrimaryButton.vue';
import { QrcodeStream } from 'vue-qrcode-reader'

const scanQrcode = ref(false)
const isCameraOn = ref(false)

const toggleScanner = () => {
    scanQrcode.value = !scanQrcode.value;
    isCameraOn.value = false;
}

const authenticate = (qrcode_value) => {
    alert(qrcode_value);
    toggleScanner();
}

</script>
<style scoped>
.qr-code-reader::after {
    content: '';
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 256px;
    height: 256px;
    border: 4px solid #770000;
}
</style>
<template>
    
    <div class="max-w-7xl mx-auto p-6">
        <primary-button fixed @click="toggleScanner" title="toggle qrcode scanner" v-if="!scanQrcode">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5M4 4h1v1H4z"/>
                <path d="M7 2H2v5h5zM3 3h3v3H3zm2 8H4v1h1z"/>
                <path d="M7 9H2v5h5zm-4 1h3v3H3zm8-6h1v1h-1z"/>
                <path d="M9 2h5v5H9zm1 1v3h3V3zM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8zm2 2H9V9h1zm4 2h-1v1h-2v1h3zm-4 2v-1H8v1z"/>
                <path d="M12 9h2V8h-2z"/>
            </svg>
        </primary-button>
        <QrcodeStream :class="{ 'qr-code-reader': isCameraOn }" @detect="authenticate" @camera-on="isCameraOn = true" @camera-off="isCameraOn = false" v-else />
    </div>
</template>