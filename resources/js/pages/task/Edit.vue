<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { index, create } from '@/routes/tasks';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Textarea } from "@/components/ui/textarea"
import { Label } from "@/components/ui/label"
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"
import { toast } from "vue-sonner";
import Heading from '@/components/Heading.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Tasks',
        href: index().url,
    },
    {
        title: 'Create Task',
        href: create().url,
    }
];

const page = usePage();


const task = page.props.task as {
    id: number;
    title: string;
    description: string;
    deadline: null;
    image: string | null;
    priority: { id: number; name: string; color: string } | null;
    category: { id: number; name: string } | null;
};

const priorities = page.props.priorities as { id: number; name: string; color: string }[];
const categories = page.props.categories as { id: number; name: string }[];

const deadline = task.deadline ? new Date(task.deadline) : null;

alert(task.image);

const form = useForm({
    title: task.title || '',
    description: task.description || '',
    deadline: deadline ? deadline.toISOString().split('T')[0] : '',
    priority_id: task.priority ? task.priority.id.toString() : '',
    category_id: task.category ? task.category.id.toString() : '',
    image: null as File | null,
});

function randomInteger(max: number) {
    return Math.floor(Math.random() * (max + 1));
}

function randomRgbColor() {
    let r = randomInteger(255);
    let g = randomInteger(255);
    let b = randomInteger(255);
    return [r, g, b];
}

function randomHexColor() {
    let [r, g, b] = randomRgbColor();
    let hr = r.toString(16).padStart(2, '0');
    let hg = g.toString(16).padStart(2, '0');
    let hb = b.toString(16).padStart(2, '0');
    return "#" + hr + hg + hb;
}

// const priorities = [
//     { id: 1, name: 'High' },
//     { id: 2, name: 'Medium' },
//     { id: 3, name: 'Low' },
// ];

// const categories = [
//     { id: 1, name: 'Work' },
//     { id: 2, name: 'Personal' },
// ];

const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files?.length) {
        form.image = target.files[0];
    }
};

const submitForm = () => {
    form.post('/tasks/create', {
        onSuccess: () => {
            toast.success('Task has been created', {
                description: 'The good news is that your task has been created successfully.',
                action: {
                    label: 'Close',
                    onClick: () => console.log('Closed toast'),
                },
            })
            form.reset();
        },
        onError: (errors) => {
            // toast({
            //     title: "Error",
            //     description: "Please check the form for errors",
            //     variant: "destructive",
            // });
        },
    });
};
</script>

<template>

    <Head title="Create Task" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-col gap-4 p-4">
            <!-- Header -->
            <div class="text-center sm:text-left -mb-8">
                <Heading title="Add New Task" description="Fill in the details to create a new task" />
            </div>

            <!-- Main Form Container -->
            <div class="flex flex-col rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
                <div class="flex flex-col overflow-auto p-4">
                    <form @submit.prevent="submitForm">

                        <!-- Form Validation Summary -->
                        <div v-if="Object.keys(form.errors).length > 0"
                            class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                        Please fix the following errors:
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                        <ul class="list-disc space-y-1 pl-5">
                                            <li v-for="(error, field) in form.errors" :key="field">
                                                {{ error }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Grid Layout for responsive design -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                            <!-- Title Field - Full width on all screens -->
                            <div class="md:col-span-2">
                                <Label for="title" class="text-sm font-medium mb-2">
                                    Title <span class="text-red-500">*</span>
                                </Label>
                                <Input v-model="form.title" id="title" placeholder="Enter task title" required
                                    :error="form.errors.title" class="w-full" />
                            </div>

                            <!-- Description Field - Full width on all screens -->
                            <div class="md:col-span-2">
                                <Label for="description" class="text-sm font-medium mb-2">
                                    Description <span class="text-red-500">*</span>
                                </Label>
                                <Textarea v-model="form.description" id="description"
                                    placeholder="Enter task description (optional)" :error="form.errors.description"
                                    class="w-full min-h-[100px] resize-y" />
                            </div>

                            <!-- Deadline Field -->
                            <div>
                                <Label for="deadline" class="text-sm font-medium mb-2">
                                    Deadline <span class="text-red-500">*</span>
                                </Label>
                                <Input v-model="form.deadline" id="deadline" type="date" :error="form.errors.deadline"
                                    class="w-full" />
                            </div>

                            <!-- Image Upload Field -->
                            <div>
                                <Label for="image" class="text-sm font-medium mb-2">
                                    Task Image
                                </Label>
                                <Input type="file" id="image" accept="image/*" @change="handleImageUpload"
                                    :error="form.errors.image"
                                    class="w-full file:items-center file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" />
                            </div>

                            <!-- Priority Selection -->
                            <div>
                                <Label for="priority" class="text-sm font-medium mb-2">
                                    Priority <span class="text-red-500">*</span>
                                </Label>
                                <Select v-model="form.priority_id">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Select Priority" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Select Priority</SelectLabel>
                                            <SelectItem v-for="priority in priorities" :key="priority.id"
                                                :value="priority.id.toString()">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-3 h-3 rounded-full"
                                                        :style="{ backgroundColor: priority.color }" />
                                                    {{ priority.name }}
                                                </div>
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </div>

                            <!-- Category Selection -->
                            <div>
                                <Label for="category" class="text-sm font-medium mb-2">
                                    Category <span class="text-red-500">*</span>
                                </Label>
                                <Select v-model="form.category_id">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Select Category" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Select Category</SelectLabel>
                                            <SelectItem v-for="category in categories" :key="category.id"
                                                :value="category.id.toString()">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-3 h-3 rounded-sm"
                                                        :style="{ backgroundColor: randomHexColor() }"></div>
                                                    {{ category.name }}
                                                </div>
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-4 sm:pt-6">
                            <Button type="button" variant="outline" class="w-full sm:w-auto order-2 sm:order-1"
                                @click="form.reset()">
                                Reset Form
                            </Button>
                            <Button type="submit" :disabled="form.processing || !form.title.trim()"
                                class="w-full sm:flex-1 order-1 sm:order-2">
                                <svg v-if="form.processing"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white dark:text-gray-800"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                {{ form.processing ? 'Creating Task...' : 'Create Task' }}
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>