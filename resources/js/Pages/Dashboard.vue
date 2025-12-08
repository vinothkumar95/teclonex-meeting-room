<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'

const props = defineProps({
    booking_history: Array,
    required : true,
    default : []
});

const cancelBooking = (id) => {
    if (!confirm("Are you sure you want to cancel this booking?"))
        return;

    router.delete(`/room/bookings/${id}`, {
        onSuccess: () => alert('Cancelled')
    })
};

const formatTime = (time) => {
    if (!time) return "";

    const [hour, minute] = time.split(":");
    const h = parseInt(hour);
    const suffix = h >= 12 ? "PM" : "AM";
    const formattedHour = ((h + 11) % 12 + 1); // convert 0–23 → 1–12

    return `${formattedHour}:${minute} ${suffix}`;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <h2 class="text-2xl font-semibold mb-4">Booking History</h2>

                       <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 text-left">
                                <tr>
                                    <th class="px-4 py-2 border-b">Date</th>
                                    <th class="px-4 py-2 border-b">Room</th>
                                    <th class="px-4 py-2 border-b">Time</th>
                                    <th class="px-4 py-2 border-b">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr 
                                    v-for="booking in booking_history" 
                                    :key="booking.id"
                                    class="hover:bg-gray-50"
                                >
                                    <td class="px-4 py-2 border-b">{{ booking.date }}</td>
                                    <td class="px-4 py-2 border-b">{{ booking.room.name }}</td>
                                    <td class="px-4 py-2 border-b">{{ formatTime(booking.time_slot.start_time) }} - {{ formatTime(booking.time_slot.end_time) }}</td>

                                    <td class="px-4 py-2 border-b">
                                        <button
                                            @click="cancelBooking(booking.id)"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm"
                                        >
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
