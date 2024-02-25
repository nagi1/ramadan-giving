<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { nextTick, onUpdated, ref } from "vue";
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import swal from "sweetalert2";

const form = useForm({
    identifier: null,
    name: null,
    phone: null,
});

onUpdated(() => {
    // Check if givingEntry is in the page props
    if (usePage().props?.givingEntry) {
        const info = usePage().props.givingEntry;
        const name = info.name ?? "بدون اسم";
        const identifier = info.identifier ?? "بدون معرف";
        const phone = info.phone ?? "بدون رقم";
        const id = info.id ?? "بدون رقم";

        swal.fire({
            title: "موجود بالفعل",
            html: `المواطن: ${name} <br> المعرف: ${identifier} <br> الهاتف: ${phone} <br> رقم العملية: ${id}`,
            icon: "error",
            showConfirmButton: true,
        });
    }

    if (usePage().props?.flash?.success) {
        swal.fire({
            title: usePage().props?.flash?.success,
            icon: "success",
            showConfirmButton: true,
        });

        // reset the form
        form.reset();
    }

    if (usePage().props?.flash?.error) {
        swal.fire({
            title: usePage().props?.flash?.error,
            icon: "error",
            showConfirmButton: true,
        });
    }
});

const check = () => {
    form.post(route("check-or-create-giving-entry"), {
        preserveScroll: true,
    });
};

const clearForm = () => {
    nextTick(() => {
        form.reset();
        document.getElementById("identifier").focus();
        form.clearErrors();
        form.name = null;
        form.identifier = null;
        form.phone = null;
    });
};

</script>

<template>
    <AppLayout title="الرئيسية">
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <FormSection @submitted="check">
                <template #title> بيانات المواطن </template>

                <template #description>
                    الرجاء ملئ بيانات احدى الحقول التالية ويفضل ملئ حقل المعرف
                </template>

                <template #form>
                    <!-- identifier -->
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel
                            for="identifier"
                            value="رقم البطاقة او رقم كارنية"
                        />
                        <TextInput
                            id="identifier"
                            v-model="form.identifier"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="identifier"
                        />
                        <InputError
                            :message="form.errors.identifier"
                            class="mt-2"
                        />
                    </div>

                    <!-- Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="الاسم الرباعي" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="name"
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <!-- phone -->
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="phone" value="رقم الموبايل" />
                        <TextInput
                            id="phone"
                            v-model="form.phone"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="phone"
                        />
                        <InputError :message="form.errors.phone" class="mt-2" />
                    </div>
                </template>

                <template #actions>
                    <div class="flex items-center justify-between w-full">
                        <PrimaryButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            تحقق
                        </PrimaryButton>

                        <!-- reset button  on the left side-->
                        <button
                            class="text-sm text-gray-100 underline underline-offset-8"
                            @click.prevent="clearForm"
                        >
                            تفريغ الحقول
                        </button>
                    </div>
                </template>
            </FormSection>

            <hr class="mt-5" />
            <div class="flex flex-col mt-5 space-y-1 text-center text-gray-100">
                <span>تم تصميم وتطوير هذا الموقع بواسطة احمد ناجي</span>
                <span>01122061032</span>
                <span>ahmedflnagi@gmail.com</span>
            </div>
        </div>
    </AppLayout>
</template>
