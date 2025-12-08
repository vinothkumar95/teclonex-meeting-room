<script setup>
import { ref, watch, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from "axios"

const props = defineProps({
    rooms: Array,
});

// Default values
const today = new Date().toISOString().slice(0, 10);
const selectedDate = ref(today);
const selectedRoom = ref(props.rooms[0]?.id ?? null);

// Dynamic slots
const filteredSlots = ref([]);

// Modal
const showModal = ref(false);
const selectedSlot = ref(null);
const isLoading = ref(false);

// Watch room/date and fetch slots
watch([selectedRoom, selectedDate], () => loadSlots());

// Fetch slots from backend
const loadSlots = async () => {
    if (!selectedRoom.value || !selectedDate.value) return;

    const response = await axios.post('/room/booked-slots', {
        room_id: selectedRoom.value,
        date: selectedDate.value
    });

    filteredSlots.value = response.data;
};

// Open confirmation modal
const openBookingModal = (slot) => {
    if (slot.is_booked) return; // Prevent clicking booked slots
    selectedSlot.value = slot;
    showModal.value = true;
};

onMounted(() => {
    loadSlots();
});

const formatTime = (time) => {
    if (!time) return "";

    const [hour, minute] = time.split(":");
    const h = parseInt(hour);
    const suffix = h >= 12 ? "PM" : "AM";
    const formattedHour = ((h + 11) % 12 + 1); // convert 0–23 → 1–12

    return `${formattedHour}:${minute} ${suffix}`;
};

// Save booking
const confirmBooking = async () => {
    isLoading.value = true;

    try {
        await axios.post('/room/book', {
            date: selectedDate.value,
            room_id: selectedRoom.value,
            time_slot_id: selectedSlot.value.id,
        });

        alert("Booking confirmed!");
        showModal.value = false;

        loadSlots(); // Refresh slots

    } catch (error) {
        alert(error.response?.data?.message ?? "Booking failed");
    } finally {
        isLoading.value = false;
    }
};
</script>


<template>
    <Head title="Book Room" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold">Book Meeting Room</h2>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-5xl px-6">

                <!-- Date Picker -->
                <div class="mb-6">
                    <label class="block text-gray-700 mb-1 font-medium">Select Date</label>
                    <input 
                        type="date" 
                        v-model="selectedDate"
                        :min="today"
                        class="border rounded p-2 w-60 shadow-sm"
                    />
                </div>

                <!-- Rooms Tabs -->
                <div class="flex gap-3 border-b pb-2 mb-6">
                    <button 
                        v-for="room in rooms" 
                        :key="room.id"
                        @click="selectedRoom = room.id"
                        class="px-4 py-2 border-b-2 transition font-medium"
                        :class="selectedRoom === room.id 
                            ? 'border-blue-600 text-blue-600' 
                            : 'border-transparent text-gray-600 hover:text-black'"
                    >
                        {{ room.name }}
                    </button>
                </div>

                <!-- Time Slot Cards -->
                <div v-if="selectedRoom && selectedDate" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div 
                        v-for="slot in filteredSlots" 
                        :key="slot.id"
                        @click="!slot.is_booked && openBookingModal(slot)"
                        class="p-4 rounded-lg shadow text-center border cursor-pointer transition"
                        :class="slot.is_booked 
                            ? 'bg-gray-300 text-gray-600 cursor-not-allowed' 
                            : 'bg-green-100 hover:bg-green-200'"
                    >
                        <div class="font-semibold">
                                {{ formatTime(slot.start_time) }} - {{ formatTime(slot.end_time) }}
                        </div>
                        <div v-if="slot.is_booked" class="text-sm text-red-600 font-medium mt-1">
                            Booked
                        </div>
                        <div v-else class="text-sm text-green-700 font-medium mt-1">
                            Available
                        </div>
                    </div>

                </div>

                <div v-else class="text-gray-500 mt-4">
                    Choose a room and date to see available slots.
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div 
            v-if="showModal" 
            class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
        >
            <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full">
                <h3 class="text-xl font-semibold mb-4">Confirm Booking</h3>

                <p class="text-gray-700 mb-3">
                    Room: <b>{{ rooms.find(r => r.id === selectedRoom)?.name }}</b>
                </p>
                <p class="text-gray-700 mb-3">
                    Date: <b>{{ selectedDate }}</b>
                </p>
                <p class="text-gray-700 mb-6">
                    Slot: 
                    <b>{{ selectedSlot?.start_time }} - {{ selectedSlot?.end_time }}</b>
                </p>

                <div class="flex justify-end gap-3">
                    <button 
                        class="px-4 py-2 bg-gray-300 rounded"
                        @click="showModal = false"
                    >
                        Cancel
                    </button>

                    <button 
                        class="px-4 py-2 bg-blue-600 text-white rounded"
                        :disabled="isLoading"
                        @click="confirmBooking"
                    >
                        {{ isLoading ? 'Saving...' : 'Confirm' }}
                    </button>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
