<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { index } from '@/routes/tasks';
import { create } from '@/routes/tasks';
import { Link } from '@inertiajs/vue3';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Ellipsis, Trash, FilePenLine, ClipboardCheck, Plus, Images } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'My Tasks',
        href: index().url,
    }
];

const page = usePage();
const tasks = page.props.tasks as Array<{
    id: number; title: string; description: string; created_at: string; deadline: string; status: string; image: string;
    priority: { id: number; name: string; color: string; };
    category: {
        id: number; name: string;

    };
}>;

function formatDate(dateString: string) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

function randomInteger(max :number) {
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
</script>

<template>

    <Head title="My Task" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="flex flex-col gap-6 sm:flex-row sm:gap-4">
                <!-- Card 1: My Tasks -->
                <Card class="w-full sm:w-1/2">
                    <CardHeader>
                        <CardTitle class="flex gap-1 items-center">
                            <ClipboardCheck /><span>My Tasks</span>
                            <!--suppress HtmlUnknownTarget -->
                            <Link class="ml-auto" :href="create().url">
                            <Button variant="outline">
                                <Plus />Add Task
                            </Button>
                            </Link>
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Card v-for="task in tasks" :key="task.id" class="mb-4">
                            <CardHeader>
                                <CardTitle class="flex items-center gap-2 text-base sm:text-lg">
                                    <div class="w-[14px] h-[15px] rounded-full border-3"
                                        style="box-sizing: border-box;" :style="{borderColor: task.priority.color}" />
                                    <span class="flex-1">
                                        {{ task.title }}
                                    </span>
                                    <DropdownMenu>
                                        <DropdownMenuTrigger class="flex items-center gap-1">
                                            <Ellipsis class="h-5 w-5" />
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="start">
                                            <DropdownMenuItem>Edit</DropdownMenuItem>
                                            <DropdownMenuItem>Delete</DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </CardTitle>
                            </CardHeader>
                            <CardContent class="flex flex-col sm:flex-row gap-4">
                                <p class="text-sm text-muted-foreground flex-1 line-clamp-4">
                                    {{ task.description }}
                                </p>
                                <img v-if="task.image" class="w-full sm:w-24 h-24 rounded-xl object-cover"
                                    :src="task.image" :alt="task.title" />
                                <div v-else
                                    class="w-full sm:w-24 h-24 rounded-xl bg-gray-200 flex items-center justify-center text-gray-500">
                                    <Images class="w-10 h-10" />
                                </div>
                            </CardContent>
                            <CardFooter
                                class="flex flex-col gap-2 sm:items-center sm:justify-between text-sm sm:text-base">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                    <p class="font-medium">Priority: <span :style="{color: task.priority.color}">{{
                                        task.priority.name }}</span></p>
                                    <p class="font-medium">Status: <span class="text-[#F21E1E]">
                                            {{ task.status }}</span></p>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 text-muted-foreground">
                                    <p>Created on: {{ formatDate(task.created_at) }}</p>
                                    <p>Deadline on: {{ formatDate(task.deadline) }}</p>
                                </div>
                            </CardFooter>
                        </Card>
                    </CardContent>
                </Card>

                <!-- Card 2: Walk the Dog -->
                <Card class="w-full sm:w-1/2">
                    <CardContent class="h-full flex flex-col gap-4">
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <img class="w-full sm:w-40 h-40 rounded-lg object-cover"
                                src="https://i.pravatar.cc/500?img=1" alt="Img Avatar" />
                            <div class="flex flex-col gap-2 text-center sm:text-left">
                                <p class="text-lg sm:text-2xl font-bold">
                                    Walk the dog
                                </p>
                                <p>Priority: <span class="text-[#42ADE2]">Extreme</span></p>
                                <p>Status: <span class="text-[#F21E1E]">Not Started</span></p>
                                <p class="text-muted-foreground">Created on: 20/06/2023</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm sm:text-base">
                                Listen to a podcast or audiobook, practice mindfulness or meditation, take photos of
                                interesting sights along the way, practice obedience training with your dog, chat with
                                neighbors or other dog walkers, listen to music or an upbeat playlist.
                            </p>
                        </div>
                    </CardContent>
                    <CardFooter class="gap-2 justify-end">
                        <Button variant="destructive">
                            <Trash class="h-5 w-5" />
                        </Button>
                        <Button variant="outline">
                            <FilePenLine class="h-5 w-5" />
                        </Button>
                    </CardFooter>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
