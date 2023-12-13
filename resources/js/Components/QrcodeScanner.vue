<script setup>
import { ref } from 'vue'
import PrimaryButton from './PrimaryButton.vue';
import { QrcodeStream } from 'vue-qrcode-reader'
import { useForm } from '@inertiajs/vue3';

const scanQrcode = ref(false)
const isCameraOn = ref(false)

const toggleScanner = () => {
    scanQrcode.value = !scanQrcode.value;
    isCameraOn.value = false;
}

const form = useForm({
    qrcode_value: null
})

const authenticate = (data = []) => {
    form.qrcode_value = data[data.length - 1]?.rawValue;
    toggleScanner();
    form.post('/authenticate-via-qrcode', { preserveState: true })
}

</script>
<style scoped>
.qr-code-scanner-wrapper {
    position: relative;
    width: 100%;
    padding-bottom: 100%;
}
.qr-code-scanner {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
svg.qr-code-overlay {
    width: 100%;
    height: 100%;
    display: block;
}
</style>
<template>
    
    <div class="max-w-7xl mx-auto p-6">
        <primary-button fixed @click="toggleScanner" title="toggle qrcode scanner">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5M4 4h1v1H4z"/>
                <path d="M7 2H2v5h5zM3 3h3v3H3zm2 8H4v1h1z"/>
                <path d="M7 9H2v5h5zm-4 1h3v3H3zm8-6h1v1h-1z"/>
                <path d="M9 2h5v5H9zm1 1v3h3V3zM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8zm2 2H9V9h1zm4 2h-1v1h-2v1h3zm-4 2v-1H8v1z"/>
                <path d="M12 9h2V8h-2z"/>
            </svg>
        </primary-button>
        <div class="qr-code-scanner-wrapper" v-if="scanQrcode">
            <div class="qr-code-scanner" >
                <QrcodeStream @detect="authenticate" @camera-on="isCameraOn = true" @camera-off="isCameraOn = false">
                    <svg
                        v-if="isCameraOn"
                        class="qr-code-overlay"
                        viewBox="0 0 100 100"
                        version="1.1"
                        id="svg1"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:svg="http://www.w3.org/2000/svg">
                        <defs
                            id="defs1" />
                        <g
                            id="layer1"
                            transform="matrix(0.73818897,0,0,0.73818897,-16.63475,-39.437484)">
                            <path
                            id="rect1"
                            style="opacity:0.32;stroke-width:0.24953"
                            d="M 22.534542,53.424646 V 188.89131 H 158.00121 V 53.424646 Z M 56.401208,87.291313 H 124.13454 V 155.02465 H 56.401208 Z" />
                        </g>
                    </svg>
                </QrcodeStream>
            </div>
        </div>
    </div>
</template>