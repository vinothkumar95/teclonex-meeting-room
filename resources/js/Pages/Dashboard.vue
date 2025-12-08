<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'

const props = defineProps({
    booking_history: {
        type: Array,
        required: true,
        default: []
    }
});

// Toast
import { ref } from 'vue';
const toastMessage = ref("");
const toastType = ref("success");
const showToast = ref(false);

const triggerToast = (message, type = "success") => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;
    setTimeout(() => showToast.value = false, 3000);
};

// Cancel booking
const cancelBooking = (id) => {
    if (!confirm("Are you sure you want to cancel this booking?")) return;

    router.delete(`/room/bookings/${id}`, {
        onSuccess: () => triggerToast('Booking cancelled!', 'success'),
        onError: () => triggerToast('Failed to cancel booking', 'error')
    });
};

const formatTime = (time) => {
    if (!time) return "";

    const [hour, minute] = time.split(":");
    const h = parseInt(hour);
    const suffix = h >= 12 ? "PM" : "AM";
    const formattedHour = ((h + 11) % 12 + 1);

    return `${formattedHour}:${minute} ${suffix}`;
};
</script>

<template>
    <Head title="Dashboard" />

    <!-- Toast -->
    <transition name="fade">
        <div 
            v-if="showToast"
            :class="['fixed top-5 right-5 px-4 py-2 rounded shadow-lg', 
                     toastType === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white']"
        >
            {{ toastMessage }}
        </div>
    </transition>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-md sm:rounded-lg p-6">
                    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Booking History</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="booking in booking_history" :key="booking.id" class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ booking.date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ booking.room.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ formatTime(booking.time_slot.start_time) }} - {{ formatTime(booking.time_slot.end_time) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button
                                            @click="cancelBooking(booking.id)"
                                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50 transition"
                                        >
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="booking_history.length === 0">
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No bookings found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
