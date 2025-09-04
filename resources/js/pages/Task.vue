<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { Link } from '@inertiajs/vue3';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Ellipsis, Trash, FilePenLine, ClipboardCheck, Plus } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'My Task',
        href: 'mytask',
    }
];
</script>

<template>
    <Head title="My Task" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="flex flex-col gap-6 sm:flex-row sm:gap-4">
                <!-- Card 1: My Tasks -->
                <Card class="w-full sm:w-1/2">
                    <CardHeader>
                        <CardTitle class="flex gap-1 items-center"><ClipboardCheck /><span>My Tasks</span>
                            <!--suppress HtmlUnknownTarget -->
                            <Link class="ml-auto" href="tasks/create">
                                <Button variant="outline"><Plus />Add Task</Button>
                            </Link>
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Card class="mb-4">
                            <CardHeader>
                                <CardTitle class="flex items-center gap-2 text-base sm:text-lg">
                                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 7.67126C1 9.26256 1.63214 10.7887 2.75736 11.9139C3.88258 13.0391 5.4087 13.6713 7 13.6713C8.5913 13.6713 10.1174 13.0391 11.2426 11.9139C12.3679 10.7887 13 9.26256 13 7.67126C13 6.07997 12.3679 4.55384 11.2426 3.42862C10.1174 2.30341 8.5913 1.67126 7 1.67126C5.4087 1.67126 3.88258 2.30341 2.75736 3.42862C1.63214 4.55384 1 6.07997 1 7.67126Z" stroke="#F21E1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="flex-1">
                                        Attend Nischal’s Birthday Party
                                    </span>
                                    <DropdownMenu>
                                        <DropdownMenuTrigger class="flex items-center gap-1">
                                            <Ellipsis class="h-5 w-5" />
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="start">
                                            <DropdownMenuItem>Themes</DropdownMenuItem>
                                            <DropdownMenuItem>GitHub</DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </CardTitle>
                            </CardHeader>
                            <CardContent class="flex flex-col sm:flex-row gap-4">
                                <p class="text-sm sm:text-base text-muted-foreground flex-1">
                                    Buy gifts on the way and pick up cake from the bakery. (6 PM | Fresh Elements)...
                                </p>
                                <img class="w-full sm:w-24 h-24 rounded-lg object-cover" src="https://i.pravatar.cc/500?img=1" alt="Img Avatar" />
                            </CardContent>
                            <CardFooter class="flex flex-col sm:flex-row gap-4 text-sm sm:text-base">
                                <p>Priority: <span class="text-[#42ADE2]">Moderate</span></p>
                                <p>Status: <span class="text-[#F21E1E]">Not Started</span></p>
                                <p class="text-muted-foreground">Created on: 20/06/2023</p>
                            </CardFooter>
                        </Card>
                    </CardContent>
                </Card>

                <!-- Card 2: Walk the Dog -->
                <Card class="w-full sm:w-1/2">
                    <CardContent class="h-full flex flex-col gap-4">
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <img class="w-full sm:w-40 h-40 rounded-lg object-cover" src="https://i.pravatar.cc/500?img=1" alt="Img Avatar" />
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
                                Listen to a podcast or audiobook, practice mindfulness or meditation, take photos of interesting sights along the way, practice obedience training with your dog, chat with neighbors or other dog walkers, listen to music or an upbeat playlist.
                            </p>
                        </div>
                    </CardContent>
                    <CardFooter class="gap-2 justify-end">
                        <Button variant="destructive"><Trash class="h-5 w-5" /></Button>
                        <Button variant="outline"><FilePenLine class="h-5 w-5" /></Button>
                    </CardFooter>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
