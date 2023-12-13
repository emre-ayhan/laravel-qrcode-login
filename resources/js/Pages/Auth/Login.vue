<script setup>
import { ref, onMounted } from 'vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import QrcodeVue from 'qrcode.vue'


const props = defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    qrcode_value: {
        type: String
    }
});

const showQrCode = ref(false)

const form = useForm({
    user_id: null,
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

onMounted(() => {
    window.Echo.channel('login-via-qrcode').listen('QrcodeScannerEvent', event => {
        if (props.qrcode_value == event.value) {
            form.user_id = event.user_id;
            submit();
        }
    })
})
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        <div class="flex" v-if="showQrCode">
            <div class="mx-auto my-12">
                <qrcode-vue class="block mb-3" :value="qrcode_value" :size="256" level="H" :margin="1" render-as="svg"></qrcode-vue>
                <Link :href="route('login')" preserve-state class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise inline" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
                    </svg>
                    Reload Image
                </Link>
            </div>
        </div>

        <template v-else>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />
    
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
    
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
    
                <div class="mt-4">
                    <InputLabel for="password" value="Password" />
    
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
    
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
    
                <div class="block mt-4">
                    <label class="flex items-center">
                        <div>
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                        </div>
                        <PrimaryButton class="ms-auto" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Log in
                        </PrimaryButton>
                    </label>
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Forgot your password?
                    </Link>
                </div>
    
                <div class="mt-7">
                    <div class="my-3 flex">
                        <button type="button" class="ms-auto text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="showQrCode = true">
                            <div class="mx-auto flex items-center">
                                <span class="me-2">Log in Using</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                                    <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5M4 4h1v1H4z"/>
                                    <path d="M7 2H2v5h5zM3 3h3v3H3zm2 8H4v1h1z"/>
                                    <path d="M7 9H2v5h5zm-4 1h3v3H3zm8-6h1v1h-1z"/>
                                    <path d="M9 2h5v5H9zm1 1v3h3V3zM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8zm2 2H9V9h1zm4 2h-1v1h-2v1h3zm-4 2v-1H8v1z"/>
                                    <path d="M12 9h2V8h-2z"/>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </template>
    </GuestLayout>
</template>
