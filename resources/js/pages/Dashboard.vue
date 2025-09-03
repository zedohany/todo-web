<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ref, watchEffect } from "vue"
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"
import { Progress } from '@/components/ui/progress';
import { UserPlus, Package, Plus, Ellipsis, Activity, ClipboardCheck } from 'lucide-vue-next';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const completed = ref(0);
const inprogress = ref(0);
const notstarted = ref(0);

watchEffect((cleanupFn) => {
    const timer = setTimeout(() => {
        completed.value = 84;
        inprogress.value = 46;
        notstarted.value = 13;
    }, 500)
    cleanupFn(() => clearTimeout(timer))
})

const page = usePage();
const user = page.props.auth.user;

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center">
                <div>
                    <p class="text-2xl font-medium">Welcome Back, <span class="font-bold">{{ user.name }}</span> 👋</p>
                </div>
                <div class="md:flex items-center gap-2 ml-auto hidden">
                    <img src="https://i.pravatar.cc/500?img=1" alt="User Avatar" class="size-8 rounded-md"/>
                    <img src="https://i.pravatar.cc/500?img=52" alt="User Avatar" class="size-8 rounded-md"/>
                    <img src="https://i.pravatar.cc/500?img=15" alt="User Avatar" class="size-8 rounded-md"/>
                    <div class="relative inline-block">
                        <img src="https://i.pravatar.cc/500?img=11" alt="User Avatar" class="size-8 rounded-md"/>
                        <div class="absolute rounded-md inset-0 bg-black/50 flex justify-center items-center">
                            <span class="text-white text-lg">4+</span>
                        </div>
                    </div>
                    <Button class="ml-4" variant="outline" size="lg"><UserPlus />Invite</Button>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:min-h-min">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-1"><Package /><span>To-Do</span><Button class="ml-auto" variant="outline"><Plus />Add Task</Button></CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div>
                            <Card class="mb-4">
                                <CardHeader>
                                    <CardTitle class="flex gap-2">
                                        <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 7.67126C1 9.26256 1.63214 10.7887 2.75736 11.9139C3.88258 13.0391 5.4087 13.6713 7 13.6713C8.5913 13.6713 10.1174 13.0391 11.2426 11.9139C12.3679 10.7887 13 9.26256 13 7.67126C13 6.07997 12.3679 4.55384 11.2426 3.42862C10.1174 2.30341 8.5913 1.67126 7 1.67126C5.4087 1.67126 3.88258 2.30341 2.75736 3.42862C1.63214 4.55384 1 6.07997 1 7.67126Z" stroke="#F21E1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="mr-auto">
                                            Attend Nischal’s Birthday Party
                                        </span>
                                        <DropdownMenu>
                                            <DropdownMenuTrigger class="flex items-center gap-1">
                                                <Ellipsis />
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="start">
                                                <DropdownMenuItem>Themes</DropdownMenuItem>
                                                <DropdownMenuItem>GitHub</DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </CardTitle>
                                </CardHeader>
                                <cardContent class="flex gap-2">
                                    <p class="text-muted-foreground">Buy gifts on the way and pick up cake from the bakery. (6 PM | Fresh Elements).....</p>
                                    <img class="size-25 rounded-lg" src="https://i.pravatar.cc/500?img=65" alt="Img Avatar" />
                                </cardContent>
                                <CardFooter class="flex gap-2">
                                    <p>Priority: <span class="text-[#42ADE2]">Moderate</span></p>
                                    <p>Status: <span class="text-[#F21E1E]">Not Started</span></p>
                                    <p class="text-muted-foreground">Created on: 20/06/2023</p>
                                </CardFooter>
                            </Card>
                            <Card>
                                <CardHeader>
                                    <CardTitle class="flex gap-2">
                                        <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 7.67126C1 9.26256 1.63214 10.7887 2.75736 11.9139C3.88258 13.0391 5.4087 13.6713 7 13.6713C8.5913 13.6713 10.1174 13.0391 11.2426 11.9139C12.3679 10.7887 13 9.26256 13 7.67126C13 6.07997 12.3679 4.55384 11.2426 3.42862C10.1174 2.30341 8.5913 1.67126 7 1.67126C5.4087 1.67126 3.88258 2.30341 2.75736 3.42862C1.63214 4.55384 1 6.07997 1 7.67126Z" stroke="#0225FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="mr-auto">
                                            Landing Page Design for TravelDays
                                        </span>
                                        <DropdownMenu>
                                            <DropdownMenuTrigger class="flex items-center gap-1">
                                                <Ellipsis />
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="start">
                                                <DropdownMenuItem>Themes</DropdownMenuItem>
                                                <DropdownMenuItem>GitHub</DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </CardTitle>
                                </CardHeader>
                                <cardContent class="flex gap-2">
                                    <p class="text-muted-foreground">Get the work done by EOD and discuss with client before leaving. (4 PM | Meeting Room)</p>
                                    <img class="size-25 rounded-lg" src="https://i.pravatar.cc/500?img=62" alt="Img Avatar" />
                                </cardContent>
                                <CardFooter class="gap-4">
                                    <p>Priority: <span class="text-[#42ADE2]">Moderate</span></p>
                                    <p>Status: <span class="text-[#0225FF]">In Progress</span></p>
                                    <p class="text-muted-foreground">Created on: 20/06/2023</p>
                                </CardFooter>
                            </Card>
                        </div>
                    </CardContent>
                </Card>
                <div class="flex flex-col gap-4">
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-1"><Activity />Task Status</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="flex flex-col gap-2">
                                <div class="gap-1">
                                    <p class="font-medium">Completed</p>
                                    <div class="flex items-center gap-1">
                                        <Progress v-model="completed"/>
                                        <span>{{ completed }}%</span>
                                    </div>
                                </div>
                                <div class="gap-1">
                                    <p class="font-medium">In Progress</p>
                                    <div class="flex items-center gap-1">
                                        <Progress v-model="inprogress"/>
                                        <span>{{ inprogress }}%</span>
                                    </div>
                                </div>
                                <div class="gap-1">
                                    <p class="font-medium">Not Started</p>
                                    <div class="flex items-center gap-1">
                                        <Progress v-model="notstarted"/>
                                        <span>{{ notstarted }}%</span>
                                    </div>
                                </div>

                            </div>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-1"><ClipboardCheck />Completed Task</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <Card class="mb-4">
                                <CardHeader>
                                    <CardTitle class="flex gap-2">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 7C1 8.5913 1.63214 10.1174 2.75736 11.2426C3.88258 12.3679 5.4087 13 7 13C8.5913 13 10.1174 12.3679 11.2426 11.2426C12.3679 10.1174 13 8.5913 13 7C13 5.4087 12.3679 3.88258 11.2426 2.75736C10.1174 1.63214 8.5913 1 7 1C5.4087 1 3.88258 1.63214 2.75736 2.75736C1.63214 3.88258 1 5.4087 1 7Z" stroke="#05A301" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="mr-auto">
                                            Attend Nischal’s Birthday Party
                                        </span>
                                        <DropdownMenu>
                                            <DropdownMenuTrigger class="flex items-center gap-1">
                                                <Ellipsis />
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="start">
                                                <DropdownMenuItem>Themes</DropdownMenuItem>
                                                <DropdownMenuItem>GitHub</DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </CardTitle>
                                </CardHeader>
                                <cardContent class="flex gap-2">
                                    <p class="text-muted-foreground">Buy gifts on the way and pick up cake from the bakery. (6 PM | Fresh Elements).....</p>
                                    <img class="size-25 rounded-lg" src="https://i.pravatar.cc/500?img=60" alt="Img Avatar" />
                                </cardContent>
                                <CardFooter class="gap-4">
                                    <p>Status: <span class="text-[#05A301]">Completed</span></p>
                                    <p class="text-muted-foreground">Completed 2 days ago.</p>
                                </CardFooter>
                            </Card>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
