<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { index } from '@/routes/tasks';
import { create, updateStatus } from '@/routes/tasks';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger
} from '@/components/ui/dropdown-menu';
import {
    Ellipsis,
    Trash,
    FilePenLine,
    ClipboardCheck,
    Plus,
    Images,
    Clipboard,
    Calendar,
    Clock,
    Eye
} from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import Heading from '@/components/Heading.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Tasks',
        href: index().url,
    }
];

const page = usePage();

const tasks = computed(() => {
    const taskList = page.props.tasks as Array<{
        id: number;
        title: string;
        description: string;
        created_at: string;
        deadline: string;
        status: string;
        image: string;
        priority: { id: number; name: string; color: string };
        category: { id: number; name: string };
    }>;

    // Sort tasks from newest to oldest
    return taskList.sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime());
});

function formatDate(dateString: string) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function isOverdue(deadline: string) {
    return new Date(deadline) < new Date() && new Date().getTime() - new Date(deadline).getTime() > 0;
}

function getDaysRemaining(deadline: string) {
    const diff = new Date(deadline).getTime() - new Date().getTime();
    const days = Math.ceil(diff / (1000 * 3600 * 24));
    return days;
}

const makeComplete = (id: number) => {
    router.put(updateStatus(id).url, {}, {
        preserveScroll: true,
    });
};

const getStatusVariant = (status: string) => {
    const variants: { [key: string]: string } = {
        'open': 'secondary',
        'completed': 'default',
        'closed': 'destructive'
    };

    return variants[status] || 'secondary';
};
</script>

<template>
    <Head title="My Tasks" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen p-4">
            <div>
                <!-- Header Section -->
                <div>
                    <div class="flex justify-between">
                        <Heading class="-mb-8" title="My Tasks" description="Manage and track your tasks efficiently" />
                        <Link :href="create().url">
                        <Button size="lg">
                            <Plus class="w-5 h-5 mr-2" />
                            Add New Task
                        </Button>
                        </Link>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <Card>
                        <CardHeader>
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-blue-100 rounded-full">
                                    <Clipboard class="w-6 h-6 text-blue-600" />
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ tasks.length }}</p>
                                    <p class="text-muted-foreground">Total Tasks</p>
                                </div>
                            </div>
                        </CardHeader>
                    </Card>

                    <Card>
                        <CardHeader>
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-green-100 rounded-full">
                                    <ClipboardCheck class="w-6 h-6 text-green-600" />
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{tasks.filter(t => t.status === 'completed').length
                                        }}</p>
                                    <p class="text-muted-foreground">Completed</p>
                                </div>
                            </div>
                        </CardHeader>
                    </Card>

                    <Card>
                        <CardHeader>
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-orange-100 rounded-full">
                                    <Clock class="w-6 h-6 text-orange-600" />
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{tasks.filter(t => t.status === 'open').length}}
                                    </p>
                                    <p class="text-muted-foreground">Open</p>
                                </div>
                            </div>
                        </CardHeader>
                    </Card>
                </div>

                <!-- Tasks Grid -->
                <div v-if="tasks.length > 0" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    <Card v-for="task in tasks" :key="task.id">
                        <!-- Task Image/Icon -->
                        <div class="relative h-48 -mt-6 overflow-hidden rounded-t-lg group">
                            <img v-if="task.image" :src="task.image" :alt="task.title"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <div v-else
                                class="w-full h-full bg-muted flex items-center justify-center">
                                <Images class="w-16 h-16 dark:text-white opacity-60" />
                            </div>

                            <!-- Priority Badge -->
                            <div class="absolute top-3 left-3">
                                <Badge variant="outline"
                                    :style="{ backgroundColor: task.priority.color, color: 'white', borderColor: task.priority.color }"
                                    class="px-3 py-1 font-bold shadow-lg">
                                    {{ task.priority.name }}
                                </Badge>
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3">
                                <Badge :variant="getStatusVariant(task.status)" class="px-3 py-1 font-bold shadow-lg">
                                    {{ task.status }}
                                </Badge>
                            </div>

                            <!-- Dropdown Menu -->
                            <div class="absolute bottom-3 right-3">
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                        <Button size="sm">
                                            <Ellipsis class="w-4 h-4" />
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end" class="w-48">
                                        <DropdownMenuItem v-if="task.status === 'open'" @click="makeComplete(task.id)"
                                            class="cursor-pointer">
                                            <ClipboardCheck class="w-4 h-4 mr-2" />
                                            Mark as Complete
                                        </DropdownMenuItem>
                                        <DropdownMenuItem class="cursor-pointer">
                                            <Eye class="w-4 h-4 mr-2" />
                                            View Details
                                        </DropdownMenuItem>
                                        <DropdownMenuItem class="cursor-pointer">
                                            <FilePenLine class="w-4 h-4 mr-2" />
                                            Edit Task
                                        </DropdownMenuItem>
                                        <DropdownMenuItem class="cursor-pointer text-destructive">
                                            <Trash class="w-4 h-4 mr-2" />
                                            Delete Task
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </div>
                        </div>

                        <!-- Task Content -->
                        <CardHeader class="pb-3">
                            <CardTitle>
                                {{ task.title }}
                            </CardTitle>
                        </CardHeader>

                        <CardContent class="py-0">
                            <p class=" text-sm leading-relaxed line-clamp-3 mb-4">
                                {{ task.description }}
                            </p>

                            <!-- Category -->
                            <div class="flex items-center gap-2 mb-4">
                                <Badge variant="outline" class="text-xs">
                                    {{ task.category.name }}
                                </Badge>
                            </div>
                        </CardContent>

                        <CardFooter class="pt-4 mt-auto border-t">
                            <div class="w-full space-y-3">
                                <!-- Dates -->
                                <div class="grid grid-cols-1 gap-2 text-xs">
                                    <div class="flex items-center gap-2 text-muted-foreground">
                                        <Calendar class="w-4 h-4" />
                                        <span>Created: {{ formatDate(task.created_at) }}</span>
                                    </div>
                                    <div class="flex items-center gap-2"
                                        :class="isOverdue(task.deadline) && task.status === 'open' ? 'text-destructive' : 'text-muted-foreground'">
                                        <Clock class="w-4 h-4" />
                                        <span>Deadline: {{ formatDate(task.deadline) }}</span>
                                        <Badge v-if="task.status === 'open'" variant="outline" class="text-xs px-2 py-1"
                                            :class="getDaysRemaining(task.deadline) < 0 ? 'border-destructive text-destructive' : getDaysRemaining(task.deadline) <= 3 ? 'border-yellow-500 text-yellow-600' : 'border-green-500 text-green-600'">
                                            {{ getDaysRemaining(task.deadline) < 0 ?
                                                `${Math.abs(getDaysRemaining(task.deadline))} days overdue` :
                                                getDaysRemaining(task.deadline)===0 ? 'Due today' :
                                                `${getDaysRemaining(task.deadline)} days left` }} </Badge>
                                    </div>
                                </div>
                            </div>
                        </CardFooter>
                    </Card>
                </div>

                <!-- Empty State -->
                <Card v-else class="bg-white border-0 shadow-lg">
                    <CardContent class="py-16">
                        <div class="text-center space-y-6">
                            <div class="mx-auto w-32 h-32 bg-muted rounded-full flex items-center justify-center">
                                <Clipboard class="w-16 h-16 text-muted-foreground" />
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-2xl font-bold text-foreground">No tasks yet</h3>
                                <p class="text-muted-foreground text-lg max-w-md mx-auto">
                                    Get started by creating your first task
                                </p>
                            </div>
                            <Link :href="create().url">
                            <Button size="lg" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 text-lg">
                                <Plus class="w-5 h-5 mr-2" />
                                Add New Task
                            </Button>
                            </Link>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>